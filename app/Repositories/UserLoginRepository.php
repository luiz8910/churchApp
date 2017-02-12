<?php
/**
 * Created by PhpStorm.
 * User: Luiz
 * Date: 11/02/2017
 * Time: 17:30
 */

namespace App\Repositories;

use App\Models\User;


trait UserLoginRepository
{
    public function createUserLogin($id, $email = null)
    {
        User::create(
            [
                'church_id' => '1',
                'person_id' => $id,
                'email' => $email,
                'password' => bcrypt('secret'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        );
    }
}