<?php

namespace App\Http\Controllers\Warehouse;

use Alert;
use App\Exports\PackagesExport;
use App\Http\Controllers\Admin\Controller;
use App\Models\Extra\Notification;
use App\Models\Package;
use App\Models\PackageLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Validator;

class ProcessedController extends Controller
{
    protected $modelName = 'Package';

    protected $can = [
        'delete' => false,
        'update' => false,
        'create' => false,
    ];

    protected $view = [

        'search' => [
            [
                'name'              => 'q',
                'type'              => 'text',
                'attributes'        => ['placeholder' => 'Search...'],
                'wrapperAttributes' => [
                    'class' => 'col-lg-3 col-lg-offset-1',
                ],
            ],
            [
                'name'       => 'event_date_range',
                'start_name' => 'start_date',
                'end_name'   => 'end_date',
                'type'       => 'date_range',

                'date_range_options' => [
                    'timePicker' => true,
                    'locale'     => ['format' => 'DD/MM/YYYY'],
                ],
                'wrapperAttributes'  => [
                    'class' => 'col-lg-2',
                ],
            ],
        ],
    ];

    protected $route = 'w-processed';

    protected $notificationKey = 'custom_id';

    protected $extraActions = [
        [
            'key'    => 'invoice',
            'label'  => 'Invoice',
            'icon'   => 'file-pdf',
            'color'  => 'info',
            'target' => '_blank',
        ],
        [
            'route'  => 'w-packages.label',
            'key'    => 'show_label',
            'label'  => 'Label',
            'icon'   => 'windows2',
            'color'  => 'success',
            'target' => '_blank',
        ],
    ];

    protected $list = [
        'parcel'           => [
            'type'  => 'parcel',
            'label' => 'Parcel',
        ],
        'custom_id'        => [
            'label' => 'CWB No',
        ],
        "tracking_code"    => [
            'label' => 'Tracking #',
        ],
        'user'             => [
            'type'  => 'custom.user',
            'label' => 'User',
        ],
        'weight_with_type' => [
            'label' => 'Weight',
        ],
        /* 'full_size'        => [
             'label' => 'W/H/L',
         ],*/
        'number_items'     => [
            'label' => 'Items',
        ],

        'status_with_label' => [
            'label' => 'Status',
        ],
        'worker'            => [
            'label' => 'Worker',
        ],
        'arrived_at'        => [
            'label' => 'Arrived At',
            'type'  => 'date',
        ],
        'sent_at'           => [
            'label' => 'Sent At',
            'type'  => 'date',
        ],
    ];

    public function __construct()
    {
        parent::__construct();

        \View::share('bodyClass', 'sidebar-xs');
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function indexObject($status = null)
    {
        $validator = Validator::make(\Request::all(), [
            'q'            => 'nullable|string',
            'warehouse_id' => 'nullable|integer|min:0',
            'status'       => 'nullable|integer|min:0',
            'start_date'   => 'nullable|date',
            'end_date'     => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return ['error' => 'Unexpected variables!'];
        }

        //$countryId = $this->me()->country_id;

        $status = request()->segment(2);

        if ($status == null) {
            $statuses = [2, 3, 4, 5];
        } else {
            $statuses = [1];
        }

        $items = Package::whereWarehouseId($this->id())->whereIn('status', $statuses);

        if (\Request::get('q') != null) {
            $q = \Request::get('q');

            $items->where(function ($query) use ($q) {
                $query->where("tracking_code", "LIKE", "%" . $q . "%")->orWhere("custom_id", "LIKE", "%" . $q . "%")->orWhereHas('user', function (
                    $query
                ) use ($q) {
                    $query->where('customer_id', 'LIKE', '%' . $q . '%');
                });
            });
        }

        if (\Request::get('start_date') != null) {
            $items->where('sent_at', '>=', \Request::get('start_date'));
        }
        if (\Request::get('end_date') != null) {
            $items->where('sent_at', '<=', Carbon::createFromFormat("Y-m-d", \Request::get('end_date'))->addDay());
        }

        return $items->latest()->paginate($this->limit);
    }

    /**
     * Get id
     *
     * @return mixed
     */
    public function id()
    {
        return $this->me()->getAuthIdentifier();
    }

    public function me()
    {
        return auth()->guard('worker')->user()->warehouse;
    }
}
