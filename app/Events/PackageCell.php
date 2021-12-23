<?php

namespace App\Events;

use App\Models\Package;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PackageCell
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public function __construct($type = 'find', $id = 0)
    {
        $package = Package::find($id);
        $filial = $package && $package->user ? $package->user->filial_id : null;

        $pusher = new \Pusher\Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), ['cluster' => 'eu']);

        $trigger = ['package' => route('cells.index') . "?requested=1", 'filial_id' => $filial];
        if ($type == 'done') {
            $trigger = ['success' => "The package is done. Good job!", 'filial_id' => $filial];
        }

        $pusher->trigger('my-channel', 'my-event', $trigger);
    }
}