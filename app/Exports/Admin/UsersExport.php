<?php

namespace App\Exports\Admin;

use App\Models\Package;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;

class UsersExport implements FromView, ShouldAutoSize
{
    protected $items;


    public function __construct($items)
    {
        ini_set('memory_limit', '5120M');

        $this->items = $items;
    }

    public function view(): View
    {
        $users = $this->items;

        return view('admin.exports.users', [
            'users' => $users
        ]);
    }
}