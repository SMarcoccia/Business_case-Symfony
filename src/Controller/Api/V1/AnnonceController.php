<?php

namespace App\Controller\Api\V1;

use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api/v1/annonces", name="api_v1_annonce_")
 */
class AnnonceController extends AbstractController
{
    /**
     * Affiche la liste des annonces.
     * 
     * @Route("", name="list", methods={"GET"})
     */
    public function list(AnnonceRepository $annonceRepository, Request $request): Response
    {
        $groupe = $annonceRepository->findAnnonces(
            $request->query->get('marque'), 
            $request->query->get('modele'), 
            $request->query->get('carburant'), 
            $request->query->get('min_year'), 
            $request->query->get('max_year'), 
            $request->query->get('min_km'), 
            $request->query->get('max_km'), 
            $request->query->get('min_price'), 
            $request->query->get('max_price')
        );
   
        return $this->json($groupe, 200, [], [
            'groups' => ['list_annonce']
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Annonce $annonce): Response
    {
        return $this->json($annonce, 200, [], [
            'groups' => ['annonce', 'annonce_garage', "annonce_modele", "annonce_marque", "annonce_photo"]
        ]);
    }

    /**
     * Ajout d'une annonce.
     *
     * @Route("", name="add", methods={"POST"})
     * 
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {
        $json = json_decode($request->getContent(), true);

        $annonce = new Annonce();

        $form = $this->createForm(AnnonceType::class, $annonce, ['csrf_protection' => false]);
        $form->submit($json, false);
        dump($annonce->getId());
        dd($form);

        if($form->isValid()){
            $annonce->setReference($annonce->getId());
            $em = $this->getDoctrine()->getManager();
            $em->persist($annonce);
            
            $em->flush();

            return $this->json($annonce, 201, [], [
                'groups' => ['annonce', 'annonce_garage', "annonce_marque", "annonce_modele", "annonce_photo"],
            ]);
        }

        return $this->json([
            "code" => 400,
            "message" => (string)$form->getErrors(true, true),
        ], 400);
    }

    /**
     * Edite une annonce.
     *
     * @Route("/{id}", name="edit", methods={"PUT", "PATCH"})
     * 
     * @param Annonce $annonce
     * @param Request $request
     * @return Response
     */
    public function edit(Annonce $annonce, Request $request): Response
    {
        $json = json_decode($request->getContent(), true);
        $form = $this->createForm(AnnonceType::class, $annonce, ['csrf_protection' => false]);
        $form->submit($json, false);
        
        if($form->isValid()){
            $annonce->setUpdatedAt(new \DateTime()); // Mettre heure française ou d'hiver.
            $this->getDoctrine()->getManager()->flush();

            return $this->json($annonce, 200, [], [
                'groups' => ['annonce', 'annonce_photo'],
            ]);
        }

        return $this->json([
            'code' => 400,
            'message' => (string)$form->getErrors(true, true),
        ], 400);
    }

    /**
     * Supprime une annonce.
     *
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * 
     * @param Annonce $annonce
     * @return Response
     */
    public function delete(Annonce $annonce): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($annonce);
        $em->flush();

        return $this->json([], 204);
    }
}
