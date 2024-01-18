<?php

namespace App\Controller;
use App\Entity\Users;
use App\Entity\Tokens;
use App\Entity\Tasks;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\DBAL\Types\DateType;
date_default_timezone_set('Europe/Moscow');

class TasksController extends AbstractController
{
	
		    #[Route('/Tasks', name: 'getTasks')]
    public function getTasks(ManagerRegistry $doctrine): Response
    {
		$viv = '';
		$token = $_GET['token'];
		$ip = 
		$entityManager = $doctrine->getManager();
        $repository = $doctrine->getRepository(Tokens::class);
		$tokens = $repository->findBy(
       ['val' => $token]
	   );

	   if(count($tokens) == 0)
	   {
	   $viv = array('errors' => 'yes', 'content' => 'Wrong token');
	   }
	   else
	   {
	   foreach($tokens as $token)
	   {
	   $token_arr = array('val'=> $token->getVal(), 'user_id' => $token->getUserId(), 'ip' => $token->getIp());
	   }
	   if($token_arr['ip']!=$_SERVER['REMOTE_ADDR'])
	   {
	   $viv = array('errors' => 'yes', 'content' => 'Wrong ip');
	   }
	   else
	   {
	   	$repository = $doctrine->getRepository(Tasks::class);
        $tasks = $repository->findBy(
       ['user_id' => intval($token_arr['user_id'])]
	   );
	   $viv_tasks = array();
	   foreach($tasks as $task)
	   {
	   $viv_tasks[] = array('id' => $task->getId(), 'name' => $task->getName(), 'descr' => $task->getDescr(), 'cr_d' => $task->getCrD(), 'date_done' => $task->getDateDone(), 'status' => $task->getStatus());
	   }
	   $viv = array('errors' => 'no', 'content' => array('text' => 'ok', 'data' => $viv_tasks));
	   
	   }
	   }
	   return new Response(json_encode($viv));
	}
			    #[Route('/Task/{id}', name: 'getTask')]
    public function getTask(ManagerRegistry $doctrine, int $id): Response
    {
		$viv = '';
		$token = $_GET['token'];
		$ip = 
		$entityManager = $doctrine->getManager();
        $repository = $doctrine->getRepository(Tokens::class);
		$tokens = $repository->findBy(
       ['val' => $token]
	   );

	   if(count($tokens) == 0)
	   {
	   $viv = array('errors' => 'yes', 'content' => 'Wrong token');
	   }
	   else
	   {
	   foreach($tokens as $token)
	   {
	   $token_arr = array('val'=> $token->getVal(), 'user_id' => $token->getUserId(), 'ip' => $token->getIp());
	   }
	   if($token_arr['ip']!=$_SERVER['REMOTE_ADDR'])
	   {
	   $viv = array('errors' => 'yes', 'content' => 'Wrong ip');
	   }
	   else
	   {
	   	$repository = $doctrine->getRepository(Tasks::class);
        $tasks = $repository->findBy(
       ['id' => $id,
	   'user_id' => intval($token_arr['user_id'])]
	   );
	   $viv_tasks = array();
	   foreach($tasks as $task)
	   {
	   $viv_tasks[] = array('id' => $task->getId(), 'name' => $task->getName(), 'descr' => $task->getDescr(), 'cr_d' => $task->getCrD(), 'date_done' => $task->getDateDone(), 'status' => $task->getStatus());
	   }
	   $viv = array('errors' => 'no', 'content' => array('text' => 'ok', 'data' => $viv_tasks));
	   
	   }
	   }
	   return new Response(json_encode($viv));
	}
				    #[Route('/Tasks/add', name: 'addTask')]
    public function addTask(ManagerRegistry $doctrine): Response
    {
		$viv = '';
		$token = $_GET['token'];
		$ip = 
		$entityManager = $doctrine->getManager();
        $repository = $doctrine->getRepository(Tokens::class);
		$tokens = $repository->findBy(
       ['val' => $token]
	   );

	   if(count($tokens) == 0)
	   {
	   $viv = array('errors' => 'yes', 'content' => 'Wrong token');
	   }
	   else
	   {
	   foreach($tokens as $token)
	   {
	   $token_arr = array('val'=> $token->getVal(), 'user_id' => $token->getUserId(), 'ip' => $token->getIp());
	   }
	   if($token_arr['ip']!=$_SERVER['REMOTE_ADDR'])
	   {
	   $viv = array('errors' => 'yes', 'content' => 'Wrong ip');
	   }
	   else
	   {
       $name = $_GET['nam'];
	   $descr = $_GET['descr'];
	   $datedone = $_GET['date_done'];
       $prov_date_done = explode('-',$datedone);
	   $year = $prov_date_done[0];
	   $month = $prov_date_done[1];
	   $day = $prov_date_done[2];
	   $prov_date_done = checkdate(intval($month), intval($day), intval($year));
	   if($prov_date_done == false)
	   {
       $viv = array('errors' => 'yes', 'content' => 'Wrong field: date_done');
	   }
	   else
	   {
	   $cr_d = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Moscow'));
	   $date_done = new \DateTimeImmutable("$year-$month-$day", new \DateTimeZone('Europe/Moscow'));
	   $task = new Tasks;
	   $task->setName($name);
	   $task->setDescr($descr);
	   $task->setCrD($cr_d);
	   $task->setStatus('new');
	   $task->setUserId(intval($token_arr['user_id']));
	   $task->setDateDone($date_done);
	   $entityManager->persist($task);

        // действительно выполните запросы (например, запрос INSERT)
        $entityManager->flush();
		$viv = array('errors' => 'no', 'content' => 'success', 'id' => $task->getId());
	   }
	   }
	   }
	   return new Response(json_encode($viv));
	}
	
