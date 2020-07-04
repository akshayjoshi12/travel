<?php

namespace App\Controller;

use App\Entity\UserPlace;
use App\Form\UserPlaceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FileUploader;

class PlaceController extends AbstractController
{
	/**
     * @Route("/place/new", name="app_place_new")
     */
    public function new(Request $request , FileUploader $fileUploader)
    {
        $userPlace = new UserPlace();
        $form = $this->createForm(UserPlaceType::class, $userPlace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFiles = $form->get('placeImages')->getData();

            //  $fileName = $this->generateUniqueFileName().'.'.$imageFile->guessExtension();

            // // moves the file to the directory where brochures are stored
            // $imageFile->move(
            //     $this->getParameter('uploads_directory'),
            //     $fileName
            // );

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if (!empty($imageFiles)) {
                foreach ($imageFiles as $imageFile)
                {
                    $imageFileName = $fileUploader->upload($imageFile);
                    $userPlace->setImagePath($imageFileName);
                }
                
            }

            // ... persist the $place variable or any other work

            return $this->redirect($this->generateUrl('app_place_new'));
        }

        return $this->render('place/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}