<?php
/**
 * Created by PhpStorm.
 * User: Luiz
 * Date: 25/04/2017
 * Time: 18:18
 */

namespace App\Traits;


use Illuminate\Support\Facades\DB;

trait PeopleTrait
{

    public function updateTag($tag, $id, $table)
    {
        DB::table($table)->
            where('id', $id)->
            update(['tag' => $tag]);
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
    public function children($children, $gender, $id = null)
    {
        foreach ($children as $child) {
            //$resp = $this->repository->find($id);

            $data['name'] = $child['childName'];

            $data['lastName'] = $child['childLastName'];

            $data['dateBirth'] = $this->formatDateBD($child['childDateBirth']);

            $data['imgProfile'] = 'uploads/profile/noimage.png';

            if ($gender == 'M') {
                $data['father_id'] = $id;
            } else {
                $data['mother_id'] = $id;
            }

            $data['role_id'] = 2;

            $data['maritalStatus'] = 'Solteiro';

            $idChild = DB::table("people")->insertGetId($data);

            $this->tag($this->repository->tag($data['dateBirth']), $idChild, 'people');
        }

        if($id)
        {
            DB::table("people")
                ->where('id', $id)
                ->update(['hasKids' => 'on']);
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
            update(['imgProfile' => $imgName]);

        //$request->session()->flash('updateUser', 'Alterações realizadas com sucesso');
    }

    public function updateMaritalStatus($partner, $id, $table)
    {
        DB::table($table)
            ->where('id', $partner)
            ->update(
                ['partner' => $id, 'maritalStatus' => 'Casado']
            );
    }
}