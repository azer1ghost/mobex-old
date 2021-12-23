<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;

class SettingController extends Controller
{
    protected $view = [
        'formColumns' => 10,
        'sub_title'   => 'Front side settings',
    ];

    protected $can = [
        'create' => false,
        'delete' => false,
    ];

    protected $list = [
        'email',
        'phone',
        'facebook',
        'twitter',
    ];

    protected $fields = [
        [
            'name'              => 'header_logo',
            'type'              => 'image',
            'label'             => 'Header logo',
            'asset'             => 'uploads/setting/',
            'validation'        => 'image',
            'hint'              => 'Size 158x42 is good',
            'wrapperAttributes' => [
                'class' => 'form-group col-lg-6',
            ],
        ],
        [
            'name'              => 'footer_logo',
            'type'              => 'image',
            'label'             => 'Footer logo',
            'asset'             => 'uploads/setting/',
            'validation'        => 'image',
            'hint'              => 'Size 160x60 is good',
            'wrapperAttributes' => [
                'class' => 'form-group col-lg-6',
            ],
        ],
        [
            'type' => 'html',
            'html' => '<div class="form-group col-lg-12"><h3 class="text-center">Socials</h3></div>',
        ],
        [
            'name'              => 'facebook',
            'label'             => 'Facebook',
            'type'              => 'url',
            'prefix'            => '<i class="icon-facebook"></i>',
            'wrapperAttributes' => [
                'class' => 'form-group col-lg-6',
            ],
        ],
        [
            'name'              => 'twitter',
            'label'             => 'Twitter',
            'type'              => 'url',
            'prefix'            => '<i class="icon-twitter"></i>',
            'wrapperAttributes' => [
                'class' => 'form-group col-lg-6',
            ],
        ],
        [
            'type' => 'html',
            'html' => '<div class="form-group col-lg-12"></div>',
        ],
        [
            'name'              => 'instagram',
            'label'             => 'Instagram',
            'type'              => 'url',
            'prefix'            => '<i class="icon-instagram"></i>',
            'wrapperAttributes' => [
                'class' => 'form-group col-lg-6',
            ],
        ],
        [
            'name'              => 'linkedin',
            'label'             => 'Linkedin',
            'type'              => 'url',
            'prefix'            => '<i class="icon-linkedin"></i>',
            'wrapperAttributes' => [
                'class' => 'form-group col-lg-6',
            ],
        ],

        [
            'type' => 'html',
            'html' => '<div class="form-group col-lg-12"><h3 class="text-center">Contact</h3></div>',
        ],

        [
            'name'              => 'address',
            'type'              => 'textarea',
            'label'             => 'Address',
            'wrapperAttributes' => [
                'class' => 'form-group col-lg-12',
            ],
        ],
        [
            'name'   => 'contact_map',
            'type'   => 'text',
            'label'  => 'Map location (Embed URL)',
            'prefix' => '<i class="icon-location4"></i>',
        ],
        [
            'name'              => 'email',
            'type'              => 'email',
            'label'             => 'Email',
            'wrapperAttributes' => [
                'class' => 'form-group col-lg-4',
            ],
        ],
        [
            'name'              => 'phone',
            'type'              => 'text',
            'label'             => 'Phone',
            'prefix'            => '<i class="icon-mobile3"></i>',
            'wrapperAttributes' => [
                'class' => 'form-group col-lg-4',
            ],
        ],
        [
            'name'              => 'whatsapp',
            'type'              => 'text',
            'label'             => 'WhatsApp',
            'prefix'            => '<i class="icon-mobile"></i>',
            'wrapperAttributes' => [
                'class' => 'form-group col-lg-4',
            ],
        ],
    ];
}
