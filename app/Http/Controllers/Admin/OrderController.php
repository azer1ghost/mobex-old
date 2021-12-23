<?php

namespace App\Http\Controllers\Admin;

use Alert;
use App\Exports\Admin\OrdersExport;
use App\Http\Requests;
use App\Models\Activity;
use App\Models\Admin;
use App\Models\Extra\Notification;
use App\Models\Link;
use App\Models\Order;
use App\Models\Package;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected $can = [
        'export' => true,
        'create' => false,
    ];

    protected $extraActions = [
        [
            'route'  => 'orders.links',
            'key'    => 'id',
            'label'  => 'Links',
            'icon'   => 'link',
            'color'  => 'success',
            'target' => '_blank',
        ],
        [
            'route'  => 'orders.logs',
            'key'    => 'id',
            'label'  => 'Logs',
            'icon'   => 'list',
            'color'  => 'default',
            'target' => '_blank',
        ],
    ];

    protected $notificationKey = 'custom_id';

    protected $withCount = 'links';

    protected $view = [
        'name'        => 'Request',
        'formColumns' => 10,
        'sub_title'   => 'User requests',
        'search'      => [
            [
                'name'              => 'inside',
                'type'              => 'text',
                'attributes'        => ['placeholder' => 'Search...'],
                'wrapperAttributes' => [
                    'class' => 'col-lg-3',
                ],
            ],
            [
                'name'              => 'q',
                'type'              => 'text',
                'attributes'        => ['placeholder' => 'User'],
                'wrapperAttributes' => [
                    'class' => 'col-lg-2',
                ],
            ],
            [
                'name'              => 'admin',
                'type'              => 'text',
                'attributes'        => ['placeholder' => 'Buyer'],
                'wrapperAttributes' => [
                    'class' => 'col-lg-2',
                ],
            ],
            [
                'type'              => 'select2',
                'name'              => 'country_id',
                'attribute'         => 'name',
                'model'             => 'App\Models\Country',
                'wrapperAttributes' => [
                    'class' => 'col-lg-3',
                ],
                'allowNull'         => 'All Countries',
            ],
            [
                'name'              => 'status',
                'type'              => 'select_from_array',
                'optionsFromConfig' => 'ase.attributes.request.status',
                'wrapperAttributes' => [
                    'class' => 'col-lg-1',
                ],
                'allowNull'         => 'All',
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

    protected $list = [
        'custom_id'          => [
            'label' => 'No',
        ],
        'country'            => [
            'type'  => 'country',
            'label' => 'Country',
        ],
        'declaration_count'  => [
            'type'  => 'boolean',
            'label' => 'Declared',
        ],
        'user'               => [
            'type'  => 'custom.user',
            'label' => 'User',
        ],
        'card.last_digit'    => [
            'label' => 'Card',
        ],
        'links_count'        => [
            'label' => 'Links',
        ],
        'price',
        'service_fee',
        'total_price',
        'user.order_balance' => [
            'label' => 'Balance',
            'type'  => 'order_balance',
        ],
        'admin_paid',
        'response',
        'status'             => [
            'label'    => 'Status',
            'type'     => 'select-editable',
            'editable' => [
                'route'            => 'orders.ajax',
                'type'             => 'select',
                'sourceFromConfig' => 'ase.attributes.request.statusWithLabel',
            ],
        ],
        'admin_id'           => [
            'label'    => 'Admin',
            'type'     => 'select-editable',
            'editable' => [
                'route'  => 'orders.ajax',
                'type'   => 'select',
                'source' => [],
            ],
        ],
        'paid_at',
        'updated_at',
    ];

    protected $fields = [
        [
            'label'             => 'User',
            'type'              => 'select2',
            'name'              => 'user_id',
            'attribute'         => 'full_name,customer_id',
            'model'             => 'App\Models\User',
            'hint'              => 'Not suggest to change user',
            'wrapperAttributes' => [
                'class' => 'col-md-5',
            ],
            'validation'        => 'nullable|integer',
        ],
        [
            'label'             => 'Country',
            'type'              => 'select2',
            'name'              => 'country_id',
            'attribute'         => 'name',
            'model'             => 'App\Models\Country',
            'wrapperAttributes' => [
                'class' => ' col-md-4',
            ],
            'allowNull'         => true,
            'validation'        => 'nullable|integer',
        ],

        [
            'name'              => 'status',
            'label'             => 'Status',
            'type'              => 'select_from_array',
            'optionsFromConfig' => 'ase.attributes.request.status',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
            'validation'        => 'nullable|integer',
        ],
        [
            'type' => 'html',
            'html' => '<div class="form-group col-lg-12 mt-10"><h3 class="text-center">User notes</h3></div>',
        ],

        [
            'name'              => 'note',
            'type'              => 'textarea',
            'label'             => 'User note',
            'attributes'        => [
                'disabled' => 'disabled',
            ],
            'wrapperAttributes' => [
                'class' => 'col-md-7',
            ],
            'validation'        => 'nullable|string',
        ],
        [
            'name'              => 'extra_contacts',
            'type'              => 'textarea',
            'label'             => 'Extra contacts',
            'attributes'        => [
                'disabled' => 'disabled',
            ],
            'wrapperAttributes' => [
                'class' => 'col-md-5',
            ],
            'validation'        => 'nullable|string',
        ],

        [
            'type' => 'html',
            'html' => '<div class="form-group col-lg-12 mt-10"></div>',
        ],
        [
            'name'              => 'price',
            'type'              => 'text',
            'label'             => 'Price',
            'prefix'            => '<i class="icon-coin-dollar"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
            'validation'        => 'nullable|string',
        ],
        [
            'name'              => 'coupon_sale',
            'type'              => 'text',
            'label'             => 'Coupon sale',
            'prefix'            => '<i class="icon-coin-dollar"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
            'validation'        => 'nullable|string',
        ],
        [
            'name'              => 'service_fee',
            'type'              => 'text',
            'label'             => 'Service Price',
            'prefix'            => '<i class="icon-coin-dollar"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
            'validation'        => 'nullable|string',
        ],
        [
            'name'              => 'total_price',
            'type'              => 'text',
            'label'             => 'Total Price',
            'prefix'            => '<i class="icon-coin-dollar"></i>',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
            'validation'        => 'nullable|string',
        ],
        [
            'type' => 'html',
            'html' => '<div class="form-group col-lg-12 mt-10"></div>',
        ],
        [
            'name'       => 'admin_note',
            'type'       => 'summernote',
            'label'      => 'Admin note',
            'validation' => 'nullable|string',
        ],

    ];

    public function links($id)
    {
        $order = Order::withCount('links')->where('id', $id)->first();
        if (! $order) {
            abort(404);
        }

        $key = 'status';
        $head = [
            'editable' => [
                'route'            => 'orders.linkajax',
                'type'             => 'select',
                'sourceFromConfig' => 'ase.attributes.request.link.statusWithLabel',
            ],
        ];
        $links = Link::whereOrderId($id)->get();

        $listFields = [
            [
                'name'              => 'status',
                'label'             => 'Status',
                'type'              => 'select_from_array',
                'optionsFromConfig' => 'ase.attributes.request.status',
                'validation'        => 'required|integer',
                'wrapperAttributes' => [
                    'class' => 'col-md-4',
                ],
            ],
            [
                'name'              => 'admin_paid',
                'type'              => 'text',
                'label'             => 'You paid',
                'prefix'            => '<i class="icon-coin-dollar"></i>',
                'validation'        => 'nullable|numeric',
                'wrapperAttributes' => [
                    'class' => 'col-md-4',
                ],
            ],
            [
                'label'             => 'Card',
                'type'              => 'select2',
                'name'              => 'card_id',
                'attribute'         => 'hidden_number',
                'model'             => 'App\Models\Card',
                'validation'        => 'nullable|integer',
                'allowNull'         => true,
                'wrapperAttributes' => [
                    'class' => 'col-md-4',
                ],
            ],
            [
                'type' => 'html',
                'html' => '<div class="form-group col-lg-12 mt-10"><br/></div>',
            ],
            [
                'name'              => 'admin_note',
                'type'              => 'text',
                'label'             => 'Admin note',
                'prefix'            => '<i class="icon-alert"></i>',
                'validation'        => 'nullable|string',
                'wrapperAttributes' => [
                    'class' => 'col-md-8',
                ],
            ],

        ];

        $item = $order;

        return view('admin.orders.links', compact('order', 'links', 'key', 'head', 'item', 'listFields'));
    }

    public function linkajax(Request $request, $id)
    {
        $item = Link::find($id);

        if (trim($item->status) != trim($request->get('value'))) {

            $check = Transaction::where('user_id', $item->order->user_id)->where('custom_id', $item->id)->where('paid_for', 'ORDER_BALANCE')->where('type', 'REFUND')->first();

            if ($check) {
                $check->delete();
            }

            if ($request->get('value') != 0) {
                /* Send Notification */
                Notification::sendLink($item->id, trim($request->get('value')));
                $refundPrice = round($item->total_price * 1.05, 2);
                Transaction::create([
                    'user_id'   => $item->order->user_id,
                    'custom_id' => $item->id,
                    'paid_by'   => 'OTHER',
                    'paid_for'  => 'ORDER_BALANCE',
                    'currency'  => 'TRY',
                    'who'       => 'ADMIN',
                    'rate'      => getCurrencyRate(1) / getCurrencyRate(3),
                    'amount'    => $refundPrice,
                    'type'      => 'REFUND',
                    'note'      => "#" . $item->id . " idli linkə görə 5% daxil pul geri qaytarıldı.",
                ]);

                sendTGMessage("💰💰💰 <b>" . $refundPrice . "TL</b> " . $item->order->user->full_name . "-in sifariş balansına qaytarıldı! #refund");
            }
        }

        $item->{$request->get('name')} = $request->get('value');
        $item->save();

        return 'Ok';
    }

    public function indexObject()
    {
        $validator = \Validator::make(\Request::all(), [
            'q'           => 'string',
            'status'      => 'integer',
            'country_id ' => 'integer',
            'start_date'  => 'date',
            'start_end'   => 'date',
        ]);

        if ($validator->failed()) {
            \Alert::error('Unexpected variables!');

            return redirect()->route("my.dashboard");
        }

        $items = Order::withCount(['links', 'declaration'])->with([
            'admin',
            'user',
            'card',
        ])->orderBy('paid', 'desc')->orderBy('status', 'asc')->orderBy('created_at', 'desc');

        $sepIt = auth()->guard('admin')->user()->separate_order;

        if (! auth()->guard('admin')->user()->can('manage-orders')) {
            $items->where('admin_id', auth()->guard('admin')->user()->id);
            unset($this->list['admin_id']);
            unset($this->list['response']);
        } else {
            \View::share('_colorCondition', [
                'key'   => 'admin_id',
                'value' => auth()->guard('admin')->user()->id,
            ]);
            $admins = Admin::withTrashed()->get();
            $data = [];
            foreach ($admins as $admin) {
                if ($admin->can('update-orders')) {
                    $status = $admin->deleted_at ? " (Deleted)" : ($admin->separate_order ? " (Active)" : null);
                    $data[] = [
                        'value' => $admin->id,
                        'text'  => $admin->name . $status,
                    ];
                }
            }

            $this->list['admin_id']['editable']['source'] = \GuzzleHttp\json_encode($data);
        }
        \View::share('_list', $this->list);
        if (\Request::get('q') != null) {
            $q = \Request::get('q');
            $items->whereHas('user', function (
                $query
            ) use ($q) {
                $query->where('customer_id', 'LIKE', '%' . $q . '%')->orWhere('passport', 'LIKE', '%' . $q . '%')->orWhere('fin', 'LIKE', '%' . $q . '%')->orWhere('phone', 'LIKE', '%' . $q . '%')->orWhere('email', 'LIKE', '%' . $q . '%')->orWhere('email', 'LIKE', '%' . $q . '%')->orWhere(DB::raw('concat(trim(name)," ",trim(surname))'), 'LIKE', "%" . $q . "%");
            });
        }
        if (\Request::get('admin') != null) {
            $q = \Request::get('admin');
            $items->whereHas('admin', function (
                $query
            ) use ($q) {
                $query->where('name', 'LIKE', $q . '%')->orWhere('email', 'LIKE', $q . '%');
            });
        }
        if (\Request::get('inside') != null) {
            $q = \Request::get('inside');
            $items->whereHas('links', function (
                $query
            ) use ($q) {
                $query->where('url', 'LIKE', '%' . $q . '%')->orWhere('note', 'LIKE', '%' . $q . '%');
            });
        }

        if (\Request::get('status') != null) {
            if (\Request::get('status') == 6) {
                $items->withTrashed()->whereNotNull('deleted_at');
            } else {
                $items->where('status', \Request::get('status'));
            }
        }

        if (\Request::get('country_id') != null) {
            $items->where('country_id', \Request::get('country_id'));
        }

        if (\Request::get('start_date') != null) {
            $items->where('created_at', '>=', \Request::get('start_date'));
        }
        if (\Request::get('end_date') != null) {
            $items->where('created_at', '<=', Carbon::createFromFormat("Y-m-d", \Request::get('end_date'))->addDay());
        }

        if (\request()->get('search_type') == 'export' || \request()->has('export')) {
            if ($items->count()) {
                $items = $items->get();
            } else {
                $items = $items->paginate($this->limit);
            }
        } else {
            $items = $items->paginate($this->limit);
        }

        return $items;
    }

    public function update(Request $request, $id)
    {
        $used = Order::find($id);

        if (trim($used->status) != trim($request->get('status'))) {

            /* Send Notification */
            Notification::sendOrder($id, trim($request->get('status')));
        }

        return parent::update($request, $id);
    }

    public function custom(Request $request, $id)
    {
        $item = Order::find($id);

        if (trim($item->status) != trim($request->get('status'))) {

            Notification::sendOrder($id, trim($request->get('status')));
        }

        $transactIt = false;
        if (! $item->admin_paid && $request->get('admin_paid') != null) {
            $transactIt = true;
        }
        $amount = $request->get('admin_paid') != null ? $request->get('admin_paid') : null;
        if ($amount) {
            $amount = floatval(str_replace(",", ".", $amount));
        }
        $item->status = $request->get('status');
        $item->admin_note = $request->get('admin_note');
        $item->admin_paid = $amount;
        $item->delivery_date = $request->get('delivery_date');
        $item->card_id = $request->get('card_id');
        $item->save();

        if ($transactIt) {
            $item = Order::find($id);
            Transaction::create([
                'user_id'   => null,
                'custom_id' => $item->id,
                'who'       => 'ADMIN',
                'paid_for'  => 'ORDER',
                'paid_by'   => 'CREDIT_CARD',
                'currency'  => 'TRY',
                'rate'      => getCurrencyRate(1) / getCurrencyRate(3),
                'amount'    => $amount,
                'type'      => 'OUT',
                'note'      => $item->id . ' id-li ordere görə ' . ($item->admin ? $item->admin->name : "Silinmish admin") . ' ' . ($item->card ? $item->card->last_digit : '-') . ' kartıyla ödəmə etdi',
            ]);

            $message = '‼️<b>' . $item->id . '</b>  id-li ordere görə ' . ($item->admin ? $item->admin->name : "Silinmish admin") . ' ' . ($item->card ? $item->card->last_digit : '-') . ' kartıyla ' . round($request->get('admin_paid'), 2) . 'TL ödəmə etdi';
            sendTGMessage($message);
        }

        Alert::success(trans('saysay::crud.action_alert', [
            'name'   => $this->modelName,
            'key'    => clearKey($this->notificationKey),
            'value'  => $item->{$this->notificationKey},
            'action' => 'updated',
        ]));

        return redirect()->route('orders.links', $item->id);
    }

    public function ajax(Request $request, $id)
    {
        if ($request->get('name') == 'status') {
            $used = Order::find($id);

            if (trim($used->status) != trim($request->get('value'))) {
                /* Send Notification */
                Notification::sendOrder($id, trim($request->get('value')));
            }
        }

        return parent::ajax($request, $id);
    }

    public function edit($id)
    {
        $order = Order::find($id);
        if ($order && $order->admin_id && $order->admin_id != auth()->guard('admin')->user()->id) {
            \Alert::error(trans('saysay::crud.unauthorized_access'));

            return redirect()->back();
        }

        return parent::edit($id);
    }

    public function export($items = null)
    {
        if (request()->has('hidden_items')) {
            $items = explode(",", request()->get('hidden_items'));
        }

        return \Excel::download(new OrdersExport($items), 'orders_' . uniqid() . '.Xlsx', 'Xlsx');
    }

    public function logs($id)
    {
        $logs = Activity::where('content_id', $id)->where('content_type', Order::class)->orderBy('id', 'desc')->get();
        if (! $logs) {
            return back();
        }

        return view('admin.widgets.logs', compact('logs', 'id'));
    }
}
