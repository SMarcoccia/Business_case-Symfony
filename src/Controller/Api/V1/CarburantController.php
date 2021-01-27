<?php

namespace App\Controller\Api\V1;

use App\Entity\Carburant;
use App\Repository\CarburantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api/v1/carburant", name="api_v1_carburant_")
 */
class CarburantController extends AbstractController
{
  /**
     * Affiche la liste des carburants.
     * 
     * @Route("/", name="list", methods={"GET"})
     */
    public function listCarburant(CarburantRepository $carburantRepository, Request $request): Response
    {
        $groupe = $carburantRepository->findAll();
   
        return $this->json($groupe, 200, [], [
            'groups' => ['list_carburant']
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Carburant $carburant): Response
    {
        return $this->json($carburant, 200, [], [
            'groups' => ['detail_carburant']
        ]);
    }

    // /**
    //  * Ajout d'une carburant.
    //  *
    //  * @Route("/carburant", name="carburant_add", methods={"POST"})
    //  * 
    //  * @param Request $request
    //  * @return Response
    //  */
    // public function add(Request $request): Response
    // {
    //     $json = json_decode($request->getContent(), true);

    //     $carburant = new Carburant();

    //     $form = $this->createForm(CarburantType::class, $carburant, ['csrf_protection' => false]);
    //     $form->submit($json, false);
    //     dump($carburant->getId());
    //     dd($form);

    //     if($form->isValid()){
    //         $carburant->setReference($carburant->getId());
    //         $em = $this->getDoctrine()->getManager();
    //         $em->persist($carburant);
            
    //         $em->flush();

    //         return $this->json($carburant, 201, [], [
    //             'groups' => ['carburant', 'carburant_garage', "carburant_marque", "carburant_modele", "carburant_photo"],
    //         ]);
    //     }

    //     return $this->json([
    //         "code" => 400,
    //         "message" => (string)$form->getErrors(true, true),
    //     ], 400);
    // }

    // /**
    //  * Edite une carburant.
    //  *
    //  * @Route("/carburant/{id}", name="carburant_edit", methods={"PUT", "PATCH"})
    //  * 
    //  * @param Carburant $carburant
    //  * @param Request $request
    //  * @return Response
    //  */
    // public function edit(Carburant $carburant, Request $request): Response
    // {
    //     $json = json_decode($request->getContent(), true);
    //     $form = $this->createForm(CarburantType::class, $carburant, ['csrf_protection' => false]);
    //     $form->submit($json, false);
        
    //     if($form->isValid()){
    //         $carburant->setUpdatedAt(new \DateTime()); // Mettre heure française ou d'hiver.
    //         $this->getDoctrine()->getManager()->flush();

    //         return $this->json($carburant, 200, [], [
    //             'groups' => ['carburant', 'carburant_photo'],
    //         ]);
    //     }

    //     return $this->json([
    //         'code' => 400,
    //         'message' => (string)$form->getErrors(true, true),
    //     ], 400);
    // }

    // /**
    //  * Supprime une carburant.
    //  *
    //  * @Route("/carburant/{id}", name="carburant_delete", methods={"DELETE"})
    //  * 
    //  * @param Carburant $carburant
    //  * @return Response
    //  */
    // public function delete(Carburant $carburant): Response
    // {
    //     $em = $this->getDoctrine()->getManager();
    //     $em->remove($carburant);
    //     $em->flush();

    //     return $this->json([], 204);
    // }
}