					    #[Route('/Tasks/edit/{id}', name: 'editTask')]
    public function editTask(ManagerRegistry $doctrine, int $id): Response
    {
		$viv = '';
		$token = $_GET['token'];
		$ip = 
		$entityManager = $doctrine->getManager();
        $repository = $doctrine->getRepository(Tokens::class);
		$tokens = $repository->findBy(
       ['val' => $token]
	   );

	   if(count($tokens) == 0)
	   {
	   $viv = array('errors' => 'yes', 'content' => 'Wrong token');
	   }
	   else
	   {
	   foreach($tokens as $token)
	   {
	   $token_arr = array('val'=> $token->getVal(), 'user_id' => $token->getUserId(), 'ip' => $token->getIp());
	   }
	   if($token_arr['ip']!=$_SERVER['REMOTE_ADDR'])
	   {
	   $viv = array('errors' => 'yes', 'content' => 'Wrong ip');
	   }
	   else
	   {
       $name = $_GET['nam'];
	   $descr = $_GET['descr'];
	   $datedone = $_GET['date_done'];
       $prov_date_done = explode('-',$datedone);
	   $year = $prov_date_done[0];
	   $month = $prov_date_done[1];
	   $day = $prov_date_done[2];
	   $prov_date_done = checkdate(intval($month), intval($day), intval($year));
	   if($prov_date_done == false)
	   {
       $viv = array('errors' => 'yes', 'content' => 'Wrong field: date_done');
	   }
	   else
	   {
	   $repository = $doctrine->getRepository(Tasks::class);
	   $task = $repository->findBy(
       ['id' => $id,
	   'user_id' => intval($token_arr['user_id'])
	   ]
	   );
	   if(count($task) == 0)
	   {
	   $viv = array('errors' => 'yes', 'content' => 'No tasks for this id');
	   }
	   else
	   {
	   $cr_d = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Moscow'));
	   $date_done = new \DateTimeImmutable("$year-$month-$day", new \DateTimeZone('Europe/Moscow'));
	   if(isset($_GET['nam']))
	   {
	   $task->setName($_GET['nam']);
	   }
	   if(isset($_GET['descr']))
	   {
	   $task->setDescr($_GET['descr']);
	   }       
	   $task->setUserId(intval($token_arr['user_id']));
	   $task->setDateDone($date_done);
	   $entityManager->persist($task);

        // действительно выполните запросы (например, запрос INSERT)
       $entityManager->flush();
	   $viv = array('errors' => 'no', 'content' => 'success', 'id' => $id);
	   }
	   }
	   }
	   }
	   return new Response(json_encode($viv));
	}
					    #[Route('/Tasks/set/status/{id}', name: 'set_status_Task')]
	    public function SetStatus(ManagerRegistry $doctrine, int $id): Response
    {
		$status_val = ["new","work","done"];
		$viv = '';
		$token = $_GET['token'];
		$ip = 
		$entityManager = $doctrine->getManager();
        $repository = $doctrine->getRepository(Tokens::class);
		$tokens = $repository->findBy(
       ['val' => $token]
	   );

	   if(count($tokens) == 0)
	   {
	   $viv = array('errors' => 'yes', 'content' => 'Wrong token');
	   }
	   else
	   {
	   foreach($tokens as $token)
	   {
	   $token_arr = array('val'=> $token->getVal(), 'user_id' => $token->getUserId(), 'ip' => $token->getIp());
	   }
	   if($token_arr['ip']!=$_SERVER['REMOTE_ADDR'])
	   {
	   $viv = array('errors' => 'yes', 'content' => 'Wrong ip');
	   }
	   else
	   {
        $status = $_GET['status'];
	   if(!in_array($status,$status_val))
	   {
       $viv = array('errors' => 'yes', 'content' => 'Status is wrong');
	   }
	   else
	   {
	   $repository = $doctrine->getRepository(Tasks::class);
	   $task = $repository->findBy(
       ['id' => $id,
	   'user_id' => intval($token_arr['user_id'])
	   ]
	   );
	   if(count($task) == 0)
	   {
	   $viv = array('errors' => 'yes', 'content' => 'No tasks for this id');
	   }
	   else
	   {
       foreach($task as $e)
	   {
	   $current_task = $e;
	   }
	   $task = $current_task;
	   $task->setStatus($status);
	   $entityManager->persist($task);

        // действительно выполните запросы (например, запрос INSERT)
       $entityManager->flush();
	   $viv = array('errors' => 'no', 'content' => 'success', 'id' => $id);
	   }
	   }
	   }
	   }
	   return new Response(json_encode($viv));
	}
						    #[Route('/Tasks/remove/{id}', name: 'remove_Task')]
	    public function removeTasks(ManagerRegistry $doctrine, int $id): Response
    {
		$viv = '';
		$token = $_GET['token'];
		$ip = 
		$entityManager = $doctrine->getManager();
        $repository = $doctrine->getRepository(Tokens::class);
		$tokens = $repository->findBy(
       ['val' => $token]
	   );

	   if(count($tokens) == 0)
	   {
	   $viv = array('errors' => 'yes', 'content' => 'Wrong token');
	   }
	   else
	   {
	   foreach($tokens as $token)
	   {
	   $token_arr = array('val'=> $token->getVal(), 'user_id' => $token->getUserId(), 'ip' => $token->getIp());
	   }
	   if($token_arr['ip']!=$_SERVER['REMOTE_ADDR'])
	   {
	   $viv = array('errors' => 'yes', 'content' => 'Wrong ip');
	   }
	   else
	   {
	   $repository = $doctrine->getRepository(Tasks::class);
	   $task = $repository->findBy(
       ['id' => $id,
	   'user_id' => intval($token_arr['user_id'])
	   ]
	   );
	   if(count($task) == 0)
	   {
	   $viv = array('errors' => 'yes', 'content' => 'No tasks for this id');
	   }
	   else
	   {
       foreach($task as $e)
	   {
	   $current_task = $e;
	   }
	   $task = $current_task;
	   $entityManager->remove($task);

        // действительно выполните запросы (например, запрос INSERT)
       $entityManager->flush();
	   $viv = array('errors' => 'no', 'content' => 'success', 'id' => $id);
	   }
	   }
	   }
	   return new Response(json_encode($viv));
	}
        		
	
}