<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Admin\Controller;
use Carbon\Carbon;
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

    public function branch()
    {
        return $this->me()->branch;
    }

    public function logout()
    {
        auth()->guard('manager')->logout();

        request()->session()->invalidate();

        return redirect('/');
    }

    public function index()
    {
        Carbon::setLocale('az');

        $widgets = [
            'packages_count' => (object)[
                'title' => 'Bağlama sayı',
                'icon' => 'fal fa-box',
                'count' => $this->branch()->packages()->count(),
                'class' => 'l-bg-cherry',
            ],
            'clients_count' => (object)[
                'title' => 'Müştəri sayı',
                'icon' => 'fal fa-user',
                'count' => $this->branch()->users()->count(),
                'class' => 'l-bg-blue-dark',
            ],
            'done_count' => (object)[
                'title' => 'Tamamlanmş bağlamalar',
                'icon' => 'fal fa-shopping-cart',
                'count' =>  $this->branch()->packages()->whereStatus(3)->count(),
                'class' => 'l-bg-green-dark',
            ],
            'bonus' => (object)[
                'title' => 'Toplanmış bonus',
                'icon' => 'fal fa-badge-dollar',
                'count' => '$100',
                'class' => 'l-bg-orange-dark',
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
                $status = 9;
        }

        $packages = Package::where('branch_id', $this->me()->branch_id)
            ->when(request()->filled('branch_arrived_at'), function ($q){
                $q->whereDate('branch_arrived_at', request('branch_arrived_at'));
            })
            ->when(request('status') != 'all_with_done', function ($q) use ($status){
                $q->where('status', $status);
            })
            ->paginate($this->limit);

        return view('branch.index', [
            'packages' => $packages,
            'filters'  => $this->filters(),
            'widgets'  => $widgets
        ]);
    }



    public static function filters()
    {
        return  [
            'custom_id' => (object)[
                'type' => 'text',
                'placeholder' => 'İzləmə koduna görə axtar',
                'class' => 'form-control',
                'parentClass' => 'form-group col-12 col-lg-6 col-xxl-4 my-2',
                'help' => 'İzəmə kodu'
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
                'help' => 'Statusu'
            ],
            'limit' => (object)[
                'type' => 'select',
                'class' => 'form-select',
                'parentClass' => 'form-group col-12 col-lg-6 col-xxl-1 my-2',
                'options' => [10 => 10, 25 => 25, 100 => 100],
                'help' => 'Göstərilir'
            ],
        ];
    }
}
