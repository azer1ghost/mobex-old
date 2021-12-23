<?php

namespace App\Http\Controllers\Admin;

use Alert;
use App\Exports\Admin\TransactionsExport;
use App\Http\Requests;
use App\Models\Package;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    protected $can = [
        'export' => true,
        'delete' => false,
        'update' => false,
    ];

    protected $notificationKey = 'id';

    protected $listDir = 'admin.transactions.list';

    protected $view = [
        'sub_title'   => 'system transactions',
        'formColumns' => 12,
        'search'      => [
            [
                'name'              => 'q',
                'type'              => 'text',
                'attributes'        => ['placeholder' => 'Search...'],
                'wrapperAttributes' => [
                    'class' => 'col-lg-2',
                ],
            ],
            [
                'type'              => 'select2',
                'name'              => 'admin_id',
                'attribute'         => 'name',
                'model'             => 'App\Models\Admin',
                'wrapperAttributes' => [
                    'class' => 'col-lg-2',
                ],
                'allowNull'         => 'All Admins',
            ],
            [
                'type'              => 'select2',
                'name'              => 'filial_id',
                'attribute'         => 'name',
                'model'             => 'App\Models\Filial',
                'wrapperAttributes' => [
                    'class' => 'col-lg-2',
                ],
                'allowNull'         => 'All Filials',
            ],
            [
                'name'              => 'paid_for',
                'type'              => 'select_from_array',
                'optionsFromConfig' => 'ase.attributes.transaction.paid_for',
                'wrapperAttributes' => [
                    'class' => 'col-lg-1',
                ],
                'allowNull'         => 'For',
            ],
            [
                'name'              => 'paid_by',
                'type'              => 'select_from_array',
                'optionsFromConfig' => 'ase.attributes.transaction.paid_by',
                'wrapperAttributes' => [
                    'class' => 'col-lg-2',
                ],
                'allowNull'         => 'By',
            ],
            [
                'name'              => 'type',
                'type'              => 'select_from_array',
                'optionsFromConfig' => 'ase.attributes.transaction.types',
                'wrapperAttributes' => [
                    'class' => 'col-lg-1',
                ],
                'allowNull'         => 'Type',
            ],
            [
                'type'              => 'select2',
                'name'              => 'warehouse_id',
                'attribute'         => 'country.name',
                'model'             => 'App\Models\Warehouse',
                'wrapperAttributes' => [
                    'class' => 'col-lg-2',
                ],
                'allowNull'         => 'All warehouses',
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
                    'class' => 'col-lg-4',
                ],
            ],
            [
                'type'              => 'select2',
                'name'              => 'promo_id',
                'attribute'         => 'title',
                'model'             => 'App\Models\Promo',
                'wrapperAttributes' => [
                    'class' => 'col-lg-2',
                ],
                'allowNull'         => 'All Promos',
            ],
        ],
    ];

    protected $list = [
        'admin.name'          => [
            'label' => 'Admin',
        ],
        'user'                => [
            'type'  => 'custom.user',
            'label' => 'User',
        ],
        'filial.name'         => [
            'label' => 'Filial',
        ],
        'symbol_admin_amount' => [
            'label' => 'Amount',
        ],
        'rate',
        'org_amount'          => [
            'label' => 'OrgAmount',
        ],
        /*  'country' => [
              'label' => 'Country',
              'type'  => 'country',
          ],
          'custom_number'         => [
              'label' => 'CWB',
              'type'  => 'text',
          ],*/
        'paid_for'            => ['label' => 'For'],
        'paid_by'             => ['label' => 'By'],
        'type',
        'note',
        'done_at'             => [
            'label' => 'At',
        ],
        //'type',
    ];

    protected $fields = [
        [
            'name'    => 'who',
            'default' => 'ADMIN',
            'type'    => 'hidden',
        ],
        [
            'name'              => 'note',
            'label'             => 'Title',
            'type'              => 'text',
            'validation'        => 'nullable|string',
            'wrapperAttributes' => [
                'class' => 'col-md-3',
            ],
        ],
        [
            'label'             => 'User',
            'type'              => 'select2',
            'name'              => 'user_id',
            'attribute'         => 'full_name,customer_id',
            'model'             => 'App\Models\User',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
            'validation'        => 'nullable|integer',
            'allowNull'         => true,
        ],
        [
            'name'              => 'amount',
            'label'             => 'Amount',
            'type'              => 'text',
            'validation'        => 'required|numeric',
            'wrapperAttributes' => [
                'class' => 'col-md-1',
            ],
        ],
        [
            'name'              => 'currency',
            'label'             => '&nbsp',
            'type'              => 'select_from_array',
            'optionsFromConfig' => 'ase.attributes.currenciesWithKey',
            'wrapperAttributes' => [
                'class' => 'col-md-1',
            ],
            'validation'        => 'required',
        ],
        [
            'name'              => 'type',
            'label'             => 'Type',
            'type'              => 'select_from_array',
            'optionsFromConfig' => 'ase.attributes.transaction.types',
            'wrapperAttributes' => [
                'class' => 'col-md-1',
            ],
            'validation'        => 'required',
        ],

        [
            'name'              => 'paid_for',
            'label'             => 'For',
            'type'              => 'select_from_array',
            'optionsFromConfig' => 'ase.attributes.transaction.paid_for',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
            'validation'        => 'nullable',
        ],

        [
            'name'              => 'paid_by',
            'label'             => 'By',
            'type'              => 'select_from_array',
            'optionsFromConfig' => 'ase.attributes.transaction.paid_by',
            'wrapperAttributes' => [
                'class' => 'col-md-2',
            ],
            'validation'        => 'required',
        ],

        /*[
            'name'       => 'done_at',
            'type'       => 'datetime',
            'wrapperAttributes'  => [
                'class' => 'col-lg-2',
            ],
        ],*/
    ];

    public function indexObject()
    {
        ini_set('memory_limit', '-1');
        $validator = \Validator::make(request()->all(), [
            'q'             => 'string',
            'status'        => 'integer',
            'warehouse_id ' => 'integer',
            'start_date'    => 'date',
            'start_end'     => 'date',
        ]);

        if ($validator->failed()) {
            \Alert::error('Unexpected variables!');

            return redirect()->route("my.dashboard");
        }

        $items = Transaction::where('type', '!=', 'ERROR')->latest()->orderBy('id', 'desc');

        $prefix = "%";
        $condition = "LIKE";

        /* Filter filials */
        $filials = auth()->guard('admin')->user()->filials->pluck('id')->all();
        if ($filials) {
            $items->whereIn('filial_id', $filials);
        }

        if (request()->get('id') != null) {
            $items->where('id', request()->get('id'));
        } else {
            if (request()->get('q') != null) {
                $q = $prefix . request()->get('q') . $prefix;
                $items->where(function ($query) use ($q, $condition) {
                    $query->orWhere("note", $condition, $q)->orWhereHas('user', function (
                        $query
                    ) use ($q) {
                        $query->where('customer_id', 'LIKE', '%' . $q . '%')->orWhere('passport', 'LIKE', '%' . $q . '%')->orWhere('fin', 'LIKE', '%' . $q . '%')->orWhere('phone', 'LIKE', '%' . $q . '%')->orWhere('email', 'LIKE', '%' . $q . '%')->orWhere(DB::raw('concat(trim(name)," ",trim(surname))'), 'LIKE', "%" . $q . "%")->orWhereHas('dealer', function (
                            $query
                        ) use ($q) {
                            $query->where('customer_id', 'LIKE', '%' . $q . '%')->orWhere('passport', 'LIKE', '%' . $q . '%')->orWhere('fin', 'LIKE', '%' . $q . '%')->orWhere('phone', 'LIKE', '%' . $q . '%')->orWhere('email', 'LIKE', '%' . $q . '%')->orWhere(DB::raw('concat(trim(name)," ",trim(surname))'), 'LIKE', "%" . $q . "%");
                        });
                    });
                });
            } else {
                $items->where('done_at', '>=', Carbon::now()->subDays(30));
            }

            if (\Request::get('promo_id') != null) {
                $items->whereHas('user', function (
                    $query
                ) {
                    $query->where('promo_id', \Request::get('promo_id'));
                });
            }

            if (request()->get('paid_by') != null) {
                $items->where('paid_by', request()->get('paid_by'));
            }

            if (request()->get('filial_id') != null) {
                $items->where('filial_id', request()->get('filial_id'));
            }
            if (request()->get('admin_id') != null) {
                $items->where('admin_id', request()->get('admin_id'));
            }
            if (request()->get('paid_for') != null) {
                $items->where('paid_for', request()->get('paid_for'));
            }
            if (request()->get('type') != null) {
                $items->where('type', request()->get('type'));
            }

            if (\Request::get('warehouse_id') != null) {
                $items->whereHas('package', function (
                    $query
                ) {
                    $query->where('warehouse_id', \Request::get('warehouse_id'));
                });
            }

            if (request()->get('start_date') != null) {
                $items->where('done_at', '>=', request()->get('start_date'))->where('done_at', '<=', Carbon::createFromFormat("Y-m-d", request()->get('end_date'))->addDay()->format("Y-m-d"));
            }
        }

        if (\request()->get('search_type') == 'export') {
            if ($items->count()) {
                $items = $items->get();
            } else {
                $items = $items->paginate($this->limit);
            }
        } else {
            $income = [
                'count'  => 0,
                'amount' => 0,
            ];
            $outcome = [
                'count'  => 0,
                'amount' => 0,
            ];
            $total = [
                'count'  => 0,
                'amount' => 0,
            ];

            $types = [];

            foreach ($items->get() as $transaction) {
                $transaction->admin_amount;
                if ($transaction->admin_amount > 0) {
                    $income['amount'] += $transaction->admin_amount;
                    $income['count']++;
                } elseif ($transaction->admin_amount < 0) {
                    $outcome['amount'] += $transaction->admin_amount;
                    $outcome['count']++;
                }

                if (in_array($transaction->paid_by, [
                    'CASH',
                    'PAY_TR',
                    'PAYMES',
                    'PORTMANAT',
                    'POST_TERMINAL',
                    'CARD_TO_CARD',
                ])) {
                    if (isset($types[$transaction->paid_by])) {
                        $types[$transaction->paid_by] += $transaction->admin_amount;
                    } else {
                        $types[$transaction->paid_by] = $transaction->admin_amount;
                    }
                }

                $total['amount'] += $transaction->admin_amount;
                $total['count']++;
            }

            \View::share([
                'total'   => $total,
                'income'  => $income,
                'outcome' => $outcome,
                'types'   => $types,
            ]);
            $items = $items->paginate($this->limit);
        }

        return $items;
    }

    public function export($items = null)
    {
        if (request()->has('hidden_items')) {
            $items = explode(",", request()->get('hidden_items'));
        }

        return \Excel::download(new TransactionsExport($items), 'transactions_' . uniqid() . '.xlsx', 'Xlsx');
        //return \Excel::download(new TransactionsExport($items), 'transactions_' . uniqid() . '.xlsx');
    }
}
