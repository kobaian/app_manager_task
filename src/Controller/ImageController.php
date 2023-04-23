<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\ImageType;
use App\Manager\ImageManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    #[Route('/image/upload', name: 'app_image_upload')]
    public function upload(Request $request, ImageManager $imageManager): Response
    {
        $image = new Image();
        $form  = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('file')->getData();

            if ($imageFile) {
                $imageManager->upload($imageFile, $image);

                return $this->redirectToRoute('app_image_list');
            }
        }

        return $this->render('image/upload.html.twig', [
            'form' => $form,
        ]);
    }
}