<?php

namespace App\Controller;
use App\Entity\Primer;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
date_default_timezone_set('Europe/Moscow');

class AmeController extends AbstractController
{

	    #[Route('/ame', name: 'page_ame')]
    public function createProduct(ManagerRegistry $doctrine): Response
    {

        return new Response(date("d.m.Y H:i:s"));
    }
}