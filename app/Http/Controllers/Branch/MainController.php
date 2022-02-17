<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use App\Models\Package;


class MainController extends Controller
{
    protected $modelName = 'Package';

    protected $view = [
        'formColumns' => 10,
    ];

    public function me()
    {
        return auth()->guard('manager')->user();
    }

    public function logout()
    {
        auth()->guard('manager')->logout();

        request()->session()->invalidate();

        return redirect('/');
    }

    public function packages()
    {

    }

    public function index()
    {
        $widgets = [
            'packages_count' => (object)[
                'title' => 'Bağlama sayı',
                'background-color' => 'red',
                'class' => 'form-control',
            ],
        ];

        $status = null;

        switch (request('status')) {
            case 'in_branch':
                $status = 9;
                break;
            case 'on_way':
                $status = 8;
                break;
            case 'sent':
                $status = 1;
                break;
            case 'done':
                $status = 3;
                break;
            default:
                $status = 1;
        }

        $packages = Package::where('branch_id', $this->me()->branch_id)
            ->when(request('branch_arrived_at'), function ($q){
                $q->whereDate('branch_arrived_at', request('branch_arrived_at'));
            })
            ->where('status', $status)
            ->paginate($this->limit);

        return view('branch.index', [
            'packages' => $packages,
            'filters'  => $this->filters(),
            'widgets' => $widgets
        ]);
    }

    public static function filters()
    {
        return  [
            'custom_id' => (object)[
                'type' => 'text',
                'placeholder' => 'İzləmə koduna görə axtar',
                'class' => 'form-control',
                'parentClass' => 'form-group col-12 col-lg-6 col-xxl-4 my-2'
            ],
            'branch_arrived_at' => (object)[
                'type' => 'date',
                'class' => 'form-control',
                'parentClass' => 'form-group col-12 col-lg-6 col-xxl-3 my-2',
                'help' => 'Çatma tarixi'
            ],
            'status' => (object)[
                'type' => 'select',
                'class' => 'form-select',
                'parentClass' => 'form-group col-12 col-lg-6 col-xxl-2 my-2',
                'options' => [
                    'in_branch' => 'Məntəqədə',
                    'on_way' => 'Yolda',
                    'sent' => 'Uçur',
                    'done' => 'Təhvil verilmişlər',
                    'all_with_done' => 'Hamısı',
                ],
            ],
            'limit' => (object)[
                'type' => 'select',
                'class' => 'form-select',
                'parentClass' => 'form-group col-12 col-lg-6 col-xxl-1 my-2',
                'options' => [10 => 10, 25 => 25, 100 => 100],
            ],
        ];
    }
}
