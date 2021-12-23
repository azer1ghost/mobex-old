<?php namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class Language
{
    public function __construct(Application $app, Redirector $redirector, Request $request)
    {
        $this->app = $app;
        $this->redirector = $redirector;
        $this->request = $request;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Make sure current locale exists.
        $locale = $request->segment(1);

        if (! in_array($locale, config('translatable.locales'))) {
            $locale = config('translatable.fallback_locale');
        }

        $this->app->setLocale($locale);
        $setting = Setting::find(1);
        \View::share(['_lang' => $locale, 'setting' => $setting]);

        return $next($request);
    }
}