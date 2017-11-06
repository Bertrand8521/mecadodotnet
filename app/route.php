<?php
/*
	Routes
	
*/
$app->get('/', 'UserController:index')->setName('index');

$app->get('/userRegister', 'UserController:registerUser')->setName('register');

