<?php

namespace App\Controller\Api\V1;

use App\Entity\Modele;
use App\Repository\ModeleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api/v1/modele", name="api_v1_model_")
 */
class ModeleController extends AbstractController
{
  /**
     * Affiche la liste des modeles.
     * 
     * @Route("/", name="list", methods={"GET"})
     */
    public function listModele(ModeleRepository $modelRepository): Response
    {
        $groupe = $modelRepository->findAll();
   
        return $this->json($groupe, 200, [], [
            'groups' => ['list_modele']
        ]);
    }

    /**
     * Affiche un modèle.
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Modele $modele): Response
    {
        return $this->json($modele, 200, [], [
            'groups' => ['detail_modele']
        ]);
    }

    // /**
    //  * Ajout d'une modele.
    //  *
    //  * @Route("/modele", name="modele_add", methods={"POST"})
    //  * 
    //  * @param Request $request
    //  * @return Response
    //  */
    // public function add(Request $request): Response
    // {
    //     $json = json_decode($request->getContent(), true);

    //     $modele = new Modele();

    //     $form = $this->createForm(ModeleType::class, $modele, ['csrf_protection' => false]);
    //     $form->submit($json, false);
    //     dump($modele->getId());
    //     dd($form);

    //     if($form->isValid()){
    //         $modele->setReference($modele->getId());
    //         $em = $this->getDoctrine()->getManager();
    //         $em->persist($modele);
            
    //         $em->flush();

    //         return $this->json($modele, 201, [], [
    //             'groups' => ['modele', 'modele_garage', "modele_marque", "modele_modele", "modele_photo"],
    //         ]);
    //     }

    //     return $this->json([
    //         "code" => 400,
    //         "message" => (string)$form->getErrors(true, true),
    //     ], 400);
    // }

    // /**
    //  * Edite une modele.
    //  *
    //  * @Route("/modele/{id}", name="modele_edit", methods={"PUT", "PATCH"})
    //  * 
    //  * @param Modele $modele
    //  * @param Request $request
    //  * @return Response
    //  */
    // public function edit(Modele $modele, Request $request): Response
    // {
    //     $json = json_decode($request->getContent(), true);
    //     $form = $this->createForm(ModeleType::class, $modele, ['csrf_protection' => false]);
    //     $form->submit($json, false);
        
    //     if($form->isValid()){
    //         $modele->setUpdatedAt(new \DateTime()); // Mettre heure française ou d'hiver.
    //         $this->getDoctrine()->getManager()->flush();

    //         return $this->json($modele, 200, [], [
    //             'groups' => ['modele', 'modele_photo'],
    //         ]);
    //     }

    //     return $this->json([
    //         'code' => 400,
    //         'message' => (string)$form->getErrors(true, true),
    //     ], 400);
    // }

    // /**
    //  * Supprime une modele.
    //  *
    //  * @Route("/modele/{id}", name="modele_delete", methods={"DELETE"})
    //  * 
    //  * @param Modele $modele
    //  * @return Response
    //  */
    // public function delete(Modele $modele): Response
    // {
    //     $em = $this->getDoctrine()->getManager();
    //     $em->remove($modele);
    //     $em->flush();

    //     return $this->json([], 204);
    // }

}


