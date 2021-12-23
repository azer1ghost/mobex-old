<?php

namespace App\Http\Controllers\Warehouse;

use Alert;
use App\Exports\Warehouse\PackagesExport;
use App\Exports\Warehouse\ManifestExport;
use App\Http\Controllers\Admin\Controller;
use App\Models\Extra\Notification;
use App\Models\Package;
use App\Models\PackageLog;
use App\Models\Parcel;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Validator;

class UserController extends Controller
{
    protected $modelName = 'Warehouse';

    protected $view = [
        'formColumns' => 10,
    ];

    protected $route = 'my';

    protected $notificationKey = 'name';

    protected $fields = [
        /* [
             'name'              => 'parcelling',
             'label'             => 'Parcelling',
             'type'              => 'checkbox',
             'wrapperAttributes' => [
                 'class' => 'form-group col-lg-2',
             ],
         ],*/
        [
            'name'              => 'show_label',
            'label'             => 'Show Label on scan',
            'type'              => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'form-group col-lg-2',
            ],
        ],
        [
            'name'              => 'show_invoice',
            'label'             => 'Show Invoice on scan',
            'type'              => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'form-group col-lg-2',
            ],
        ],
        /*[
            'name'              => 'auto_print',
            'label'             => 'Auto Print',
            'type'              => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'form-group col-lg-2',
            ],
        ],
        [
            'label'             => 'Label Printer',
            'type'              => 'select_from_array',
            'options'           => [],
            'wrapperAttributes' => [
                'class' => 'col-lg-3',
                'id'    => 'label_printer',
            ],
            'allowNull'         => 'Loading',
        ],
        [
            'label'             => 'Invoice Printer',
            'type'              => 'select_from_array',
            'options'           => [],
            'wrapperAttributes' => [
                'class' => 'col-lg-3',
                'id'    => 'invoice_printer',
            ],
            'allowNull'         => 'Loading',
        ],*/
    ];

    public function __construct()
    {
        parent::__construct();

        \View::share('bodyClass', 'sidebar-xs');
    }

    public function editObject($id = null)
    {
        return Warehouse::find(auth()->guard('worker')->user()->warehouse_id);
    }
}
