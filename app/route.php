<?php
/*
	Routes

*/
$app->get('/', 'HomeController:home')->setName('home');

$app->get('/CreatorRegister', 'CreatorController:registerCreator')->setName('register');

$app->post('/CreatorRegistered', 'CreatorController:registeredCreator')->setName('creatorRegistered');

$app->get('/CreatorLogin', 'CreatorController:creatorLogin')->setName('login');

$app->get('/item', 'ItemController:item');

$app->get('/item/{liste_id}', 'ItemController:getItemsFromListeId');

$app->get('/newlist', 'NewListController:addlist')->setName('addList');

$app->post('/newlist', 'NewListController:postlist')->setName('postList');

$app->get('/showlists', 'ShowListsController:showlists')->setName('showLists');

$app->get('/contact', 'ContactController:contact')->setName('contact');

$app->post('/contact', 'ContactController:sendmail')->setName('sendmail');
