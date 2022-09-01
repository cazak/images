<?php

declare(strict_types=1);

namespace App\Controller\Check;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CheckDoctrineAction extends AbstractController
{
    #[Route('/doctrine-check', name: 'doctrine_check', methods: ['GET'])]
    public function check(EntityManagerInterface $em)
    {
        $em->getConnection()->connect();
        $connected = $em->getConnection()->isConnected();

        if ($connected) {
            return new Response('Yes');
        }

        return new Response('No');
    }
}
