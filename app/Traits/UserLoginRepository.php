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
    public function createUserLogin($id, $password = null, $email = null, $church, $visitor = null)
    {
        $user = User::create(
            [
                'church_id' => $church,
                'person_id' => $id = $visitor ? null : $id,
                'email' => $email or null,
                'password' => bcrypt($password) or null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        );

        return $user;
    }
}