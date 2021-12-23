<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;

class SmsController extends Controller
{
    protected $view = [
        'formColumns' => 10,
        'sub_title'   => 'SMS Templates',
    ];

    protected $modelName = 'SMSTemplate';

    protected $list = [
        'key',
        'name',
        'content',
        'active' => [
            'type' => 'boolean',
        ],
    ];

    protected $fields = [

        [
            'name'       => 'key',
            'label'      => 'Key (unique)',
            'type'       => 'text',
            'validation' => 'required|string|min:2|unique:s_m_s_templates,key',
        ],
        [
            'name'       => 'name',
            'label'      => 'Name',
            'type'       => 'text',
            'validation' => 'required|string|min:2',
        ],
        [
            'name'              => 'content',
            'label'             => 'Content',
            'type'              => 'textarea',
            'validation'        => 'required|string|min:2',
            'wrapperAttributes' => [
                'class' => ' col-md-9 campaign_content',
            ],
            'attributes'        => [
                'rows' => 8,
            ],
        ],

        [
            'type' => 'html',
            'html' => '<div class="col-md-3">
                                <h6>Variables you can use</h6>
                                <ul>
                                    <li><b>:id</b> : DB id number</li>
                                    <li><b>:user</b> : User`s fullname</li>
                                    <li><b>:code</b> : User`s Mobex code</li>
                                    <li><b>:city</b> : User`s city name</li>
                                    <li><b>:track_code</b> : Tracking number</li>
                                    <li><b>:cwb</b> : Mobex CWB number</li>
                                    <li><b>:price</b> : Delivery price $xx/xx₼</li>
                                    <li><b>:web_site</b> : Web Site name</li>
                                    <li><b>:country</b> : Country name</li>
                                    <li><b>:weight</b> : Weight</li>
                                </ul>
                            </div>',
        ],
        [
            'type' => 'html',
            'html' => '<div class="form-group col-lg-12 mt-10"><br/></div>',
        ],
        [
            'name'  => 'active',
            'label' => 'Active',
            'type'  => 'checkbox',
        ],
        [
            'name'       => 'push_link',
            'label'      => 'Push Notification link',
            'type'       => 'text',
            'validation' => 'nullable|string|min:2',
        ],
    ];
}
