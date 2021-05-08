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
 * @Route("/api/v1", name="api_v1_")
 */
class AnnonceController extends AbstractController
{
    /**
     * Displays the list of announcements on the home page in the order they were put online. 
     * 
     * @Route("/home", name="home", methods={"GET"})
     */
    public function listAds(
        AnnonceRepository $annonceRepository, 
        Request $request): Response
    {
        $page = $request->query->get('page', 1);
        $resultPerPages = 3;

        $groupe = $annonceRepository->findListAds($page, $resultPerPages);
        $nbPages = ceil($annonceRepository->findNbAds()/$resultPerPages);

        $groupes['data'] = $groupe;
        $groupes['nbPages'] = $nbPages;

        return $this->json($groupes, 200, [], []);
    }

    /**
     * Displays the list of advertisements searched with the search bar. 
     * 
     * @Route("/annonces", name="annonces", methods={"GET"})
     */
    public function listAdsResearched(AnnonceRepository $annonceRepository, Request $request): Response
    {

        $page = $request->query->get('page', 1);
        $resultPerPages = 3;

        $groupe = $annonceRepository->findAdResearched(
            $page, 
            $resultPerPages,
            0,
            $request->query->get('marqueId'), 
            $request->query->get('modele'), 
            $request->query->get('carburant'), 
            $request->query->get('min_year'), 
            $request->query->get('max_year'), 
            $request->query->get('min_kms'), 
            $request->query->get('max_kms'), 
            $request->query->get('min_price'), 
            $request->query->get('max_price')
        );
        $nbPage = ceil(count($groupe)/$resultPerPages);

        $groupe = $annonceRepository->findAdResearched(
            $page, 
            $resultPerPages,
            1,
            $request->query->get('marqueId'), 
            $request->query->get('modele'), 
            $request->query->get('carburant'), 
            $request->query->get('min_year'), 
            $request->query->get('max_year'), 
            $request->query->get('min_kms'), 
            $request->query->get('max_kms'), 
            $request->query->get('min_price'), 
            $request->query->get('max_price'),
        );

        $groupes['data'] = $groupe;
        $groupes['nbPages'] = $nbPage;

        return $this->json($groupes, 200, [], [
            'groups' => ['list_ads']
        ]);
    }

    /**
     * @Route("/annonce/{id}", name="annonce_show", methods={"GET"})
     */
    public function show(Annonce $annonce): Response
    {
        $annonceShow['data'] = $annonce;
        return $this->json($annonceShow, 200, [], [
            'groups' => ['detail_ad']
        ]);
    }

    /**
     * Ajout d'une annonce.
     *
     * @Route("/annonce", name="annonce_add", methods={"POST"})
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
            
            $annonceAdd['data'] = $annonce;

            return $this->json($annonceAdd, 201, [], [
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
     * @Route("/annonce/{id}", name="annonce_edit", methods={"PUT", "PATCH"})
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
            
            $annonceEdit['data'] = $annonce;

            return $this->json($annonceEdit, 200, [], [
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
     * @Route("/annonce/{id}", name="annonce_delete", methods={"DELETE"})
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


