<?php

namespace App\Exports\Warehouse;

use App\Models\Package;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;

class ManifestExport implements FromView, ShouldAutoSize
{
    protected $items;
    protected $warehouse;
    protected $parcel;
    protected $ext;


    public function __construct($items, $warehouse = null, $ext = 'Xlsx', $parcel = null)
    {
        $this->items = $items;
        $this->ext = $ext;
        $this->parcel = $parcel;
        $this->warehouse = $warehouse ?: auth()->guard('worker')->user()->warehouse;
    }

    public function view(): View
    {
        $warehouse = $this->warehouse;

        if (is_array($this->items) and ! empty($this->items)) {
            $packages = Package::whereIn('id', $this->items)->where('warehouse_id', $warehouse->id)->get();
        } else {
            $packages = $this->items;
        }

        if (view()->exists('warehouse.exports.manifest.' . strtolower($warehouse->country->code))) {
            $view = 'warehouse.exports.manifest.' . strtolower($warehouse->country->code);
        } else {
            $view = 'warehouse.exports.manifest.default';
        }

        return view($view, [
            'parcel' => $this->parcel,
            'packages' => $packages,
            'warehouse' => $warehouse,
            'ext' => $this->ext,
            'span' => $this->ext == 'Xlsx' ? 11 : 10,
        ]);
    }

}