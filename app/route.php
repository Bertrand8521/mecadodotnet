<?php
/*
	Routes

*/
$app->get('/', 'HomeController:home')->setName('home');

$app->get('/CreatorRegister', 'CreatorController:registerCreator')->setName('register');

$app->get('/CreatorLogin', 'CreatorController:creatorLogin')->setName('login');

$app->get('/item', 'ItemController:item');

$app->get('/item/{liste_id}', 'ItemController:getItemsFromListeId');

$app->get('/newlist', 'NewListController:addlist')->setName('addList');

$app->get('/showlists', 'ShowListsController:showlists')->setName('showLists');

$app->get('/contact', 'ContactController:contact')->setName('contact');
