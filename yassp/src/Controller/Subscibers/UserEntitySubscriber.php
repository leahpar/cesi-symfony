<?php

namespace App\Controller\Subscibers;

use App\Entity\User;
use App\Service\EncryptService;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class UserEntitySubscriber implements EventSubscriberInterface
{

    private EncryptService $encryptService;

    public function __construct(EncryptService $encryptService)
    {
        $this->encryptService = $encryptService;
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist => 'prePersist',
            Events::preUpdate => 'preUpdate',
            Events::postLoad => 'postLoad',
        ];
    }

    private function encryptUser($entity)
    {
        if (!$entity instanceof User) {
            return;
        }

        $data = $entity->getDonneeSensible();
        $entity->setDonneeSensible(
            $this->encryptService->encrypt($data)
        );
    }
    private function decryptUser($entity)
    {
        if (!$entity instanceof User) {
            return;
        }

        $data = $entity->getDonneeSensible();
        $entity->setDonneeSensible(
            $this->encryptService->decrypt($data)
        );
    }

    public function prePersist(LifecycleEventArgs $event)
    {
        $this->encryptUser($event->getObject());
    }


    public function preUpdate(LifecycleEventArgs $event)
    {
        $this->encryptUser($event->getObject());
    }

    public function postLoad(LifecycleEventArgs $event)
    {
        $this->decryptUser($event->getObject());
    }





}
