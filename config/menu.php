<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Admin Navigation Menu
    |--------------------------------------------------------------------------
    |
    | This array is for Navigation menus of the backend.  Just add/edit or
    | remove the elements from this array which will automatically change the
    | navigation.
    |
    */

    //SIDEBAR LAYOUT - MENU

    'sidebar' => [
        [
            'title' => 'Dashboard',
            'link'  => '/admin',
            'active' => 'admin',
            'icon'  => 'fa fa-dashboard',
        ],
        [
            'title' => 'Customers',
            'link'  => '#',
            'active' => 'admin/customers*',
            'icon'  => 'fa fa-user',
            'children' => [
                [
                    'title' => 'All Customers',
                    'link'  => '/admin/customers',
                    'active' => 'admin/customers',
                ],
            ]
        ],
        [
            'title' => 'Bookings',
            'link'  => '#',
            'active' => 'admin/bookings*',
            'icon'  => 'fa fa-list',
            'children' => [
                [
                    'title' => 'Booking List',
                    'link'  => '/admin/bookings',
                    'active' => 'admin/bookings',
                ],
            ]
        ],
        [
            'title' => 'Memberships',
            'link'  => '#',
            'active' => 'admin/memberships*',
            'icon'  => 'fa fa-list',
            'children' => [
                [
                    'title' => 'Membership List',
                    'link'  => '/admin/memberships',
                    'active' => 'admin/memberships',
                ],
            ]
        ],
        [
            'title' => 'Person List',
            'link'  => '#',
            'active' => 'admin/personlist*',
            'icon'  => 'fa fa-list',
            'children' => [
                [
                    'title' => 'School',
                    'link'  => '/admin/personlist/school',
                    'active' => 'admin/personlist/school',
                ],
                [
                    'title' => 'Hotel',
                    'link'  => '/admin/personlist/hotel',
                    'active' => 'admin/personlist/hotel',
                ],
            ]
        ],
        [
            'title' => 'Statistics',
            'link'  => '#',
            'active' => 'admin/statistics*',
            'icon'  => 'fa fa-list',
            'children' => [
                [
                    'title' => 'Booking Analyze',
                    'link'  => '/admin/statistics/booking',
                    'active' => 'admin/statistics/booking',
                ],
                [
                    'title' => 'Profit Analyze',
                    'link'  => '/admin/statistics/profit',
                    'active' => 'admin/statistics/profit',
                ],
            ]
        ]
        /*[
            'title' => 'Settings',
            'link'  => '/admin/settings',
            'active' => 'admin/settings*',
            'icon'  => 'fa fa-cogs',
        ],*/
    ],

    //HORIZONTAL MENU LAYOUT -  MENU

    'horizontal' => [
        [
            'title' => 'Dashboard',
            'link'  => '/admin',
            'active' => 'admin',
            'icon'  => 'fa fa-dashboard',
        ],
        [
            'title' => 'Settings',
            'link'  => '/admin/settings',
            'active' => 'admin/settings*',
            'icon'  => 'fa fa-cogs',
        ],
        [
            'title' => 'Users',
            'link'  => '#',
            'active' => 'admin/users*',
            'icon'  => 'fa fa-user',
            'children' => [
                [
                    'title' => 'All Users',
                    'link'  => '/admin/users',
                    'active' => 'admin/users',
                ],
                [
                    'title' => 'User Profile',
                    'link'  => '/admin/users/1',
                    'active' => 'admin/users/*',
                ]
            ]
        ],
    ]
];