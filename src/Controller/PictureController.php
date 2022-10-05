<?php

namespace App\Controller;

use App\Entity\Picture;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonReponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class PictureController extends AbstractController/**
 * 
 * @param mixed $name
 */


{
    #[Route('/', name: 'app.root')]
    public function index(){


    }
 
    #[Route('/api/picture', name: 'picture.create', methods:['POST'])]
    public function createPicture(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $picture = new Picture();
        $file = $request->files->get('file');

        $picture->setFile($file)
        ->setMimeType($file->getClientMimeType())
        ->setRealName($file->getClientOriginalName())
        ->setPublicPath('/assets/pictures')
        ->setUploadDate(new \DateTime());

        $entityManager->persist($picture);
        $entityManager->flush();



        //dd($file::class);

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PictureController.php',
        ]);
    }

   /* #[Route('/api/picture/{id}', name: 'picture.get', methods: ['GET'])]
    #[ParamConverter('place', options : ["id"=>"idPicture"])]
    public function getPicture(Picture $picture, UrlGeneratorInterface $UrlGenerator, EntityManager $entityManager, SerializerInterface $serializer):JsonResponse
    {
        $jsonPicture = $serializer->serialize($picture, 'json',["groups"=>"getPicture"]) ;
        $location = $UrlGenerator->generate('picture.get',['idPicture'=>$picture->getId()]);
        return new JsonResponse($jsonPicture, Response::HTTP_CREATED, ['Location'=>$location, 'json'], true);
    } */


    #[Route('/api/picture/{id}', name: 'picture.get', methods: ['GET'])]
    #[ParamConverter('place', options : ["id"=>"idPicture"])]
    public function getPicture(Picture $picture, UrlGeneratorInterface $UrlGenerator, SerializerInterface $serializer):JsonResponse
    {

        $Rllocation = $picture->getPublicPath() . '/' .$picture->getRealPath();
        $location = $UrlGenerator->generate('app.root',[], UrlGeneratorInterface::ABSOLUTE_PATH);
        $location = $location . str_replace('/assets', 'assets', $Rllocation);
        
        $jsonPicture = $serializer->serialize($picture, 'json',["groups"=>"getPicture"]) ;
        return new JsonResponse($jsonPicture, Response::HTTP_OK, ['location'=>$location], true);
    }

}
