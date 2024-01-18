<?php

namespace App\Controller;
use App\Entity\Users;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
date_default_timezone_set('Europe/Moscow');

class DocumentationController extends AbstractController
{
		    #[Route('/docs', name: 'docs')]
		    public function documentation(ManagerRegistry $doctrine): Response
    {
	$content = '# beneficiumus.ru API<br>
## Introduction<br>
beneficiumus.ru  API allows to use all features of owr Tasks Service<br><br>
## USERS<br>
### (GET) Users (Public)<br>
URL: https://beneficiumus.ru/users<br>
Example request: GET https://beneficiumus.ru/users<br>

Example Response: [{"name":"user_login1","pass":"user_pass1","api_key":"api_key_1"},{"name":"user_login2","pass":"user_pass2","api_key":"api_key_2"}]<br><br>

### (GET) USER (Public)<br>
Example request: GET https://beneficiumus.ru/user/{user_login1}<br>
Example Response: {"errors":"no","content":{"name":"user_login1","pass":"user_pass1","api_key":"api_key_1"}}<br><br>

###  (GET) CREATE USER (Public)<br>
Example request: https://beneficiumus.ru/users/create?name={user_name}&pass={user_pass}<br>
Example Response: {"errors":"no","content":{"text":"User is created","apikey":{users_apikey}}}<br><br>

## TOKENS<br>
### (GET) GET TOKEN (Public)<br>
Example request: https://beneficiumus.ru/getToken?apikey={user_apikey}<br>
Example Response: {"errors":"no","content":{"text":"token is successful created","token":{user_token}}}<br>
Notice: Token expiration - 10 minutes<br><br>

## Tasks<br>
### (GET) GET TASKS (Private by token)<br>
Example request: http://beneficiumus.ru/Tasks?token={user_token}<br>
Example Response: {"errors":"no","content":{"text":"ok","data":[{"id":3,"name":"prim","descr":"primer","cr_d":{"date":"2024-01-17 13:42:43.000000","timezone_type":3,"timezone":"Europe\/Moscow"},"date_done":{"date":"2024-02-21 00:00:00.000000","timezone_type":3,"timezone":"Europe\/Moscow"},"status":"new"}]}}<br><br>

### (GET) GET TASK by ID (Private by token)<br>
Example request: http://beneficiumus.ru/Task/{id}?token={user_token}<br>
Example Response: {"errors":"no","content":{"text":"ok","data":[{"id":3,"name":"prim","descr":"primer","cr_d":{"date":"2024-01-17 13:42:43.000000","timezone_type":3,"timezone":"Europe\/Moscow"},"date_done":{"date":"2024-02-21 00:00:00.000000","timezone_type":3,"timezone":"Europe\/Moscow"},"status":"new"}]}}<br><br>
### (GET) ADD NEW TASK (Private by token)<br>
required GET parametrs<br>
- token<br>
- nam (task_name)<br>
- descr (task_description)<br>
- date_done (date of done required format "Year-month-day")<br><br>

Example request: http://beneficiumus.ru/Tasks/add?token={user_token}&nam={task_name}&descr={task_description}&date_done={date_done}<br>
Example Response: Example Response: {"errors":"no","content":"success","id":{task_id}}<br><br>

### (GET) EDIT TASK (Private by token)<br>
GET parametrs<br>
- token required<br>
- nam (task_name) optional<br>
- descr (task_description) optional<br>
- date_done (date of done required format "Year-month-day") optional<br>
Example request: http://beneficiumus.ru/Tasks/edit/{id}?token={user_token}&nam={task_name}&descr={task_description}&date_done={date_done}<br>
Example Response: Example Response: {"errors":"no","content":"success","id":{task_id}}<br><br>

### (GET) SET STATUS TASK (Private by token)<br>
Example request: http://beneficiumus.ru/Tasks/set/status/{id}?token={user_token}&status={task_status}<br>
Example Response: Example Response: {"errors":"no","content":"success","id":{task_id}}<br>
Notice: status has to be in array ["new","work","done"]<br><br>

### (GET) REMOVE TASK (Private by token)<br>
Example request: http://beneficiumus.ru/Tasks/remove/{id}?token={user_token}<br>
Example Response: Example Response: {"errors":"no","content":"success","id":{task_id}}<br>';
return new Response($content);
	
	}

}