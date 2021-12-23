<?php

namespace App\Exports\Warehouse;

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
        $warehouse = auth()->guard('worker')->user()->warehouse;

        if (is_array($this->items) and ! empty($this->items)) {
            $packages = Package::whereIn('id', $this->items)->where('warehouse_id', $warehouse->id)->get();
        } else {
            $packages = $this->items;
        }

        return view('warehouse.exports.packages', [
            'packages' => $packages,
            'warehouse' => $warehouse
        ]);
    }
}