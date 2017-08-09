<?php
/**
 * Created by PhpStorm.
 * User: Luiz
 * Date: 25/04/2017
 * Time: 18:18
 */

namespace App\Traits;


use App\Models\RecentUsers;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait PeopleTrait
{

    public function updateTag($tag, $id, $table)
    {
        DB::table($table)->
            where('id', $id)->
            update(['tag' => $tag, 'updated_at' => Carbon::now()]);

    }

    public function tag($dateBirth)
    {
        $today = date("Y-m-d");

        $date = DB::select("SELECT DATEDIFF('$today', '$dateBirth')/365 AS DiffDate");

        $date = (int)$date[0]->DiffDate;

        return $date < 18 ? $date < 11 ? 'kid' : 'teen' : 'adult';
    }

    /**
     * Atribui pais aos filhos
     *
     * @param $children
     * @param $id (do pai ou mãe)
     * @param $gender
     */
    public function children($children, $id, $gender, $role_id)
    {
        foreach ($children as $child) {

            $data['name'] = $child['childName'];

            $data['lastName'] = $child['childLastName'];

            $data['dateBirth'] = $this->formatDateBD($child['childDateBirth']);

            $data['imgProfile'] = 'uploads/profile/noimage.png';

            if($id){
                if ($gender == 'M') {
                    $data['father_id'] = $id;
                } else {
                    $data['mother_id'] = $id;
                }
            }

            $data['church_id'] = Auth::getUser()->church_id;

            $data['role_id'] = $role_id;

            $data['maritalStatus'] = 'Solteiro';

            $idChild = DB::table("people")->insertGetId($data);

            $this->updateTag($this->tag($data['dateBirth']), $idChild, 'people');
        }

        if($id)
        {
            DB::table("people")
                ->where('id', $id)
                ->update(['hasKids' => 1, 'updated_at' => Carbon::now()]);
        }


    }

    /**
     * Insere a imagem de perfil do membro/visitante cadastrado
     *
     * @param $file
     * @param $id
     * @param $name
     */
    public function imgProfile($file, $id, $name, $table)
    {
        $imgName = 'uploads/profile/' . $id . '-' . $name . '.' . $file->getClientOriginalExtension();

        $file->move('uploads/profile', $imgName);

        DB::table($table)->
            where('id', $id)->
            update(['imgProfile' => $imgName, 'updated_at' => Carbon::now()]);

        //$request->session()->flash('updateUser', 'Alterações realizadas com sucesso');
    }

    public function updateMaritalStatus($partner, $id, $table)
    {
        DB::table($table)
            ->where('id', $partner)
            ->update(
                [
                    'partner' => $id,
                    'maritalStatus' => 'Casado',
                    'updated_at' => Carbon::now(),
                ]
            );

        DB::table($table)
            ->where("id", $id)
            ->update(
                [
                    'partner' => $partner,
                    'maritalStatus' => 'Casado',
                    'updated_at' => Carbon::now(),
                ]
            );
    }

    public function updateMaritalSingleStatus($partner, $maritalStatus, $table)
    {
        DB::table($table)
            ->where('id', $partner)
            ->update(
                [
                    'partner' => null,
                    'maritalStatus' => $maritalStatus,
                    'updated_at' => Carbon::now()
                ]
            );
    }

    public function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function traitCheckCPF($cpf)
    {
        $person = DB::table('people')
                    ->where('cpf', $cpf)
                    ->first();

        $church_id = $this->getUserChurch();

        if (count($person) > 0)
        {
            if($person->church_id == $church_id)
            {
                return json_encode(
                    [
                        'status' => true,
                        'type' => 'person',
                        'data' => $person
                    ]
                );
            }
            else{
                return json_encode(
                    [
                        'status' => true,
                        'type' => 'person',
                        'data' => 0
                    ]
                );
            }

        }
        else{
            $visitor = DB::table('visitors')
                ->where('cpf', $cpf)
                ->first();

            if(count($visitor) > 0){
                return json_encode(
                    [
                        'status' => true,
                        'type' => 'visitor',
                        'data' => $visitor
                    ]
                );
            }
        }

        return json_encode(['status' => false]);
    }

    public function newRecentUser($id, $church_id)
    {
        RecentUsers::insert([
            'person_id' => $id,
            'church_id' => $church_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

}