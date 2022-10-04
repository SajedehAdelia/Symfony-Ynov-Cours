<?php

namespace App\Controller;

use App\Entity\PlaceName;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PlaceController extends AbstractController
{
    #[Route('/place', name: 'app_place')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PlaceController.php',
        ]);
    }

    public function getAllplace(PlaceName $repository, SerializerInterface $serializer): JsonResponse
    {
        $place  =  $repository->findAll();

        return new JsonResponse($place, Response::HTTP_OK,[], false);
    }
}
