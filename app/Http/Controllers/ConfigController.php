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
     * Marca todas as notificações como lidas
     */
    public function markAllAsRead()
    {
        $user = \Auth::user();

        $user->unreadNotifications()->update(['read_at' => Carbon::now()]);

        return json_encode(["status" => true]);
    }

    //Recupera o endereço completo da igreja
    public function getChurchZipCode()
    {
        $address = \DB::table('churches')
            ->where('id', \Auth::user()->church_id)
            ->first();

        return json_encode($address);
    }
}
