<?php

return [
    'billing' => [
        'name' => 'SeAT Billing',
        'icon' => 'fas fa-credit-card',
        'route_segment' => 'billing',
        'entries' => [
            'billing' => [
                'name' => 'Billing Data',
                'icon' => 'fas fa-money-bill',
                'route' => 'billing.view',
                'permission' => 'billing.view',
            ],
            'settings' => [
                'name' => 'Settings',
                'icon' => 'fas fa-cog',
                'route' => 'billing.settings',
                'permission' => 'billing.settings',
            ],
            'personal' => [
                'name' => 'User',
                'icon' => 'fas fa-user',
                'route' => 'billing.userBill',
            ],
            'tax' => [
                'name' => 'Tax Invoices',
                'icon' => 'fas fa-user',
                'route' => 'tax.userTaxInvoices',
            ],
            'corporation_tax' => [
                'name' => 'Tax Management',
                'icon' => 'fas fa-briefcase',
                'route' => 'tax.corporationSelectionPage',
                'permission'=>'billing.tax_manager',
            ],
            [
                'name' => 'Настройки скидок',
                'icon' => 'fas fa-percentage',
                'route_segment' => 'discount-settings',
                'route' => 'billing.discount.settings',
                'permission' => 'billing.view'
            ],
        ],
    ],
];
