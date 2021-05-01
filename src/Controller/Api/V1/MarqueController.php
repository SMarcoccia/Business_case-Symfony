<?php

namespace App\Controller\Api\V1;

use App\Entity\Marque;
use App\Repository\MarqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api/v1/marque", name="api_v1_marque_")
 */
class MarqueController extends AbstractController
{
  /**
     * Affiche la liste des marques.
     * 
     * @Route("/", name="list", methods={"GET"})
     */
    public function listMarque(MarqueRepository $marqueRepository, Request $request): Response
    {
        $groupe = $marqueRepository->findAll();
        
        return $this->json($groupe, 200, [], [
            'groups' => ['list_marque']
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Marque $marque): Response
    {
        return $this->json($marque, 200, [], [
            'groups' => ['detail_marque']
        ]);
    }

    /**
     * Récupère les modèles d'une marque par son id.
     * 
     * @Route("/modeleParMarque/{id}", name="modeleParMarque", methods={"GET"})
     *
     * @param MarqueRepository $marqueRepository
     * @return Response
     */
    public function listModeleByMarque(MarqueRepository $marqueRepository, Request $request, Marque $marque): Response {
        $id = intval($request->attributes->get('id'));

        $groupe = $marqueRepository->findAllModelsByBrand($id);
        return $this->json($groupe, 200, [], [
            'groups' => ['list_modelesByIdMarque']
        ]);
    }


    // /**
    //  * Ajout d'une marque.
    //  *
    //  * @Route("/marque", name="add", methods={"POST"})
    //  * 
    //  * @param Request $request
    //  * @return Response
    //  */
    // public function add(Request $request): Response
    // {
    //     $json = json_decode($request->getContent(), true);

    //     $marque = new Marque();

    //     $form = $this->createForm(Marque::class, $marque, ['csrf_protection' => false]);
    //     $form->submit($json, false);
    //     dump($marque->getId());
    //     dd($form);

    //     if($form->isValid()){
    //         $marque->setReference($marque->getId());
    //         $em = $this->getDoctrine()->getManager();
    //         $em->persist($marque);
            
    //         $em->flush();

    //         return $this->json($marque, 201, [], [
    //             'groups' => ['marque', 'marque_garage', "marque_marque", "marque_modele", "marque_photo"],
    //         ]);
    //     }

    //     return $this->json([
    //         "code" => 400,
    //         "message" => (string)$form->getErrors(true, true),
    //     ], 400);
    // }

    // /**
    //  * Edite une marque.
    //  *
    //  * @Route("/marque/{id}", name="marque_edit", methods={"PUT", "PATCH"})
    //  * 
    //  * @param Marque $marque
    //  * @param Request $request
    //  * @return Response
    //  */
    // public function edit(Marque $marque, Request $request): Response
    // {
    //     $json = json_decode($request->getContent(), true);
    //     $form = $this->createForm(Marque::class, $marque, ['csrf_protection' => false]);
    //     $form->submit($json, false);
        
    //     if($form->isValid()){
    //         $marque->setUpdatedAt(new \DateTime()); // Mettre heure française ou d'hiver.
    //         $this->getDoctrine()->getManager()->flush();

    //         return $this->json($marque, 200, [], [
    //             'groups' => ['marque', 'marque_photo'],
    //         ]);
    //     }

    //     return $this->json([
    //         'code' => 400,
    //         'message' => (string)$form->getErrors(true, true),
    //     ], 400);
    // }

    // /**
    //  * Supprime une marque.
    //  *
    //  * @Route("/marque/{id}", name="marque_delete", methods={"DELETE"})
    //  * 
    //  * @param Marque $marque
    //  * @return Response
    //  */
    // public function delete(Marque $marque): Response
    // {
    //     $em = $this->getDoctrine()->getManager();
    //     $em->remove($marque);
    //     $em->flush();

    //     return $this->json([], 204);
    // }
}


