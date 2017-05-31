<?php

namespace App\Http\Controllers;

use App\Traits\ConfigTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    use ConfigTrait;

    public function getPusherKey()
    {
        return $this->getPusherKeyTrait();
    }

    /*
     * $id do usuário
     */
    public function markAllAsRead()
    {
        $user = \Auth::getUser();

        $user->unreadNotifications()->update(['read_at' => Carbon::now()]);

        return json_encode(["status" => true]);
    }
}
