<?php

namespace App\Controller;
use App\Entity\Primer;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrimerController extends AbstractController
{

	    #[Route('/primer', name: 'create_product')]
    public function createProduct(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $primer = new Primer();
        $primer->setName('Keyboard');
        $primer->setPrice(1999);

        // сообщите Doctrine, что вы хотите (в итоге) сохранить Продукт (пока без запросов)
        $entityManager->persist($primer);

        // действительно выполните запросы (например, запрос INSERT)
        $entityManager->flush();

        return new Response('Saved new product with id '.$primer->getId());
    }
}
