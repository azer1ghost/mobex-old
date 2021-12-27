<?php

namespace App\Http\Controllers\Warehouse;

use Alert;
use App\Exports\PackagesExport;
use App\Exports\Warehouse\ManifestExport;
use App\Http\Controllers\Admin\Controller;
use App\Models\Extra\Notification;
use App\Models\Package;
use App\Models\PackageLog;
use App\Models\PackageType;
use App\Models\Parcel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;
use Validator;

class ParcellingController extends Controller
{
    protected $modelName = 'Parcel';

    protected $view = [

        /*'search'    => [
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
        ],*/
    ];

    protected $route = 'w-parcels';

    protected $notificationKey = 'custom_id';

    protected $extraButtons = [
        [
            'key'   => 'send',
            'route' => 'w-parcels.sendAll',
            'label' => 'Send',
            'icon'  => 'airplane3',
            'color' => 'info',
            'query' => [
                'type' => 'ready',
            ],
        ],
        [
            'key'    => 'scan',
            'route'  => 'w-parcels.manifest',
            'label'  => 'Manifest',
            'icon'   => 'file-download',
            'color'  => 'success',
            'target' => 'blank',
            'query'  => [
                'type' => 'ready',
            ],
        ],
    ];

    protected $extraActions = [
        [
            'key'    => 'sent',
            'custom' => true,
        ],
        [
            'key'   => 'custom_id',
            'label' => 'Manifest [XLS]',
            'icon'  => 'download',
            'route' => 'w-packages.manifest',
            'color' => 'warning',
            'query' => [
                'format' => 'Xlsx',
            ],
        ],
        [
            'route'  => 'w-parcels.label',
            'key'    => 'id',
            'label'  => 'Label',
            'icon'   => 'windows2',
            'color'  => 'success',
            'target' => '_blank',
        ],
    ];

    protected $fields = [
        [
            'name'    => 'show_label',
            'type'    => 'hidden',
            'default' => 1,
            'short'   => true,
        ],
        [
            'name'    => 'length_type',
            'type'    => 'hidden',
            'default' => 0,
            'short'   => true,
        ],
        [
            'name'    => 'shipping_amount_cur',
            'type'    => 'hidden',
            'default' => 0,
            'short'   => true,
        ],
        [
            'name'              => 'tracking_code',
            'label'             => 'Tracking Code',
            'type'              => 'text',
            'short'             => true,
            'hint'              => 'Special Tracking number (optional)',
            'prefix'            => '<i class="icon-barcode2"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
            'attributes'        => [
                'autofocus'                => true,
                'data-validation-optional' => 'true',
                //'data-validation'          => 'length custom',
                //'data-validation-length'   => "min9",
                //'data-validation-regexp'   => "^[A-Za-z0-9-]+$",
            ],
            'validation'        => 'nullable|string|min:9|unique:packages,tracking_code',
        ],

        [
            'label'             => 'User',
            'type'              => 'select2',
            'name'              => 'user_id',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
            'validation'        => 'required|integer',
            'allowNull'         => true,
            'attributes'        => [
                'data-validation' => 'required',
                'class'           => 'select2-ajax',
                'data-url'        => '/users',
            ],
        ],

//        [
//            'label'             => 'User',
//            'type'              => 'select_from_array',
//            'name'              => 'user_id',
//            'wrapperAttributes' => [
//                'class' => 'col-md-3 hidden_for_user',
//                'id'    => 'user_id',
//            ],
//            'validation'        => 'nullable|integer',
//            'allowNull'         => true,
//            'short'             => true,
//            'attributes'        => [
//                'data-validation' => 'required',
//                'class'           => 'select2-ajax',
//                'data-url'        => '/users',
//            ],
//        ],

        [
            'name'              => 'website_name',
            'label'             => 'WebSite name',
            'type'              => 'text',
            'hint'              => 'Also accept url',
            'wrapperAttributes' => [
                'class' => 'col-md-3 hidden_for_user',
            ],
            'prefix'            => '<i class="icon-link"></i>',
            'validation'        => 'nullable|string',
            'default'           => '',
            'attributes'        => [
                'data-validation' => 'required',
            ],
        ],
        [
            'name'              => 'shipping_amount',
            'label'             => 'Invoiced price',
            'type'              => 'text',
            'prefix'            => '<i class="icon-coin-dollar"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-2 hidden_for_user',
            ],
            'attributes'        => [
                'data-validation'          => 'required number',
                'data-validation-allowing' => "float",
            ],
            'validation'        => 'nullable|numeric',
        ],
        [
            'name'                => 'shipping_amount_cur',
            'label'               => '&nbsp',
            'type'                => 'select_from_array',
            'optionsFromConfig'   => 'ase.attributes.currencies',
            'default_by_relation' => 'country.currency',
            'wrapperAttributes'   => [
                'class' => 'col-md-1 hidden_for_user',
            ],
            'validation'          => 'nullable|integer',
            'attributes'          => [
                'tabindex' => '-1',
                'touch'    => 'no',
            ],
        ],
        [
            'type' => 'html',
            'html' => '<div class="form-group mt-10 col-lg-12"><h3 class="text-center">Weight</h3></div>',
        ],
        [
            'name'              => 'weight',
            'label'             => 'Gross Weight',
            'type'              => 'text',
            'wrapperAttributes' => [
                'class' => 'col-md-2 change_volume weight_id active_weight',
            ],
            'validation'        => 'nullable|numeric',
            'short'             => true,
            'prefix'            => '<i class="icon-meter2"></i>',
            'attributes'        => [
                'data-validation'          => 'required number',
                'data-validation-allowing' => "float",
            ],
        ],
        [
            'name'                => 'weight_type',
            'label'               => '&nbsp',
            'type'                => 'select_from_array',
            'optionsFromConfig'   => 'ase.attributes.weight',
            'default_by_relation' => 'country.weight_type',
            'short'               => true,
            'wrapperAttributes'   => [
                'class' => 'col-md-1',
            ],
            'attributes'          => [
                'tabindex' => '-1',
                'touch'    => 'no',
            ],
            'validation'          => 'nullable|integer',
        ],

