<?php
return [
    'main' => [
        'title' => 'Main',
        'items' => [
            [
                'label' => 'Dashboard',
                'icon' => 'fe fe-home',
                'route' => 'admin.dashboard',
                'active' => 'admin',
            ],
        ],
    ],
    // 'tools' => [
    //     'title' => 'Tools & Management',
    //     'items' => [
    //         [
    //             'label' => 'Users',
    //             'icon' => 'fe fe-user',
    //             // 'route' => 'javascript:void(0)',
    //             'active' => 'admin/users*',
    //             'sub_items' => [
    //                 [
    //                     'label' => 'Manage Users',
    //                     'route' => 'admin.users.index',
    //                     'active' => 'admin/users*',
    //                 ],
    //             ],
    //         ],
    //     ],
    // ],

    'tools' => [
        'title' => 'Tools & Management',
        'items' => [
            [
                'label' => 'Users',
                'icon' => 'fe fe-user',
                // 'route' => 'javascript:void(0)',
                'active' => 'admin/users*',
                'sub_items' => [
                    [
                        'label' => 'Manage Users',
                        'route' => 'admin.users.index',
                        'active' => 'admin/users*',
                    ],
                ],
            ],
            [
                'label' => 'Posts',
                'icon' => 'fe fe-post',
                // 'route' => 'javascript:void(0)',
                'active' => 'admin/posts*',
                'sub_items' => [
                    [
                        'label' => 'Manage Posts',
                        'route' => 'admin.posts.index',
                        'active' => 'admin/posts*',
                    ],
                ],
            ],
            [
                'label' => 'Money',
                'icon' => 'fe fe-money-bills',
                // 'route' => 'javascript:void(0)',
                'active' => 'admin/transaction*',
                'sub_items' => [
                    [
                        'label' => 'Transactions',
                        'route' => 'admin.transaction.index',
                        'active' => 'admin/transaction*',
                    ],
                ],
            ],
        ],
    ],
];
