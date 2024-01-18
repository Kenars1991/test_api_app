<?php

namespace App\Controller;
use App\Entity\Users;
use App\Entity\Tokens;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\DBAL\Types\DateType;
date_default_timezone_set('Europe/Moscow');

class TokenController extends AbstractController
{

	    #[Route('/getToken', name: 'getToken')]
    public function getToken(ManagerRegistry $doctrine): Response
    {
		$entityManager = $doctrine->getManager();
		$viv = '';
      $apikey = $_GET['apikey'];
	  	$token_val = sprintf(
		'%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
		mt_rand(0, 0xffff),
		mt_rand(0, 0xffff),
		mt_rand(0, 0xffff),
		mt_rand(0, 0x0fff) | 0x4000,
		mt_rand(0, 0x3fff) | 0x8000,
		mt_rand(0, 0xffff),
		mt_rand(0, 0xffff),
		mt_rand(0, 0xffff)
	);
	  
	  $repository = $doctrine->getRepository(Users::class);
	  $users = $repository->findBy(
       ['apikey' => $apikey]
	   );
	   if(count($users) == 0)
	   {
	   $viv = array('errors' => 'yes', 'content' => 'ApiKey is wrong');
	   }
	   else
	   {
	   foreach($users as $user)
	   {
	   $user_id = $user->getId();
	   }
	   $token = new Tokens;
	   $token->setUserId($user_id);
	   $token->setIp($_SERVER['REMOTE_ADDR']);
	   $datetime = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Moscow'));
	   $token->setCrD($datetime);
	   $token->setVal($token_val);
	   // сообщите Doctrine, что вы хотите (в итоге) сохранить Продукт (пока без запросов)
        $entityManager->persist($token);

        // действительно выполните запросы (например, запрос INSERT)
        $entityManager->flush();
	   $viv = array('errors' => 'no', 'content' => array('text'=>'token is successful created', 'token' => $token_val));
	   }

        return new Response(json_encode($viv));
    }
	#[Route('/tokenizer', name: 'Tokenizer')]
	    public function Tokenizer(ManagerRegistry $doctrine): Response
    {
	$entityManager = $doctrine->getManager();
	$repository = $doctrine->getRepository(Tokens::class);
	$tokens = $repository->findAll();
	$viv = array();
	$cur_time = time();
	foreach($tokens as $token)
	{
	$date = $token->getCrD();
	$vv = $date->format('Y-m-d H:i:s');	
	$token_time = strtotime($vv);
	$rez_time = $cur_time - $token_time;
	if($rez_time > 600)
	{
	$entityManager->remove($token);
    $entityManager->flush();
	}
	}
	return new Response('');
	}
}