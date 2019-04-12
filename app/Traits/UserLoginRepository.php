<?php
/**
 * Created by PhpStorm.
 * User: Luiz
 * Date: 11/02/2017
 * Time: 17:30
 */

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\DB;


trait UserLoginRepository
{
    public function createUserLogin($id = null, $password, $email = null, $church = null, $token = null)
    {
        $qtde = User::where('email', $email)->first();

        if(!$qtde)
        {
            $user = User::create(
                [
                    'church_id' => $church,
                    'person_id' => $id,
                    'email' => $email,
                    'password' => bcrypt($password),
                    'social_token' => $token ? $token : null,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]
            );

            return $user;
        }


        return false;

    }

    public function createUserLoginTest($id = null, $password, $email = null, $church = null, $token = null)
    {
        $qtde = User::where('email', $email)->first();

        if(!$qtde)
        {
            $user = User::create(
                [
                    'church_id' => $church,
                    'person_id' => $id,
                    'email' => $email,
                    'password' => bcrypt($password),
                    'social_token' => $token ? $token : null,
                    'type' => 'test',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]
            );

            return $user;
        }


        return false;

    }
}
