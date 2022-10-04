<?php

namespace App\Controller;

use App\Entity\PlaceName;
use App\Repository\PlaceNameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Console\Descriptor\JsonDescriptor;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

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
   
    #[Route('/api/place', name: 'place.getAll', methods:["GET"])]
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
    #[ParamConverter('place', options : ["id"=>"idPlace"])]
    public function getPlaces(int $id, PlaceName $place, PlaceNameRepository $repository, SerializerInterface $serializer):JsonResponse
    {
        $place = $repository->find($id);
        $jsonPlaceName = $serializer->serialize($place, 'json') ;
        return new JsonResponse($jsonPlaceName, Response::HTTP_OK, [], true);
    } 

    #[Route('/api/place/delete/{id}', name: 'place.get', methods: ['DELETE'])]
    #[ParamConverter('placename', options : ['id'=>'idPlace'])]
    public function deletePlace(PlaceName $placename, EntityManagerInterface $entityManager):JsonResponse
    {
        $entityManager->remove($placename);
        $entityManager->flush(); //this one will delete the data in phpMyadmin
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
       
    }

    #[Route('/api/place/{id}', name: 'place.get', methods: ['DELETE'])]
    #[ParamConverter("place", options : ["id"=>"idPlace"])]
    public function statuePlace(PlaceName $placename, EntityManagerInterface $entityManager) :JsonResponse
    {
         $placename->setStatusPlaceName(false);
         $entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);

    }

    #[Route('/api/place', name: 'place.turnOff', methods: ['POST'])]
    public function createPlaceName(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer) :JsonResponse
    {
        $placeName = $serializer->deserialize($request->getContent(), PlaceName::class,'json' );
        $placeName->setStatusPlaceName(true);
        $entityManager->persist($placeName);
        $entityManager->flush();
        $jsonPlaceName = $serializer->serialize($placeName, 'json');
        return new JsonResponse($jsonPlaceName, Response::HTTP_CREATED, [], true);
    }

    #[Route('/api/place/{id}', name: 'place.update', methods: ['PUT'])]
    #[ParamConverter("place", options : ["id"=>"idPlace"])]
    public function updateplaceName(PlaceName $placename, Request $request, PlaceNameRepository $repository,
                                    EntityManagerInterface $entityManager, SerializerInterface $serializer) :JsonResponse
    {
        $uptadePlaceName = $serializer->deserialize($request->getContent(), PlaceName::class,'json', 
            [AbstractNormalizer::OBJECT_TO_POPULATE=> $placename]);

            $content = $request->toArray();
            $place = $repository->find($content["idplace"] ?? -1);       
            $uptadePlaceName->setStatusPlaceName(true);
            $placename->setPlaceID($place);
            $entityManager->persist($placename);
            $entityManager->flush();
    }
}       
    