        [
            'name'              => 'has_liquid',
            'label'             => 'Has liquid',
            'type'              => 'checkbox',
            'short'             => true,
            'wrapperAttributes' => [
                'class' => 'col-md-1 mt-15',
            ],
            'validation'        => 'nullable|integer',
            'attributes'        => [
                'tabindex' => '-1',
            ],
        ],
        [
            'name'              => 'has_battery',
            'label'             => 'Has Battery',
            'type'              => 'checkbox',
            'short'             => true,
            'wrapperAttributes' => [
                'class' => 'col-md-1 mt-15',
            ],
            'validation'        => 'nullable|integer',
            'attributes'        => [
                'tabindex' => '-1',
            ],
        ],
        [
            'name'              => 'width',
            'label'             => 'Width',
            'type'              => 'text',
            'wrapperAttributes' => [
                'class' => 'col-md-1 change_volume',
            ],
            'validation'        => 'nullable|numeric',
            'attributes'        => [
                'data-validation-optional' => 'true',
                'data-validation'          => 'number',
                'data-validation-allowing' => "float",
                'tabindex'                 => '-1',
            ],

        ],
        [
            'name'              => 'height',
            'label'             => 'Height',
            'type'              => 'text',
            'wrapperAttributes' => [
                'class' => 'col-md-1  change_volume',
            ],
            'validation'        => 'nullable|numeric',
            'attributes'        => [
                'data-validation-optional' => 'true',
                'data-validation'          => 'number',
                'data-validation-allowing' => "float",
                'tabindex'                 => '-1',
            ],

        ],
        [
            'name'              => 'length',
            'label'             => 'Length',
            'type'              => 'text',
            'wrapperAttributes' => [
                'class' => 'col-md-1 change_volume',
            ],
            'validation'        => 'nullable|numeric',
            'attributes'        => [
                'data-validation-optional' => 'true',
                'data-validation'          => 'number',
                'data-validation-allowing' => "float",
                'tabindex'                 => '-1',
            ],

        ],
        [
            'name'                => 'length_type',
            'label'               => '&nbsp',
            'type'                => 'select_from_array',
            'optionsFromConfig'   => 'ase.attributes.length',
            'default_by_relation' => 'country.length_type',
            'wrapperAttributes'   => [
                'class' => 'col-md-1',
            ],
            'validation'          => 'nullable|integer',
            'attributes'          => [
                'tabindex' => '-1',
                'touch'    => 'no',
            ],
        ],
        [
            'name'              => 'volume_weight',
            'label'             => 'Volume Weight (kg)',
            'type'              => 'text',
            'wrapperAttributes' => [
                'class' => 'col-md-2 volume_id',
            ],
            'validation'        => 'nullable|numeric',
            'prefix'            => '<i class="icon-meter2"></i>',
            'attributes'        => [
                'disabled' => 'disabled',
                'tabindex' => '-1',
            ],
        ],
        [
            'type' => 'html',
            'html' => '<div class="form-group mt-10 col-lg-12 hidden_for_user"><h3 class="text-center">Product description</h3></div>',
        ],
        [
            'type' => 'html',
            'html' => '<div class="row"><div id="type_section" class="col-lg-4 hidden_for_user"><div class="row type_item" id="main_type_item">',
        ],

