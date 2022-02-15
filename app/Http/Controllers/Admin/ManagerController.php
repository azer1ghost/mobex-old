<?php

namespace App\Http\Controllers\Admin;

use App\Models\Branch;
use App\Models\Manager;

class ManagerController extends Controller
{
    protected $notificationKey = 'id';

    protected $view = [
        'name' => null,
    ];

    protected $list = [
        'branch.name' => [
            'label' => 'Branch',
        ],
        'name',
        'email',
    ];

    protected $fields = [
        [
            'name'              => 'name',
            'label'             => 'Name',
            'type'              => 'text',
            'validation'        => 'required|string',
            'wrapperAttributes' => [
                'class' => 'col-md-4',
            ],
        ],
        [
            'name'              => 'email',
            'label'             => 'Email',
            'type'              => 'email',
            'validation'        => 'required|email|unique:workers,email',
            'wrapperAttributes' => [
                'class' => 'col-md-4',
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
                'class' => 'col-md-4',
            ],
        ],
    ];

    public function __construct()
    {
        $branch_id = request()->route('branch_id');

        $branch = Branch::find($branch_id);

        if (! $branch) {
            return back();
        }

        $this->routeParams = [
            'branch_id' => $branch->id,
        ];

        $this->view['name'] = 'Managers for ' . $branch->name;

        parent::__construct();
    }

    public function indexObject()
    {
        return Manager::where('branch_id', $this->routeParams['branch_id'])->paginate($this->limit);
    }
}
