<?php

namespace App\Service\Messenger;

use App\Entity\Image;
use App\Manager\ImageManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ConvertImageMessageHandler
{
    protected EntityManagerInterface $entityManager;
    protected ImageManager           $imageManager;

    public function __construct(EntityManagerInterface $entityManager, ImageManager $imageManager)
    {
        $this->entityManager = $entityManager;
        $this->imageManager  = $imageManager;
    }

    public function __invoke(ConvertImageMessage $message)
    {
        $image = $this->entityManager->getRepository(Image::class)->find($message->getId());

        if ($image instanceof Image) {
            $this->imageManager->convert($image);
        }
    }
}