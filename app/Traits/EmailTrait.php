<?php
/**
 * Created by PhpStorm.
 * User: Luiz
 * Date: 21/04/2017
 * Time: 19:53
 */

namespace App\Traits;

use App\Mail\DenyUser;
use App\Mail\ForLeaders;
use App\Mail\resetPassword;
use App\Mail\welcome;
use App\Mail\Contact_Site;
use App\Models\ContactSite;
use App\Models\Person;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

trait EmailTrait
{

    private function getUrl()
    {
        return env('APP_URL') . 'login';
    }

    public function emailTestEditTrait($email, $id)
    {
        $user = User::select('id')->where('email', $email)->first();

        if($user)
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

    /*public function emailExists($email)
    {

        $result = count(User::withTrashed()->where('email', $email)->get());

        if($result > 0)
        {
            return true;
        }

        return false;


    }*/

    public function emailExists($email)
    {
        $user = new User();

        $trashed = $user->onlyTrashed()->where('email', $email)->first();

        if($trashed)
        {
            $trashed->forceDelete();

            return false;
        }

        $email_exist = $user->where('email', $email)->first();

        if($email_exist)
        {
            return false;
        }

        return true;


    }

    public function welcome($user, $password)
    {
        $url = $this->getUrl();

        Mail::to($user)
            ->send(new welcome(
                $user, $url, $password
            ));

        return true;
    }

    public function denyUser($user, $msg)
    {
        $url = $this->getUrl();

        Mail::to($user)
            ->send(new DenyUser($user, $msg, $url));

        return true;
    }

    public function contact_site($name, $email, $tel, $msg)
    {
        Mail::to('luiz.sanches8910@gmail.com')
            ->send(new Contact_Site($name, $email, $tel, $msg));

        Mail::to('dagokeio@gmail.com')->send(new Contact_Site($name, $email, $tel, $msg));


        return true;
    }

    public function newWaitingApproval($waitingPerson, $church_id, $subject = null)
    {
        //Url para botão no email
        $url = $this->getUrl();

        //ID de cargo do líder
        $leader = Role::where('name', 'Lider')->first()->id;

        //ID de cargo do admin
        $admin = Role::where('name', 'Administrador')->first()->id;

        //Enviar email para admins e líderes

        $admins = Person::where([
            'role_id' => $admin,
            'church_id' => $church_id,
            'status' => 'active',
            'deleted_at' => null
        ])->get();

        $leaders = Person::where([
            'role_id' => $leader,
            'church_id' => $church_id,
            'status' => 'active',
            'deleted_at' => null
        ])->get();

        $people = $admins->merge($leaders);

        $data = new \StdClass;

        foreach ($people as $person)
        {
            //Nome inteiro da pessoa que está aguardando
            $data->fullName = $waitingPerson->name. ' ' . $waitingPerson->lastName;

            //Email Remetente
            $data->from = 'membros@beconnect.com.br';

            //Assunto do Email
            $data->subject = $subject ? $subject . ' ' . $data->fullName  : 'Novo Usuário Aguardando Aprovação - ' .$data->fullName;

            //Layout do Email
            $data->view = 'new-waiting-approval';

            //Nome do Líder/Admin
            $data->name = $person->name;

            //Email da pessoa que está aguardando
            $data->waitingPerson_email = $waitingPerson->email;

            //Link para o perfil do candidato a membro
            $data->profile = "https://beconnect.com.br/person/$waitingPerson->id/edit";

            //Envio do Email
            Mail::to($person->user->email)->send(new ForLeaders($person->user, $data, $url));
        }
    }
}
