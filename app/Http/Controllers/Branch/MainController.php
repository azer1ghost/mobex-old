<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Admin\Controller;
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

    public function index()
    {
        $packages = Package::where('branch_id', $this->me())->paginate($this->limit);

        return view('branch.index', [
            'packages' => $packages
        ]);
    }
}
