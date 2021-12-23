<?php

return [
    'role_structure'       => [
        'super_admin'     => [
            'faqs'          => 'c,r,u,d',
            'users'         => 'c,r,u,d',
            'warehouses'    => 'c,r,u,d',
            'packages'      => 'c,r,u,d',
            'stores'        => 'c,r,u,d',
            'orders'        => 'r,u,d',
            'news'          => 'c,r,u,d',
            'pages'         => 'c,r,u,d',
            'sliders'       => 'c,r,u,d',
            'admins'        => 'c,r,u,d',
            'settings'      => 'c,r,u,d',
            'translations'  => 'c,r,u,d',
            'roles'         => 'c,r,u,d',
            'package_types' => 'c,r,u,d',
            'categories'    => 'c,r,u,d',
            'countries'     => 'c,r,u,d',
            'products'      => 'c,r,u,d',
            'coupons'       => 'c,r,u,d',
            'dones'         => 'r',
            'sms'           => 'c,r,u,d',
            'emails'        => 'c,r,u,d',
            'cities'        => 'c,r,u,d',
            'activities'    => 'r',
            'notifications' => 'r',
            'gift_cards'    => 'c,r,d',
            'transactions'  => 'c,r',
            'parcels'       => 'r',
            'addresses'     => 'c,r,u,d',
            'unknowns'      => 'r,u,d',
            'campaigns'     => 'r,c,d',
            'workers'       => 'c,r,u,d',
            'services'      => 'c,r,u,d',
            'districts'     => 'c,r,u,d',
            'logs'          => 'r',
            'cards'         => 'c,r,u,d',
            'promos'        => 'c,r,u',
            'filials'       => 'c,r,u,d',
            'deliveries'    => 'r,u,d',
        ],
        'admin'           => [
            'users'      => 'c,r,u,d',
            'warehouses' => 'c,r,u,d',
            'packages'   => 'c,r,u,d',
            'orders'     => 'r,u,d',
            'categories' => 'c,r,u,d',
            'countries'  => 'c,r,u,d',
            'dones'      => 'r',
            'activities' => 'r',
            'parcels'    => 'r',
            'unknowns'   => 'r,u,d',
            'workers'    => 'c,r,u,d',
            'logs'       => 'r',
        ],
        'accountant'      => [
            'users'        => 'r',
            'transactions' => 'c,r',
        ],
        'operator'        => [
            'users'    => 'c,r,u,d',
            'orders'   => 'r,u,d',
            'packages' => 'c,r,u,d',
        ],
        'content_manager' => [
            'faqs'          => 'c,r,u,d',
            'packages'      => 'c,r,u,d',
            'stores'        => 'c,r,u,d',
            'news'          => 'c,r,u,d',
            'pages'         => 'c,r,u,d',
            'sliders'       => 'c,r,u,d',
            'settings'      => 'c,r,u,d',
            'translations'  => 'c,r,u,d',
            'package_types' => 'c,r,u,d',
            'categories'    => 'c,r,u,d',
            'countries'     => 'c,r,u,d',
            'products'      => 'c,r,u,d',
            'coupons'       => 'c,r,u,d',
            'sms'           => 'c,r,u,d',
            'emails'        => 'c,r,u,d',
            'cities'        => 'c,r,u,d',
            'gift_cards'    => 'c,r,d',
            'addresses'     => 'c,r,u,d',
            'campaigns'     => 'r,c,d',
            'districts'     => 'c,r,u,d',
        ],
        'warehouse'       => [
            'cells'      => 'r,u',
            'deliveries' => 'r,u',
        ],
        'courier'         => [
            'deliveries' => 'r,u',
        ],
    ],
    'permission_structure' => [

    ],
    'permissions_map'      => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
    ],
];
