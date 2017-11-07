<?php
/*
	Routes
	
*/
$app->get('/', 'HomeController:home')->setName('home');

$app->get('/CreatorRegister', 'CreatorController:registerCreator')->setName('register');