        [
            'name'              => 'items[]',
            'label'             => 'Items',
            'type'              => 'text',
            'default'           => 1,
            'wrapperAttributes' => [
                'class' => 'col-md-2 hidden_for_user',
            ],
            'attributes'        => [
                'data-validation'          => 'required number',
                'data-validation-allowing' => "range[1;10000]",
            ],
            'validation'        => 'required|integer',
        ],
        [
            'label'             => 'Type',
            'type'              => 'select2_from_array',
            'name'              => 'types[]',
            'default'           => 108,
            'options'           => [],
            'attribute'         => 'translateOrDefault_tr.name',
            'model'             => 'App\Models\PackageType',
            'query'             => [
                'key'       => 'custom_id',
                'condition' => '!=',
                'value'     => null,
            ],
            'wrapperAttributes' => [
                'class' => 'col-md-9 hidden_for_user',
            ],
            'allowNull'         => true,
            'validation'        => 'nullable|integer',
            /* 'attributes'        => [
                 'data-validation' => 'required',
             ],*/
        ],
        [
            'type' => 'html',
            'html' => '<div class="col-lg-1 hidden_for_user"> <span class="btn btn-danger btn-icon btn_minus" style="margin-top: 20px"><i
                                        class="icon-minus2"></i></span></div>',
        ],
        [
            'type' => 'html',
            'html' => '</div></div><div class="col-lg-1 hidden_for_user"> <span id="add_type" class="btn btn-primary btn-icon" style="margin-top: 20px"><i
                                        class="icon-plus2"></i></span></div><div class="col-lg-3">',
        ],
        [
            'name'              => 'print_invoice',
            'label'             => 'Print Invoice',
            'type'              => 'checkbox',
            'default'           => true,
            'short'             => true,
            'wrapperAttributes' => [
                'class' => 'col-md-12',
            ],
            'validation'        => 'nullable|integer',
        ],
        [
            'name'              => 'check_limit',
            'label'             => 'Check Limit',
            'type'              => 'checkbox',
            'default'           => true,
            'short'             => true,
            'wrapperAttributes' => [
                'class' => 'col-md-12',
            ],
            'validation'        => 'nullable|integer',
        ],
        [
            'type' => 'html',
            'html' => '</div><div class="col-lg-4">',
        ],
        [
            'name'       => 'warehouse_comment',
            'label'      => 'Note',
            'type'       => 'textarea',
            'validation' => 'nullable|string',
        ],
        [
            'type' => 'html',
            'html' => '</div></div>',
        ],
    ];

    protected $extraActionsForPackage = [
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
        'custom_status'      => [
            'type'  => 'customs',
            'label' => 'SC',
        ],
        'custom_id'          => [
            'label' => 'CWB No',
        ],
        "tracking_code"      => [
            'label' => 'Tracking #',
        ],
        'user'               => [
            'type'  => 'custom.user',
            'label' => 'User',
        ],
        'warehouse_cell'     => [
            'label' => 'Cell',
        ],
        'shipping_org_price' => [
            'label' => 'Invoice',
            'type'  => 'text',
        ],

        'weight_with_type' => [
            'label' => 'Weight',
            'type'  => 'text',
        ],

        'number_items' => [
            'label' => 'Items',
        ],
        'worker'       => [
            'label' => 'Worker',
        ],
        'arrived_at'   => [
            'label' => 'Date',
            'type'  => 'date',
        ],
    ];

    public function __construct()
    {
        parent::__construct();

        \View::share('bodyClass', 'sidebar-xs');
        \View::share('extraActionsForPackage', $this->extraActionsForPackage);
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

    public function indexObject($status = null)
    {
        $status = request()->segment(2);

        \View::share('type', $status);

        $items = Parcel::withCount(['packages'])->with(['packages'])->whereHas('packages')->where('warehouse_id', $this->id());

        if ($status == 'ready') {
            $items = $items->where('sent', 0)->where('real', 1);
        } elseif ($status == 'sent') {
            $items = $items->where('sent', 1);
        } else {
            $items = $items->where('sent', 0)->where('real', 0);
        }

        $items = $items->orderBy('sent', 'asc')->orderBy('real', 'asc')->orderByRaw('LENGTH(custom_id) desc')->orderBy('custom_id', 'desc')->get();

        return $items;
    }

    public function panelView($blade)
    {
        return 'warehouse.parcel.index';
    }

    public function store(Request $request)
    {
        $defaultValue = Parcel::generateCustomId();

        return view('warehouse.parcel.create', compact('defaultValue'));
    }

    public function edit($id)
    {
        $parcel = Parcel::where('warehouse_id', $this->id())->where('id', $id)->where('sent', 0)->first();
        $lang = strtolower($this->me()->country->code) == 'tr' ? 'tr' : 'en';

        $categoriesObj = PackageType::with('children')->whereNull('parent_id')->whereNotNull('custom_id')->get();

        $categories = [];
        foreach ($categoriesObj as $category) {
            $categories[$category->id] = $category->translateOrDefault($lang)->name;
            if ($category->children) {
                foreach ($category->children as $sub_category) {
                    $categories[$sub_category->id] = "  -  " . $sub_category->translateOrDefault($lang)->name . " (" . $category->translateOrDefault($lang)->name . ")";
                }
            }
        }

        $this->fields[21]['options'] = $categories;

        if ($this->me()->web_site) {
            $this->fields[5]['default'] = $this->me()->web_site;
        }
        \View::share('fields', $this->fields);
        if (! $parcel) {
            Alert::error('The parcel was sent! You cannot add new package. Please create new one.');

            return redirect()->route('w-parcels.index');
        }

        return view('warehouse.parcel.edit', compact('parcel'));
    }

    public function create()
    {
        $status = \request()->get('type');

        $parcel = Parcel::with(['packages'])->whereHas('packages')->where('warehouse_id', $this->id());

        $name = "M1";
        if ($status == 'ready') {
            $name = "U1";
            $parcel = $parcel->where('sent', 0)->where('real', 1);
        } elseif ($status == 'sent') {
            $parcel = $parcel->where('sent', 1);
        } else {
            $parcel = $parcel->where('sent', 0)->where('real', 0);
        }

        $parcel = $parcel->orderBy('sent', 'asc')->orderBy('real', 'asc')->orderByRaw('LENGTH(custom_id) desc')->orderBy('custom_id', 'desc')->first();

        if ($parcel) {
            $name = explode("-", $parcel->custom_id)[0];
            $intName = (int) filter_var($name, FILTER_SANITIZE_NUMBER_INT);
            $name = str_replace($intName, $intName + 1, $name);
        }

        if ($status == 'ready') {
            $name = $name . "-" . date("d,m,Y");
        }

        $parcel = Parcel::create([
            'custom_id'    => $name,
            'warehouse_id' => $this->id(),
        ]);

        if (request()->has('items') && request()->get('items')) {
            $items = request()->get('items');

            if ($items) {
                $parcel->packages()->attach($items);
            }
            /* Alert::success(trans('saysay::crud.action_alert', [
                 'name'   => 'Parcel',
                 'key'    => 'customId',
                 'value'  => $parcel->custom_id,
                 'action' => 'created',
             ]));

             return redirect()->route($this->route . ".index");*/
        }

        return redirect()->route($this->route . '.edit', $parcel->id);
    }

    public function deletePackage($id, $packageId)
    {
        /* Attach new package to the parcel */
        $parcel = Parcel::where("id", $id)->where('sent', 0)->first();
        if (! $parcel) {
            return response()->json([
                'error' => 'Parcel already was sent, You cannot delete the package. Sorry!',
            ]);
        }

        return $parcel->packages()->detach($packageId);
    }

    public function sent($id)
    {
        $parcel = Parcel::with('packages')->find($id);
        if ($parcel && $parcel->is_real && $parcel->packages) {

            foreach ($parcel->packages as $package) {
                if ($package->status < 1) {
                    //$package->warehouse_cell = null;
                    $package->status = 1;
                    $package->save();

                    /* Send Notification */
                    Notification::sendPackage($package->id, '1');
                }
            }

            $parcel->sent = true;
            $parcel->save();

            Alert::success(trans('saysay::crud.action_alert', [
                'name'   => 'Parcel',
                'key'    => 'customId',
                'value'  => $parcel->custom_id,
                'action' => 'updated',
            ]));
        }

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        if (request()->get('awb') || request()->get('name')) {
            $items = request()->get('items');

            $parcel = Parcel::where('warehouse_id', $this->id())->where('id', $id)->first();

            if (! $parcel) {
                return redirect()->back();
            }

            // Is Real parcel
            if (request()->get('name')) {
                if (str_contains(request()->get('name'), "-")) {
                    $parcel->real = true;
                    foreach ($parcel->packages as $package) {
                        $package->warehouse_cell = null;
                        $package->save();
                    }
                } else {
                    $parcel->real = false;
                }
            }


            $parcel->custom_id = (request()->get('name') ?: Parcel::generateCustomId());
            $parcel->awb = str_replace(" ", "", str_replace("-", "", request()->get('awb')));
            $parcel->save();

            // Update all real parcels' awb
            if ($parcel->real && $parcel->awb) {

                Parcel::whereHas('packages')->where('warehouse_id', $this->id())->where('sent', 0)->where('real', 1)->where('awb', '!=', $parcel->awb)->update([
                    'awb' => $parcel->awb
                ]);
            }
            //$parcel->packages()->sync($items);

            Alert::success(trans('saysay::crud.action_alert', [
                'name'   => 'Parcel',
                'key'    => 'customId',
                'value'  => $parcel->custom_id,
                'action' => 'updated',
            ]));


            $route = $parcel->real ? ($parcel->sent ? 'sent' : 'ready') : 'not_ready';

            return redirect()->route('w-parcels.index', $route);
        } else {
            Alert::error('Add at least one package! ');

            return redirect()->back();
        }
    }

    public function index()
    {
        if (auth()->guard('worker')->user()->warehouse->auto_print && (! isset($_COOKIE['label_printer']) || ! isset($_COOKIE['invoice_printer']))) {

            return redirect()->route('my.edit', auth()->guard('worker')->user()->warehouse_id);
        }

        return parent::index(); // TODO: Change the autogenerated stub
    }

    /**
     * Label for package
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function label($id)
    {
        $item = Parcel::withCount(['packages'])->whereHas('packages')->where('warehouse_id', $this->id())->find($id);

        if (! $item) {
            Alert::warning('Parcel not found');

            return redirect()->back();
        }

        return view('admin.widgets.parcel_label', compact('item'));
    }

    public function manifest()
    {
        $status = \request()->get('type');
        $parcels = Parcel::with(['packages'])->whereHas('packages')->where('warehouse_id', $this->id());

        if ($status == 'ready') {
            $parcels = $parcels->where('sent', 0)->where('real', 1);
        } elseif ($status == 'sent') {
            $parcels = $parcels->where('sent', 1);
        } else {
            $parcels = $parcels->where('sent', 0)->where('real', 0);
        }
        $parcels = $parcels->get();

        $items = [];
        foreach ($parcels as $parcel) {
            $packageIds = $parcel->packages->pluck('id')->all();
            $items = array_merge($items, $packageIds);
        }
        $items = array_unique($items);

        return \Excel::download(new ManifestExport($items, null, 'Xlsx'), 'manifest_' . uniqid() . '.xlsx', 'Xlsx');
    }

    public function sendAll()
    {
        $status = \request()->get('type');
        if ($status == 'ready') {
            $parcels = Parcel::with(['packages'])->whereHas('packages')->where('warehouse_id', $this->id())->where('sent', 0)->where('real', 1)->get();

            $count = 0;
            foreach ($parcels as $parcel) {
                if ($parcel && $parcel->is_real && $parcel->packages) {
                    foreach ($parcel->packages as $package) {
                        if ($package->status < 1) {
                            $count++;
                            //$package->warehouse_cell = null;
                            $package->status = 1;
                            $package->save();

                            /* Send Notification */
                            Notification::sendPackage($package->id, '1');
                        }
                    }

                    $parcel->custom_id = $parcel->name . "-" . date("d,m,Y");
                    $parcel->sent = true;
                    $parcel->save();
                }
            }

            if ($count) {
                \Alert::success($count . ' packages was sent!');
            } else {
                \Alert::error('Cannot find ready parcels!');
            }
        } else {
            \Alert::error('You cannot send not ready parcels!');
        }

        return redirect()->route('w-parcels.index', 'sent');
    }
}
