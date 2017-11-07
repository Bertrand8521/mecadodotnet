<?php
/*
	Routes

*/
$app->get('/', 'ExempleController:exemple')->setName('index');

$app->get('/userRegister', 'UserController:registerUser')->setName('register');

$app->get('/newlist', 'NewListController:addlist')->setName('AddList');

$app->get('/showlists', 'ShowListsController:showlists')->setName('ShowLists');
