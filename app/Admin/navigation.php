<?php

use SleepingOwl\Admin\Navigation\Page;

// Default check access logic
// AdminNavigation::setAccessLogic(function(Page $page) {
// 	   return auth()->user()->isSuperAdmin();
// });
//
// AdminNavigation::addPage(\App\User::class)->setTitle('test')->setPages(function(Page $page) {
// 	  $page
//		  ->addPage()
//	  	  ->setTitle('Dashboard')
//		  ->setUrl(route('admin.dashboard'))
//		  ->setPriority(100);
//
//	  $page->addPage(\App\User::class);
// });
//
// // or
//
// AdminSection::addMenuPage(\App\User::class)

return [
    [
        'title' => 'Назад на сайт',
        'icon'  => 'fa fa-arrow-left',
        'url'   => '/',
        'priority' => 0,
    ],

    [
        'title' => 'Контакты',
        'icon'  => 'fa fa-address-card',
        'model' => \App\People::class
    ],

    [
        'title' => 'Филиалы',
        'icon'  => 'fa fa-home',
        'model' => \App\Filial::class
    ],

    [
        'title' => 'Подразделения',
        'icon'  => 'fa fa-users',
        'model' => \App\Departament::class
    ],
    [
        'title' => 'FDP',
        'icon'  => 'fa fa-users',
        'model' => \App\FilialDepartamentPeople::class
    ],

    // [
    //     'title' => 'Отчет по компьютерам',
    //     'icon'  => 'fa fa-file-text-o',
    //     'url'   => '/computer/total',
    // ],

    // [
    //     'title' => 'Отчет по оргтехнике',
    //     'icon'  => 'fa fa-file-text-o',
    //     'url'   => '/orgtech/total',
    // ],

    // [
    //     'title' => 'Компьютеры',
    //     'icon'  => 'fa fa-desktop',
    //     // 'url'   => route('admin.information'),
    //     'model'    => \App\Article_pc::class
    // ],

    // [
    //     'title' => 'Оргтехника',
    //     'icon'  => 'fa fa-print',
    //     // 'url'   => route('admin.information'),
    //     'model'    => \App\Article_orgtech::class
    // ],

    // [
    //     'title' => 'Заявки на компьютеры',
    //     'icon'  => 'fa fa-desktop',
    //     // 'url'   => route('admin.information'),
    //     'model'    => \App\Rate_pc::class
    // ],

    // [
    //     'title' => 'Заявки на оргтехнику',
    //     'icon'  => 'fa fa-print',
    //     // 'url'   => route('admin.information'),
    //     'model'    => \App\Rate_orgtech::class
    // ],

    // [
    //     'title' => 'Система',
    //     'pages' => [
    //         (new Page(\App\User::class)),
    //     ],
    //     'icon'  => 'fa fa-cogs',
    //     'priority' => 99998,
    // ],


        // 'pages' => [
        //     (new Page(\App\Article_pc::class))->setIcon('fa fa-desktop'),
        // ],

    // Examples
    // [
    //    'title' => 'Content',
    //    'pages' => [

    //        \App\User::class,

    //     //    // or

    //     //    (new Page(\App\User::class))
    //     //        ->setPriority(100)
    //     //        ->setIcon('fa fa-user')
    //     //        ->setUrl('users')
    //     //        ->setAccessLogic(function (Page $page) {
    //     //            return auth()->user()->isSuperAdmin();
    //     //        }),

    //     //    // or

    //     //    new Page([
    //     //        'title'    => 'News',
    //     //        'priority' => 200,
    //     //        'model'    => \App\News::class
    //     //    ]),

    //     //    // or
    //     //    (new Page(/* ... */))->setPages(function (Page $page) {
    //     //        $page->addPage([
    //     //            'title'    => 'Blog',
    //     //            'priority' => 100,
    //     //            'model'    => \App\Blog::class
	// 	// 	      ));

	// 	// 	      $page->addPage(\App\Blog::class);
    // 	//       }),

    //     //    // or

    //     //    [
    //     //        'title'       => 'News',
    //     //        'priority'    => 300,
    //     //        'accessLogic' => function ($page) {
    //     //            return $page->isActive();
    // 	// 	      },
    //     //        'pages'       => [

    //     //            // ...

    //     //        ]
    //     //    ]
    //    ]
    // ]
];