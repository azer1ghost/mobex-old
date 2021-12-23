<?php

namespace App\Exports\Admin;

use App\Models\Package;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;

class PackagesExport implements FromView, ShouldAutoSize
{
    protected $items;


    public function __construct($items)
    {
        $this->items = $items;
    }

    public function view(): View
    {
        $packages = $this->items;

        return view('admin.exports.packages', [
            'packages' => $packages
        ]);
    }
}