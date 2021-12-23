<?php

namespace App\Http\Controllers\Admin;

use Alert;
use App\Http\Requests;
use App\Models\Admin;
use App\Models\Faq;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $view = [
        'sub_title' => 'Administration members',
    ];

    protected $list = [
        'avatar'            => [
            'type' => 'image',
        ],
        'role.display_name' => [
            'label' => 'Role',
        ],
        'name',
        'email',
    ];

    protected $fields = [
        [
            'name'       => 'avatar',
            'type'       => 'image',
            'label'      => 'Avatar',
            'validation' => 'nullable|image',
        ],
        [
            'name'              => 'name',
            'label'             => 'Name',
            'type'              => 'text',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
            'validation'        => 'required|string|min:3',
        ],
        [
            'label'             => 'Role',
            'type'              => 'select2',
            'name'              => 'role_id',
            'attribute'         => 'display_name',
            'model'             => 'App\Models\Role',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
            'validation'        => 'required|integer',
            'allowNull'         => true,
        ],
        [
            'name'              => 'show_menu',
            'label'             => 'Show menu',
            'type'              => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
        ],
        [
            'name'              => 'separate_order',
            'label'             => 'Separate Order',
            'type'              => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
        ],
        [
            'type' => 'html',
            'html' => '<div class="form-group mt-10 col-lg-12">&nbsp;</div>',
        ],
        [
            'label'             => "Filials",
            'type'              => 'select2_multiple',
            'name'              => 'filials',
            'entity'            => 'filials',
            'attribute'         => 'name',
            'model'             => 'App\Models\Filial',
            'pivot'             => true,
            'validation'        => 'nullable|array',
            'wrapperAttributes' => [
                'class' => 'col-md-12',
            ],
        ],
        [
            'label'             => "Districts",
            'type'              => 'select2_multiple',
            'name'              => 'districts',
            'entity'            => 'districts',
            'attribute'         => 'full_name',
            'model'             => 'App\Models\District',
            'pivot'             => true,
            'validation'        => 'nullable|array',
            'wrapperAttributes' => [
                'class' => 'col-md-12',
            ],
        ],
        [
            'type' => 'html',
            'html' => '<div class="form-group mt-10 col-lg-12">Login</div>',
        ],
        [
            'name'              => 'email',
            'label'             => 'Email',
            'type'              => 'email',
            'validation'        => 'required|email|unique:admins,email',
            'wrapperAttributes' => [
                'class' => 'col-md-6',
            ],
        ],
        [
            'name'              => 'password',
            'label'             => 'Password',
            'type'              => 'password',
            'validation'        => [
                'store'  => 'required|string|min:6',
                'update' => 'nullable|string|min:6',
            ],
            'wrapperAttributes' => [
                'class' => 'col-md-6',
            ],
        ],
    ];

    public function store(Request $request)
    {
        $return = parent::store($request);
        $admin = Admin::latest()->first();
        $admin->roles()->sync([$request->get('role_id')]);

        return $return;
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);
        $admin->roles()->sync([$request->get('role_id')]);

        return parent::update($request, $id);
    }
}
