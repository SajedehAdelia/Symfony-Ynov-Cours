<?php

namespace App\Controller;

use App\Entity\PlaceName;
use App\Repository\PlaceNameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Console\Descriptor\JsonDescriptor;

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
        $place = $repository->findAll()->where('status', true);
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

    //this one is not working :) ask later!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    #[Route('/api/place/{id}', name: 'place.get', methods: ['GET'])]
    #[ParamConverter('place', options : ["id"=>"idPlace"])]
    public function getPlaces(int $id, PlaceNameRepository $repository, SerializerInterface $serializer):JsonResponse
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
/***a major question : the functions like remove,flush, getContect ect ...  they are defined where? Cause for example  i understand setstatut 
 * was explained in PlaceName.php, but the other functions come from where exacly?
 * Also why in createPlace we have name as place.turnoff?
 * 
 */
    #[Route('/api/place', name: 'place.turnOff', methods: ['POST'])]
    #[IsGranted('ADMIN', message: 'Hahahaaaaaa you cannot get it!')]
    public function createPlaceName(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer) :JsonResponse
    {
        $placeName = $serializer->deserialize($request->getContent(), PlaceName::class,'json' );
        $placeName->setStatusPlaceName(true);
        $entityManager->persist($placeName);
        $entityManager->flush();
        $jsonPlaceName = $serializer->serialize($placeName, 'json');
        return new JsonResponse($jsonPlaceName, Response::HTTP_CREATED, [], true);
    }

    #[Route('/api/place/{idPlace}', name: 'place.update', methods: ['PUT'])]
    #[ParamConverter("placeName", options : ["id"=>"idPlace"])]
    public function updateplaceName(PlaceName $placeName, Request $request, PlaceNameRepository $repository,
                                    EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
            $uptadePlaceName = $serializer->deserialize($request->getContent(), PlaceName::class,'json', 
            [AbstractNormalizer::OBJECT_TO_POPULATE=> $placeName]);

            $request->toArray();       
            $uptadePlaceName->setStatusPlaceName(true);
            $entityManager->persist($placeName);
            $entityManager->flush();
            $jsonPlaceName = $serializer->serialize($uptadePlaceName, 'json');
            return new JsonResponse($jsonPlaceName, Response::HTTP_RESET_CONTENT, [], true);  //and this
    }
}       
    

