<?php
/*
	Routes

*/
$app->get('/', 'HomeController:home')->setName('home');

$app->get('/CreatorRegister', 'CreatorController:registerCreator')->setName('register');

$app->post('/CreatorRegistered', 'CreatorController:registeredCreator')->setName('creatorRegistered');

$app->get('/CreatorLogin', 'CreatorController:creatorLogin')->setName('login');

$app->post('/CreatorLogged', 'CreatorController:creatorLogged')->setName('logged');

$app->get('/LogOut', 'CreatorController:creatorLogOut')->setName('LogOut');

$app->get('/item', 'ItemController:item')->setName('item');

$app->get('/item/{token}', 'ItemController:getItemsFromToken');

$app->post('/addItem', 'ItemController:addItem')->setName('addItem');

$app->get('/newlist', 'NewListController:addlist')->setName('addList');

$app->post('/newlist', 'NewListController:postlist')->setName('postList');

$app->get('/showlists', 'ShowListsController:showlists')->setName('showLists');

$app->get('/contact', 'ContactController:contact')->setName('contact');

$app->post('/contact', 'ContactController:sendmail')->setName('sendmail');
