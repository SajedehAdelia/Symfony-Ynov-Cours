<?php

namespace App\Controller;

use App\Entity\PlaceName;
use App\Repository\PlaceNameRepository;
use Symfony\Bundle\FrameworkBundle\Console\Descriptor\JsonDescriptor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FramworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Serializer\SerializerInterface;

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
    /**
     * Calling all the information together
     */
   
    #[Route('/api/place', name: 'place.getAll')]
    public function getAllplace(PlaceNameRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $place = $repository->findAll();
        $jsonPlaceName = $serializer->serialize($place, 'json');
        return new JsonResponse($jsonPlaceName, Response::HTTP_OK, [], true);
    }

    /**#[Route("/api/place/{id}", name: "place.get", methods: ['GET'])]
    public function getPlaces(int $id, PlaceNameRepository $repository, SerializerInterface $serializer):JsonResponse
    {
        $place = $repository->find(id);
        $jsonPlaceName = $serializer->serialize($place, 'json');
        return $place ?
        new JsonResponse($jsonPlaceName, Reponse::HTTP_OK, [], true):
        new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }*/

    //this one is one working :) ask later!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    #[Route('/api/place/{id}', name: 'place.get', methods: ['GET'])]
    #[ParamConverter("place", options : ["id"=>"idPlace"])]
    public function getPlaces(int $id, PlaceName $place, PlaceNameRepository $repository, SerializerInterface $serializer):JsonResponse
    {
        $place = $repository->find($id);
        $jsonPlaceName = $serializer->serialize($place, 'json') ;
        return new JsonResponse($jsonPlaceName, Response::HTTP_OK, [], true);
    } 
}       
   
    

