<?php

namespace App\Http\Middleware;

use App\Models\Package;
use Auth;
use Closure;
use Illuminate\Support\Facades\Artisan;
use View;

class Panel
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $autoPrint = false;
        $showLabel = false;
        $showInvoice = false;
        $fakeInvoice = false;
        $_packages = false;
        $cellUpdate = false;
        $filials = [];
        $_createPackage = 'packages.create';
        if (Auth::guard('admin')->check()) {
            $panel = Auth::guard('admin')->user()->role->display_name;
            $view = 'admin';
            $avatar = Auth::guard('admin')->user()->avatar;
            $name = Auth::guard('admin')->user()->name;
            $url = route('admins.edit', Auth::guard('admin')->user()->id);
            $logged = Auth::guard('admin')->user();
            $cellUpdate = app('laratrust')->can('update-cells');

            /* Filter filials */
            $filials = auth()->guard('admin')->user()->filials->pluck('id')->all();

            $requested = Package::setEagerLoads([])->where('status', 2)->whereNotNull('requested_at');

            if ($filials) {

                $requested->whereHas('user', function (
                    $query
                ) use ($filials) {
                    $query->whereIn('filial_id', $filials)->orWhere('filial_id', null);
                });
            }

            /*$data = \Cache::remember('mixed_data', 30 * 24 * 60 * 60, function () use ($filials) {

                $ready = Package::setEagerLoads([])->where('status', '!=', 3);
                $items = Package::setEagerLoads([])->where('status', '!=', 3);

                if ($filials) {

                    $items->whereHas('user', function (
                        $query
                    ) use ($filials) {
                        $query->whereIn('filial_id', $filials)->orWhere('filial_id', null);
                    });

                    $ready->whereHas('user', function (
                        $query
                    ) use ($filials) {
                        $query->whereIn('filial_id', $filials)->orWhere('filial_id', null);
                    });
                }
                $ready = $ready->ready();

                return [
                    'ready' => $ready->count(),
                    //'requested' => $requested->count(),
                    'items' => $items->count(),
                ];
            });*/

            //$requested = $data['requested'];
            $ready = 0;//$data['ready'];
            $items = 0;//$data['items'];

            $done = \Cache::remember('all_done', 24 * 60 * 60, function () {
                return Package::setEagerLoads([])->where('status', 3)->count();
            });
            $unknown = \Cache::remember('unknown', 24 * 60 * 60, function () {
                return Package::setEagerLoads([])->whereNull('user_id')->whereIn('status', [0, 6])->count();
            });

            $_packages = [
                'done'      => $done,
                'requested' => $requested->count(),
                'active'    => $items . "/" . $ready,
                'unknown'   => $unknown,
            ];
        } elseif (Auth::guard('worker')->check()) {
            $panel = 'Warehouse';
            $view = 'warehouse';
            $wUser = Auth::guard('worker')->user()->warehouse;
            $avatar = $wUser->country->flag;
            $name = Auth::guard('worker')->user()->name ?: $wUser->company_name;
            $url = route('my.edit', $wUser->id);
            $_createPackage = $wUser->parcelling ? 'w-parcels.create' : 'w-packages.create';
            $logged = $wUser;

            $autoPrint = boolval($wUser->auto_print);
            $showInvoice = boolval($wUser->show_invoice);
            $fakeInvoice = ($wUser->label > 1);
            $showLabel = boolval($wUser->show_label);
        } else {
            $avatar = '';
            $view = false;
            $name = 'UnKnow';
            $logged = null;
            $url = null;
            $panel = null;
        }

        View::share([
            '_viewDir'       => $view,
            '_panelName'     => $panel,
            '_name'          => $name,
            '_avatar'        => $avatar,
            '_profileUrl'    => $url,
            '_logged'        => $logged,
            '_autoPrint'     => $autoPrint,
            '_showInvoice'   => $showInvoice,
            '_fakeInvoice'   => $fakeInvoice,
            '_showLabel'     => $showLabel,
            '_packages'      => $_packages,
            '_createPackage' => $_createPackage,
            '_cellUpdate'    => $cellUpdate,
            '_filials'       => $filials,
        ]);

        return $next($request);
    }
}
