<?php

namespace App\Exports\Admin;

use App\Models\Package;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;

class OrdersExport implements FromView, ShouldAutoSize
{
    protected $items;

    public function __construct($items)
    {
        ini_set('memory_limit', '5120M');

        $this->items = $items;
    }

    public function view(): View
    {
        $orders = $this->items;

        $cards = [
            'Total'   => [
                'count'      => 0,
                'fee'        => 0,
                'admin_paid' => 0,
                'total'      => 0,
            ],
            'Unknown' => [
                'count'      => 0,
                'fee'        => 0,
                'admin_paid' => 0,
                'total'      => 0,
            ],
        ];

        foreach ($orders as $order) {
            $card = $order->card ? $order->card->hidden_number : 'Unknown';
            if (isset($cards[$card])) {
                $cards[$card]['total'] += $order->total_price;
                $cards[$card]['fee'] += $order->service_fee;
                $cards[$card]['admin_paid'] += $order->admin_paid;
                $cards[$card]['count']++;
            } else {
                $cards[$card]['total'] = $order->total_price;
                $cards[$card]['fee'] = $order->service_fee;
                $cards[$card]['admin_paid'] = $order->admin_paid;
                $cards[$card]['count'] = 1;
            }

            $cards['Total']['total'] += $order->total_price;
            $cards['Total']['fee'] += $order->service_fee;
            $cards['Total']['admin_paid'] += $order->admin_paid;
            $cards['Total']['count']++;
        }

        return view('admin.exports.orders', [
            'orders' => $orders,
            'cards'  => $cards,
        ]);
    }
}