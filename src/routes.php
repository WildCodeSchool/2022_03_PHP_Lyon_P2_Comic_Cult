<?php

// list of accessible routes of your application, add every new route here
// key : route to match
// values : 1. controller name
//          2. method name
//          3. (optional) array of query string keys to send as parameter to the method
// e.g route '/item/edit?id=1' will execute $itemController->edit(1)
return [
    '' => ['HomeController', 'index',],
    'items' => ['ItemController', 'index',],
    'items/edit' => ['ItemController', 'edit', ['id']],
    'items/show' => ['ItemController', 'show', ['id']],
    'items/add' => ['ItemController', 'add',],
    'items/delete' => ['ItemController', 'delete',],
    'search' => ['UserController', 'list'],
    'details' => ['UserController', 'details', ['id']],
    'auth' => ['UserController', 'login'],
    'logout' => ['UserController', 'logout',],
    'admin/list' => ['AdminController', 'list',],
    'admin/add' => ['AdminController', 'add'],
    'admin/edit' => ['AdminController', 'edit', ['id']],
    'admin/delete' => ['AdminController', 'delete',],
    'admin/author' => ['AdminController', 'authorList'],
    'admin/author/add' => ['AdminController', 'addAuthor'],
    'admin/author/edit' => ['AdminController', 'authorEdit', ['id']],
    'admin/author/delete' => ['AdminController', 'deleteAuthor'],
];
