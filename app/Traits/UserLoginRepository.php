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
    public function createUserLogin($id = null, $password = null, $email = null, $church = null)
    {
        if($id)
        {
            $user = User::create(
                [
                    'church_id' => $church,
                    'person_id' => $id,
                    'email' => $email,
                    'password' => bcrypt($password),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]
            );
        }

        else{
            $user = User::create(
                [
                    'church_id' => $church,
                    'email' => $email,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]
            );
        }

        return $user;
    }
}