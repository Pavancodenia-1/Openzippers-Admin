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
    'tools' => [
        'title' => 'Tools & Management',
        'items' => [
            [
                'label' => 'Users',
                'icon' => 'fe fe-user',
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
                'icon' => 'fe fe-file-text',
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
                'icon' => 'fe fe-dollar-sign',
                'active' => 'admin/transaction*',
                'sub_items' => [
                    [
                        'label' => 'Transactions',
                        'route' => 'admin.transaction.index',
                        'active' => 'admin/transaction*',
                    ],
                ],
            ],
            [
                'label' => 'Wallet',
                'icon' => 'fe fe-credit-card',
                'active' => 'admin/wallet*',
                'sub_items' => [
                    [
                        'label' => 'Add Balance',
                        'route' => 'admin.wallet.addBalenceForm',
                        'active' => 'admin/wallet/add-balance*',
                    ],
                    [
                        'label' => 'Wallet History',
                        'route' => 'admin.wallet.index',
                        'active' => 'admin/wallet/history*',
                    ],
                ],
            ],
        ],
    ],
];
