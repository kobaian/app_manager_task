<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Image;
use App\Service\Messenger\ConvertImageMessage;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Imagine\Image\ImagineInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class ImageManager
{
    protected ImagineInterface       $imagine;
    protected EntityManagerInterface $entityManager;
    protected MessageBusInterface    $messageBus;
    protected KernelInterface        $kernel;

    public function __construct(
        EntityManagerInterface $entityManager,
        ImagineInterface $imagine,
        MessageBusInterface $messageBus,
        KernelInterface $kernel
    ) {
        $this->entityManager = $entityManager;
        $this->imagine       = $imagine;
        $this->messageBus    = $messageBus;
        $this->kernel        = $kernel;
    }

    public function upload(UploadedFile $uploadedFile, Image $image): Image
    {
        $image->setName($uploadedFile->getClientOriginalName());
        $image->setOriginalExtension(strtolower($uploadedFile->getClientOriginalExtension()));
        $image->setOriginalSize($uploadedFile->getSize());

        try {
            $imagineImage = $this->imagine->open($uploadedFile->getPathname());
            $box   = $imagineImage->getSize();

            $image->setOriginalImageWidth($box->getWidth());
            $image->setOriginalImageHeight($box->getHeight());
        } catch (Exception $ex) {

        }
        try {
            $uploadedFile->move($this->getOriginalDirectory(), $image->getOriginalPath());
            $this->entityManager->persist($image);
            $this->entityManager->flush($image);

            $this->messageBus->dispatch(new ConvertImageMessage($image->getId()));
        } catch (Exception $ex) {
            $this->entityManager->remove($image);

            throw $ex;
        }

        return $image;
    }

    public function convert(Image $image) {

    }

    private function getOriginalDirectory(): string
    {
        return $this->kernel->getProjectDir() . '/public/original_file';
    }

    private function getConvertedDirectory(): string
    {
        return $this->kernel->getProjectDir() . '/public/converted_file';
    }
}
