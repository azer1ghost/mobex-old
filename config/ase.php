<?php
return [
    'information' => [
        'phone'      => '*123',
        'help_email' => 'help@' . env('DOMAIN_NAME'),
    ],
    'currency'    => 'USD',
    'card_number' => [
        'validation' => '9999-9999-99',
    ],
    'default'     => [
        'no-image' => 'uploads/default/no-image.jpg',
        'avatar'   => 'uploads/default/avatar.png',
    ],
    'send'        => [
        'as'   => 'info@' . env('DOMAIN_NAME'),
        'name' => env('APP_NAME'),
    ],
    'warehouse'   => [
        'filter' => [
            0 => 'All',
            1 => 'Requested',
        ],
        'cells'  => [
            'A' => 6,
            'B' => 6,
            'C' => 6,
            'D' => 6,
            'E' => 6,
            'F' => 6,

            'G' => 6,
            'H' => 6,

            'I' => 6,
            'J' => 6,
            'K' => 6,
            'L' => 6,

            'M' => 6,
            'N' => 6,
            'P' => 6,
            'Q' => 6,
            'R' => 6,

            'LN' => 1,
        ],

        'main_cells' => [
            'D' => 5,
            'E' => 5,
            'F' => 5,
            'G' => 5,
        ],

        'liquid_cells'  => [
            'H' => 5,
        ],
        'battery_cells' => [
            'I' => 2,
        ],
    ],
    'attributes'  => [
        'yes_no'             => [
            0 => 'No',
            1 => 'Yes',
        ],
        'pagination'         => [25 => 25, 50 => 50, 75 => 75, 100 => 100, 250 => 250],
        'currencies'         => [3 => 'TRY', 0 => 'USD', 1 => 'AZN', 2 => 'EUR', 4 => 'RUB', 5 => 'GBP', 6 => 'KZT'],
        'customs_currencies' => [3 => 949, 0 => 840, 1 => 932, 2 => 'EUR', 4 => 978, 5 => 826, 6 => 398],
        'currenciesWithKey'  => [
            'TRY' => 'TRY',
            'USD' => 'USD',
            'AZN' => 'AZN',
            'EUR' => 'EUR',
            'RUB' => 'RUB',
            'GBP' => 'GBP',
            'KZT' => 'KZT',
        ],
        'currenciesConvert'  => [1, 1.7, 0.9068732, 5.97619, 63.3873, 0.764390, 378.77],
        'length'             => ['cm', 'in'],
        'lengthConvert'      => [1, 2.54],
        'weight'             => ['kg', 'lbs', 'stn'],
        'weightConvert'      => [1, 0.45359237, 0.157],
        'request'            => [
            'link'            => [
                'status'          => ['Active', 'Not found', 'Out of stock', 'Not paid enough', 'Forbidden'],
                'statusTrans'     => [
                    'front.active',
                    'front.not_found',
                    'front.out_of_stock',
                    'front.not_paid_enough',
                    'front.forbidden',
                ],
                'statusWithLabel' => '[{value: 0, text: "Active"}, {value: 1, text: "Not found"}, {value: 2, text: "Out of stock"}, {value: 3, text: "Not paid enough"}, {value: 4, text: "Forbidden"}]',
            ],
            'status'          => ['New Order', 'Paid', 'Ordered', 'Delivered', 'Canceled', 'Accepted', 'Deleted'],
            'statusTrans'     => [
                'front.new_order',
                'front.paid',
                'front.ordered',
                'front.delivered',
                'front.canceled',
                'front.accepted',
            ],
            'statusWithLabel' => '[{value: 0, text: "New Order"}, {value: 1, text: "Paid"}, {value: 2, text: "Ordered"}, {value: 3, text: "Delivered"}, {value: 4, text: "Canceled"}, {value: 5, text: "Accepted"}]',
        ],
        'package'            => [
            'label'                => ['Hide', 'Show'],
            'labelWithLabel'       => "{'1': 'Show'}",
            'dec'                  => [
                1 => 'Not Declared',
                2 => 'Ready',
                3 => 'All with Done',
                4 => 'All with Deleted',
            ],
            'date_by'              => [
                'created_at' => 'by Created Date',
                'arrived_at' => 'by Arrived Date',
                'done_at'    => 'by Completed Date',
                'sent_at'    => 'by Sent Date',
                'scanned_at' => 'by Delivered Date',
            ],
            'paid'                 => [
                0 => 'No',
                1 => 'Yes',
                2 => 'POST_TERMINAL',
                3 => 'GIFT_CARD',
                4 => 'BONUS',
                5 => 'CARD_TO_CARD',
                6 => 'PACKAGE_BALANCE',
            ],
            'status'               => [
                6 => 'Early Declaration',
                0 => 'In Warehouse',
                1 => 'Sent',
                2 => 'In Filial',
                3 => 'Done',
                4 => 'In customs',
                5 => 'Refunded',
                7 => 'In courier',
                8 => 'On way',
                9 => 'In Branch'
            ],
            'status_az'               => [
                6 => 'Erkən Bəyan',
                0 => 'Xarici anbarda',
                1 => 'Göndərilib',
                2 => 'Filialda',
                3 => 'Təhvil verilib',
                4 => 'Saxlancda',
                5 => 'Geri qaytarılıb',
                7 => 'Kuryerdə',
                8 => 'Yolda',
                9 => 'Məntəqədə'
            ],
            'status_for_warehouse' => [
                0 => 'In Warehouse',
                6 => 'Early Declaration',
            ],
            'statusWithLabel'      => '[{value: 0, text: "In Warehouse"}, {value: 1, text: "Sent"}, {value: 2, text: "In Filial"}, {value: 3, text: "Done"}, {value: 4, text: "In customs"}, {value: 5, text: "Refunded"}, {value: 6, text: "Early Declaration"}]',
            'paidWithLabel'        => '[{value: 0, text: "No"}, {value: 1, text: "Yes"}, {value: 2, text: "By POST_TERMINAL"}, {value: 3, text: "By GIFT_CARD"}, {value: 4, text: "By BONUS"}, {value: 5, text: "By Card to Card"}, {value: 6, text: "By Package Balance"}]',
        ],
        'delivery'           => [
            'status' => [
                0 => 'Pending',
                1 => 'Ready',
                2 => 'On way',
                3 => 'Delivered',
                4 => 'Wrong Address',
                5 => 'Not reached',
                6 => 'Back to Warehouse',
            ],

            'statusWithLabel'             => '[{value: 0, text: "Pending"}, {value: 1, text: "Ready"}, {value: 2, text: "On way"}, {value: 3, text: "Delivered"}, {value: 4, text: "Wrong Address"}, {value: 5, text: "Not reached"}, {value: 6, text: "Back to Warehouse"}]',
            'statusForWarehouseWithLabel' => '[{value: 0, text: "Pending"}, {value: 1, text: "Ready"}]',
            'statusForCourierWithLabel'   => '[{value: 1, text: "Ready"}, {value: 2, text: "On way"}, {value: 3, text: "Delivered"}, {value: 4, text: "Wrong Address"}, {value: 5, text: "Not reached"}, {value: 6, text: "Back to Warehouse"}]',
        ],
        'transaction'        => [
            'types'    => [
                'OUT'    => 'OUT',
                'IN'     => 'IN',
                'REFUND' => 'Refund',
                'DEBT'   => 'Debt',
            ],
            'paid_for' => [
                null               => '-',
                'PACKAGE_BALANCE'  => 'Package Balance',
                'ORDER_BALANCE'    => 'Order Balance',
                'ORDER'            => 'Order',
                'PACKAGE'          => 'Package',
                'PACKAGE_SHIPPING' => 'Package Shipping',
            ],
            'paid_by'  => [
                'CASH'            => 'Cash',
                'EMANAT'          => 'eManat',
                'HESABAZ'         => 'Hesab.az',
                'POST_TERMINAL'   => 'Post Terminal',
                'CARD_TO_CARD'    => 'CARD To CARD',
                'PORTMANAT'       => 'PortManat',
                'GIFT_CARD'       => 'Gift Card',
                'ORDER_BALANCE'   => 'Order Balance',
                'PACKAGE_BALANCE' => 'Package Balance',
                'BONUS'           => 'Bonus',
                'OTHER'           => 'Other',
            ],
            'by'       => [
                'BONUS'           => 0,
                'GIFT_CARD'       => 0,
                'CASH'            => 1,
                'PAY_TR'          => 1,
                'PAYMES'          => 1,
                'MILLION'         => 1,
                'EMANAT'          => 1,
                'HESABAZ'         => 1,
                'PORTMANAT'       => 1,
                'POST_TERMINAL'   => 1,
                'CARD_TO_CARD'    => 1,
                'REFERRAL'        => -1,
                'CASHBACK'        => -1,
                'PACKAGE_BALANCE' => -1,
                'ORDER_BALANCE'   => -1,
                'OTHER'           => 1,
            ],
        ],
    ],
    'addresses'   => [
        'tr' => [
            'BAHCELIEVLER BAHCELIEVLER',
            'LOGYPARK BAHCELIEVLER',
        ],

    ],
];