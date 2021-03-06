<?php
/**
 * Created by PhpStorm.
 * User: Luiz
 * Date: 30/05/2017
 * Time: 12:29
 */

namespace App\Traits;


use App\Models\Frequency;
use App\Models\RequiredFields;
use App\Models\Role;
use App\Repositories\FrequencyRepository;
use App\Repositories\RoleRepository;
use Auth;
use Illuminate\Support\Facades\Route;

trait ConfigTrait
{


    public function verifyRequiredFields($data, $model, $church_id = null)
    {
        $fields = RequiredFields::where([
            'model' => $model,
            'church_id' => $church_id ? $church_id : $this->getUserChurch()
        ])->get();

        $array = array_keys($data);

        $i = 0;

        foreach ($fields as $field)
        {
            while($i < count($array))
            {
                if($array[$i] == $field->value)
                {
                    if($field->required == 1 && $data[$array[$i]] == "")
                    {
                        return $field->field;
                    }
                    else
                    {
                        $i++;
                    }
                }
                else{
                    $i++;
                }
            }

            $i = 0;

        }

        return false;
    }

    public function formatPhoneNumber($number)
    {
        $number = str_replace('(', '', $number);
        $number = str_replace(')', '', $number);
        $number = str_replace('-', '', $number);
        $number = str_replace(' ', '', $number);
        $number = '55' . $number;

        return $number;
    }

    public function formatPhoneInvoice($number)
    {
        $pos = strpos($number, '55');

        if($pos == 0)
        {
            $number = substr_replace($number, '', 0, 2);

            $number = '(' . $number;

            //$number = (15997454531
            $ddd = substr($number, 0, 3);
            //$ddd = (15

            $ddd = $ddd . ') ';
            //$ddd = (15)

            $number = $ddd . substr($number, 3);
            //$number = (15) 997454531

            $part_number = substr($number, 0, 10);
            //$part_number = (15) 99745

            $f_number = substr($number, 10);
            //$f_number = 4531

            $number = $part_number . '-' . $f_number;
            //$number = (15) 99745-4531
        }


        return $number;
    }

    public function getPusherKeyTrait()
    {
        $key = env("PUSHER_KEY");

        return json_encode($key);
    }

    public function getUserChurch()
    {
        return session('church') ? session('church') : Auth::user()->church_id;
    }

    public function getLeaderRoleId()
    {
        return Role::where('name', 'Lider')->first()->id;
    }

    public function getAdminRoleId()
    {
        return Role::where('name', 'Administrador')->first()->id;
    }

    public function getUserRole()
    {
        return session('role');
    }

    public function daily()
    {
        return 'Diário';
    }

    public function weekly()
    {
        return 'Semanal';
    }

    public function monthly()
    {
        return 'Mensal';
    }

    public function biweekly()
    {
        return 'Quinzenal';
    }

    public function unique()
    {
        return 'Encontro Único';
    }

    /*
     * Retorna qual a qtde de replicação de um evento
     * No momento de sua criação*/
    public function numNextEvents()
    {
        return 5;
    }

    //Retorna o número de semanas que serão exibidas na agenda
    public function getDefaultWeeks()
    {
        return 6;
    }

    public function getRoute()
    {
        return Route::currentRouteName();
    }

    public function returnFalse($msg = null)
    {
        return json_encode(
            [
                'status' => false,
                'msg' => $msg ? $msg : 'Um erro desconhecido ocorreu, tente novamente mais tarde.'
            ]
        );
    }

    public function trialDays()
    {
        return 30;
    }
}
