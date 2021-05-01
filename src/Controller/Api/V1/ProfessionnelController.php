<?php

namespace App\Controller\Api\V1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfessionnelController extends AbstractController
{
    /**
     * @Route("/api/v1/professionnel", name="api_v1_professionnel")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/Api/V1/ProfessionnelController.php',
        ]);
    }
}
