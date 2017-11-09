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

$app->post('/postCommentItem', 'CommentaireController:postCommentItem')->setName('postCommentItem');

$app->get('/item', 'ItemController:item')->setName('item');

$app->get('/item/{token}', 'ItemController:getItemsFromToken');

$app->post('/item', 'ItemController:deleteitem')->setName('deleteitem');

$app->get('/addItem', 'ItemController:addItem')->setName('addItem');

$app->post('/postItem', 'ItemController:postItem')->setName('postItem');

$app->get('/newlist', 'NewListController:addlist')->setName('addList');

$app->post('/newlist', 'NewListController:postlist')->setName('postList');

$app->get('/showlists', 'ShowListsController:showlists')->setName('showLists');

$app->post('/showlists', 'ShowListsController:deletelist')->setName('deletelist');

$app->get('/contact', 'ContactController:contact')->setName('contact');

$app->post('/contact', 'ContactController:sendmail')->setName('sendmail');

$app->get('/removeAccount', 'CreatorController:removeCreator')->setName('removeAccount');
