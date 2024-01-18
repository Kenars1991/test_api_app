<?php

namespace App\Controller;
use App\Entity\Users;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
date_default_timezone_set('Europe/Moscow');

class UsersController extends AbstractController
{

	    #[Route('/users', name: 'page_ame')]
    public function getUsers(ManagerRegistry $doctrine): Response
    {
       $repository = $doctrine->getRepository(Users::class);
	   $users = $repository->findAll();
	   $viv_users = array();
	   foreach($users as $user)
	   {
	   $viv_users[] = array('name' => $user->getName(), 'pass' => $user->getPass(), 'api_key' => $user->getApikey());
	   }
        return new Response(json_encode($viv_users));
    }
		    #[Route('/user/{name}', name: 'user_viv')]
    public function getUsersbyName(ManagerRegistry $doctrine, string $name): Response
    {
		//$name = $_GET['name'];
		$viv = '';
       $repository = $doctrine->getRepository(Users::class);
	   	   $users = $repository->findBy(
       ['name' => $name]
	   );
	   if(count($users) == 0)
	   {
	   $viv = array('errors' => 'yes', 'content' => 'No found');
	   
	   }
	   else
	   {
	   foreach($users as $user)
	   {
	   $viv = array('errors' => 'no', 'content' =>  array('name' => $user->getName(), 'pass' => $user->getPass(), 'api_key' => $user->getApikey()));
	   }
	   }
        return new Response(json_encode($viv));
    }
		    #[Route('/users/create', name: 'create_user')]
    public function createUser(ManagerRegistry $doctrine): Response
    {
	  $entityManager = $doctrine->getManager();
		$viv = '';
	   $name = $_GET['name'];
	   $pass = $_GET['pass'];
	   $api_k = time().chr(rand(97,122)).rand(1,122).rand(97,122).chr(rand(97,122)).chr(rand(97,122)).chr(rand(97,122)).rand(1,122).rand(1,122).rand(1,122).chr(rand(97,122)).chr(rand(97,122)).chr(rand(97,122)).chr(rand(97,122)).rand(1,122).rand(1,122).chr(rand(97,122));
	   $repository = $doctrine->getRepository(Users::class);

	   $users = $repository->findBy(
       ['name' => $name]
	   );
	   if(count($users)>0)
	   {
	   $viv = array('errors'=>'yes', 'content' => 'UserName is Already exists');
	   }
	   else
	   {
	   $user = new Users();
	   $user->setName($name);
	   $user->setPass($pass);
	   $user->setApikey($api_k);
	    // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($user);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
		$viv = array('errors'=>'no', 'content' => array("text" => 'User is created', "apikey" => $api_k));
	   }
        return new Response(json_encode($viv));
    }
}