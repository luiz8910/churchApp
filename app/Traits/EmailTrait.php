<?php
/**
 * Created by PhpStorm.
 * User: Luiz
 * Date: 21/04/2017
 * Time: 19:53
 */

namespace App\Traits;

use App\Mail\resetPassword;
use App\Mail\welcome;
use App\Mail\Contact_Site;
use App\Models\ContactSite;use App\Models\User;
use Illuminate\Support\Facades\Mail;

trait EmailTrait
{

    public function emailTestEditTrait($email, $id)
    {
        $user = User::select('id')->where('email', $email)->first();

        if(count($user) > 0)
        {
            if($user->id == $id)
            {
                //O email já existe, porém o email pertence a este usuário, então grava o mesmo email
                return true;
            }
            else{
                //O email já existe e não pertence a este usuário, logo não pode ser usado
                return false;
            }

        }else{
            //O email não existe no BD, portanto está liberado para uso
            return true;
        }
    }

    public function welcome($user, $password)
    {
        $url = env('APP_URL');

        Mail::to($user)
            ->send(new welcome(
                $user, $url, $password
            ));

        return true;
    }

    public function contact_site($name, $email, $tel, $msg)
    {
        Mail::to('luiz.sanches8910@gmail.com')
            ->send(new Contact_Site($name, $email, $tel, $msg));

        Mail::to('dagokeio@gmail.com')->send(new Contact_Site($name, $email, $tel, $msg));


        return true;
    }
}