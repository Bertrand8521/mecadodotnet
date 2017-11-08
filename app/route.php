<?php
/*
	Routes

*/
$app->get('/', 'HomeController:home')->setName('home');

$app->get('/CreatorRegister', 'CreatorController:registerCreator')->setName('register');

$app->post('/CreatorRegistered', 'CreatorController:registeredCreator')->setName('creatorRegistered');

$app->get('/CreatorLogin', 'CreatorController:creatorLogin')->setName('login');

$app->post('/CreatorLogged', 'CreatorController:creatorLogged')->setName('logged');

$app->get('/item', 'ItemController:item');

$app->get('/item/{liste_id}', 'ItemController:getItemsFromListeId');

$app->get('/newlist', 'NewListController:addlist')->setName('addList');

$app->get('/showlists', 'ShowListsController:showlists')->setName('showLists');
