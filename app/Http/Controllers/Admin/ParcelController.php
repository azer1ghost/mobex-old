<?php

namespace App\Http\Controllers\Admin;

use Alert;
use App\Models\Parcel;

class ParcelController extends Controller
{
    protected $can = [
        'export' => false,
        'update' => false,
        'create' => false,
        'delete' => false,
    ];

    protected $extraActions = [
        [
            'key'   => 'custom_id',
            'label' => 'Export [XLS]',
            'icon'  => 'file-download',
            'route' => 'packages.export',
            'query' => [
                'format' => 'Xlsx',
            ],
            'color' => 'info',
        ],
        [
            'key'   => 'custom_id',
            'label' => 'Export [PDF]',
            'icon'  => 'file-download',
            'route' => 'packages.export',
            'query' => [
                'format' => 'Mpdf',
            ],
            'color' => 'info',
        ],
        [
            'key'   => 'custom_id',
            'label' => 'Manifest [XLS]',
            'icon'  => 'download',
            'route' => 'packages.manifest',
            'query' => [
                'format' => 'Xlsx',
            ],
            'color' => 'success',
        ],
        [
            'route'  => 'parcels.label',
            'key'    => 'id',
            'label'  => 'Label',
            'icon'   => 'windows2',
            'color'  => 'success',
            'target' => '_blank',
        ],
    ];

    protected $route = 'parcels';

    protected $notificationKey = 'custom_id';

    protected $modelName = 'Parcel';

    protected $view = [
        'search' => [
            [
                'type'              => 'select2',
                'name'              => 'warehouse_id',
                'attribute'         => 'country.name',
                'model'             => 'App\Models\Warehouse',
                'wrapperAttributes' => [
                    'class' => 'col-lg-3',
                ],
                'allowNull'         => 'All warehouses',
            ],
        ],
    ];

    protected $list = [
        'warehouse.country' => [
            'label' => 'Country',
            'type'  => 'country',
        ],
        'custom_id'         => [
            'label' => 'CWB No',
        ],
        "tracking_code"     => [
            'label' => 'Tracking #',
        ],
        'user'              => [
            'type'  => 'custom.user',
            'label' => 'User',
        ],
        'weight_with_type'  => [
            'label' => 'Weight',
            'type'  => 'text',
        ],
        'number_items'      => [
            'label' => 'Items',
        ],
        'custom_status'     => [
            'type'  => 'customs',
            'label' => 'SC',
        ],
        'status_with_label' => [
            'label' => 'Status',
        ],

        'created_at' => [
            'label' => 'At',
            'type'  => 'date',
        ],
    ];

    public function indexObject()
    {
        $items = Parcel::with(['packages'])->withCount([
            'packages',
            'waiting',
        ])->whereHas('packages')->orderBy('sent', 'asc')->orderBy('real', 'asc')->orderBy('custom_id', 'desc')->latest();
        if (\Request::get('warehouse_id') != null) {
            $items->where('warehouse_id', \Request::get('warehouse_id'));
        }

        return $items->paginate();
    }

    public function panelView($blade)
    {
        return 'admin.parcel.index';
    }

    /**
     * Label for package
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function label($id)
    {
        $item = Parcel::withCount(['packages'])->find($id);

        if (! $item) {
            Alert::warning('Parcel not found');

            return redirect()->back();
        }

        return view('admin.widgets.parcel_label', compact('item'));
    }
}
