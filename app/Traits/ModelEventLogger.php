<?php

namespace App\Traits;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ModelEventLogger
 *
 * @package App\Traits
 *
 *  Automatically Log Add, Update, Delete events of Model.
 */
trait ModelEventLogger
{
    /**
     * Automatically boot with Model, and register Events handler.
     */
    protected static function bootModelEventLogger()
    {
        foreach (static::getRecordActivityEvents() as $eventName) {
            static::$eventName(function (Model $model) use ($eventName) {
                try {
                    $reflect = new \ReflectionClass($model);
                    if (\Auth::guard('admin')->check()) {

                        if (static::getActionName($eventName) == 'delete') {
                            /* Send notification */
                            $message = null;
                            $message .= "🆘 <b>" . auth()->guard('admin')->user()->name . "</b> ";
                            $message .= "<b>" . $model->id . "</b> id nömrəli <b>" . $reflect->getShortName() . "</b> sildi.";

                            sendTGMessage($message);
                        }
                    }

                    if (isset($_SERVER['HTTP_CLIENT_IP']) && ! empty($_SERVER['HTTP_CLIENT_IP'])) {
                        $ip = $_SERVER['HTTP_CLIENT_IP'];
                    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && ! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                    } else {
                        $ip = (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : null;
                    }

                    /*if ($model->id == '6941') {
                        dd($_SERVER);
                    }*/

                    return Activity::create([
                        'admin_id'     => auth()->guard('admin')->check() ? auth()->guard('admin')->user()->id : null,
                        //'user_id'      => auth()->check() ? auth()->user()->id : null,
                        'worker_id'    => auth()->guard('worker')->check() ? auth()->guard('worker')->user()->id : null,
                        'content_id'   => $model->id,
                        'content_type' => get_class($model),
                        'action'       => static::getActionName($eventName),
                        'description'  => ucfirst($eventName) . " a " . $reflect->getShortName(),
                        'details'      => json_encode($model->getDirty()),
                        'ip'           => $ip,
                        'user_agent'   => (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : null,
                    ]);
                } catch (\Exception $e) {
                    \Bugsnag::notifyException($e);

                    return true;
                }
            });
        }
    }

    /**
     * Set the default events to be recorded if the $recordEvents
     * property does not exist on the model.
     *
     * @return array
     */
    protected static function getRecordActivityEvents()
    {
        if (isset(static::$recordEvents)) {
            return static::$recordEvents;
        }

        return [
            'created',
            'updated',
            'deleted',
        ];
    }

    /**
     * Return Suitable action name for Supplied Event
     *
     * @param $event
     * @return string
     */
    protected static function getActionName($event)
    {
        switch (strtolower($event)) {
            case 'created':
                return 'create';
                break;
            case 'updated':
                return 'update';
                break;
            case 'deleted':
                return 'delete';
                break;
            default:
                return 'unknown';
        }
    }
}