<?php
/*
	Routes

*/
$app->get('/', 'HomeController:home')->setName('home');

$app->get('/CreatorRegister', 'CreatorController:registerCreator')->setName('register');

$app->get('/newlist', 'NewListController:addlist')->setName('AddList');

$app->get('/showlists', 'ShowListsController:showlists')->setName('ShowLists');
