<?php

namespace App\Services;


use App\Models\Church;
use App\Repositories\RegisterModelsRepository;
use App\Repositories\RequiredFieldsRepository;
use App\Traits\ConfigTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ChurchServices{

    use ConfigTrait;
    /**
     * @var RequiredFieldsRepository
     */
    private $fieldsRepository;
    /**
     * @var RegisterModelsRepository
     */
    private $modelsRepository;

    public function __construct(RequiredFieldsRepository $fieldsRepository, RegisterModelsRepository $modelsRepository)
    {

        $this->fieldsRepository = $fieldsRepository;
        $this->modelsRepository = $modelsRepository;
    }

    public function setChurchAlias($name)
    {
        $array = explode(" ", $name);

        $alias = '';

        foreach ($array as $item) {

            $alias .= substr($item, 0, 1);
        }

        return $alias;
    }

    public function getChurchAlias()
    {
        $church = $this->getUserChurch();

        return Church::where('id', $church)->first();
    }

    public function getOrgAlias()
    {
        $church_id = $this->getUserChurch();

        $church = Church::where('id', $church_id)->first();

        if($church)
        {
            return $church->alias;
        }

        return false;
    }


    /*
     * Verifica se a sigla da Unidade Federativa informada existe
     */
    public function getUF($uf)
    {

        if($uf == 'AC')
        {
            return true;
        }

        if($uf == 'AL')
        {
            return true;
        }

        if($uf == 'AP')
        {
            return true;
        }

        if($uf == 'AM')
        {
            return true;
        }

        if($uf == 'BA')
        {
            return true;
        }

        if($uf == 'CE')
        {
            return true;
        }

        if($uf == 'DF')
        {
            return true;
        }

        if($uf == 'ES')
        {
            return true;
        }

        if($uf == 'GO')
        {
            return true;
        }

        if($uf == 'MA')
        {
            return true;
        }

        if($uf == 'MT')
        {
            return true;
        }

        if($uf == 'MS')
        {
            return true;
        }

        if($uf == 'PB')
        {
            return true;
        }

        if($uf == 'PR')
        {
            return true;
        }

        if($uf == 'PE')
        {
            return true;
        }

        if($uf == 'PI')
        {
            return true;
        }

        if($uf == 'RJ')
        {
            return true;
        }

        if($uf == 'RN')
        {
            return true;
        }

        if($uf == 'RS')
        {
            return true;
        }

        if($uf == 'RO')
        {
            return true;
        }

        if($uf == 'RR')
        {
            return true;
        }

        if($uf == 'SC')
        {
            return true;
        }

        if($uf == 'SP')
        {
            return true;
        }

        if($uf == 'SE')
        {
            return true;
        }

        if($uf == 'TO')
        {
            return true;
        }

        return false;

    }

    public function restoreDefault()
    {
        try{
            $church = $this->getUserChurch();

            if($church)
            {
                DB::table('register_models')
                    ->where(['church_id' => $church])
                    ->delete();

                DB::table('required_fields')
                    ->where(['church_id' => $church])
                    ->delete();

                DB::commit();

                return $this->setBasicConfig();
            }

        }catch (\Exception $e)
        {
            DB::rollback();

            return false;
        }
    }

    public function setBasicConfig()
    {
        try{
            $church = $this->getUserChurch();

            if($church) {


                DB::table('register_models')
                    ->insert([
                        ['model' => 'person', 'text' => 'Pessoas', 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'group', 'text' => 'Grupos', 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'event', 'text' => 'Eventos', 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'teen', 'text' => 'Jovens e Crianças', 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'visitor', 'text' => 'Visitantes', 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'exhibitor', 'text' => 'Expositores', 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'sponsor', 'text' => 'Patrocinadores', 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                    ]);

                DB::table('required_fields')
                    ->insert([
                        ['model' => 'person', 'value' => 'name', 'field' => 'Nome', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'person', 'value' => 'email', 'field' => 'Email', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'person', 'value' => 'cel', 'field' => 'Celular', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'person', 'value' => 'tel', 'field' => 'Telefone', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'person', 'value' => 'gender', 'field' => 'Gênero', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'person', 'value' => 'dateBirth', 'field' => 'Data de Nasc.', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'person', 'value' => 'cpf', 'field' => 'CPF', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'person', 'value' => 'rg', 'field' => 'RG', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'person', 'value' => 'role_id', 'field' => 'Cargo', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'person', 'value' => 'maritalStatus', 'field' => 'Estado Civil', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'person', 'value' => 'father_id', 'field' => 'Nome do Pai', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'person', 'value' => 'mother_id', 'field' => 'Nome da Mãe', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'person', 'value' => 'zipCode', 'field' => 'CEP', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'person', 'value' => 'street', 'field' => 'Logradouro', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'person', 'value' => 'neighborhood', 'field' => 'Bairro', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'person', 'value' => 'city', 'field' => 'Cidade', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'person', 'value' => 'state', 'field' => 'UF', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'person', 'value' => 'number', 'field' => 'Número', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'person', 'value' => 'dateBaptism', 'field' => 'Date de Batismo', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],

                        ['model' => 'group', 'value' => 'name', 'field' => 'Nome', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'group', 'value' => 'sinceOf', 'field' => 'Data de Criação', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'group', 'value' => 'zipCode', 'field' => 'CEP', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'group', 'value' => 'street', 'field' => 'Logradouro', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'group', 'value' => 'neighborhood', 'field' => 'Bairro', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'group', 'value' => 'city', 'field' => 'Cidade', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'group', 'value' => 'state', 'field' => 'UF', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'group', 'value' => 'number', 'field' => 'Número', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],

                        ['model' => 'event', 'value' => 'name', 'field' => 'Nome', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'event', 'value' => 'frequency', 'field' => 'Frequência', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'event', 'value' => 'eventDate', 'field' => 'Data do Prox. Evento', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'event', 'value' => 'endEventDate', 'field' => 'Término do Evento', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'event', 'value' => 'startTime', 'field' => 'Hora Ínicio', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'event', 'value' => 'endTime', 'field' => 'Hora Fim', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'event', 'value' => 'group_id', 'field' => 'Pertencente ao Grupo', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'event', 'value' => 'description', 'field' => 'Descrição', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'event', 'value' => 'zipCode', 'field' => 'CEP', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'event', 'value' => 'street', 'field' => 'Logradouro', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'event', 'value' => 'neighborhood', 'field' => 'Bairro', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'event', 'value' => 'city', 'field' => 'Cidade', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'event', 'value' => 'state', 'field' => 'UF', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'event', 'value' => 'number', 'field' => 'Número', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],

                        ['model' => 'teen', 'value' => 'name', 'field' => 'Nome', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'teen', 'value' => 'email', 'field' => 'Email', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'teen', 'value' => 'cel', 'field' => 'Celular', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'teen', 'value' => 'tel', 'field' => 'Telefone', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'teen', 'value' => 'gender', 'field' => 'Gênero', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'teen', 'value' => 'dateBirth', 'field' => 'Data de Nasc.', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'teen', 'value' => 'cpf', 'field' => 'CPF', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'teen', 'value' => 'rg', 'field' => 'RG', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'teen', 'value' => 'maritalStatus', 'field' => 'Estado Civil', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'teen', 'value' => 'father_id', 'field' => 'Nome do Pai', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'teen', 'value' => 'mother_id', 'field' => 'Nome da Mãe', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'teen', 'value' => 'zipCode', 'field' => 'CEP', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'teen', 'value' => 'street', 'field' => 'Logradouro', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'teen', 'value' => 'neighborhood', 'field' => 'Bairro', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'teen', 'value' => 'city', 'field' => 'Cidade', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'teen', 'value' => 'state', 'field' => 'UF', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'teen', 'value' => 'number', 'field' => 'Número', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'teen', 'value' => 'dateBaptism', 'field' => 'Date de Batismo', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],

                        ['model' => 'visitor', 'value' => 'name', 'field' => 'Nome', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'visitor', 'value' => 'email', 'field' => 'Email', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'visitor', 'value' => 'cel', 'field' => 'Celular', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'visitor', 'value' => 'tel', 'field' => 'Telefone', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'visitor', 'value' => 'gender', 'field' => 'Gênero', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'visitor', 'value' => 'dateBirth', 'field' => 'Data de Nasc.', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'visitor', 'value' => 'cpf', 'field' => 'CPF', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'visitor', 'value' => 'rg', 'field' => 'RG', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'visitor', 'value' => 'role_id', 'field' => 'Cargo', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'visitor', 'value' => 'maritalStatus', 'field' => 'Estado Civil', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'visitor', 'value' => 'father_id', 'field' => 'Nome do Pai', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'visitor', 'value' => 'mother_id', 'field' => 'Nome da Mãe', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'visitor', 'value' => 'zipCode', 'field' => 'CEP', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'visitor', 'value' => 'street', 'field' => 'Logradouro', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'visitor', 'value' => 'neighborhood', 'field' => 'Bairro', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'visitor', 'value' => 'city', 'field' => 'Cidade', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'visitor', 'value' => 'state', 'field' => 'UF', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'visitor', 'value' => 'number', 'field' => 'Número', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'visitor', 'value' => 'dateBaptism', 'field' => 'Date de Batismo', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],

                        ['model' => 'exhibitor', 'value' => 'name', 'field' => 'Nome', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'exhibitor', 'value' => 'description', 'field' => 'Descrição', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'exhibitor', 'value' => 'site', 'field' => 'Site', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'exhibitor', 'value' => 'tel', 'field' => 'Telefone', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'exhibitor', 'value' => 'email', 'field' => 'Email', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'exhibitor', 'value' => 'category_id', 'field' => 'Categoria', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'exhibitor', 'value' => 'zipCode', 'field' => 'CEP', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'exhibitor', 'value' => 'street', 'field' => 'Logradouro', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'exhibitor', 'value' => 'number', 'field' => 'Número', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'exhibitor', 'value' => 'neighborhood', 'field' => 'Bairro', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'exhibitor', 'value' => 'city', 'field' => 'Cidade', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'exhibitor', 'value' => 'state', 'field' => 'UF', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'exhibitor', 'value' => 'responsible', 'field' => 'Responsável', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],

                        ['model' => 'sponsor', 'value' => 'name', 'field' => 'Nome', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'sponsor', 'value' => 'description', 'field' => 'Descrição', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'sponsor', 'value' => 'site', 'field' => 'Site', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'sponsor', 'value' => 'tel', 'field' => 'Telefone', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'sponsor', 'value' => 'email', 'field' => 'Email', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'sponsor', 'value' => 'category_id', 'field' => 'Categoria', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'sponsor', 'value' => 'zipCode', 'field' => 'CEP', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'sponsor', 'value' => 'street', 'field' => 'Logradouro', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'sponsor', 'value' => 'number', 'field' => 'Número', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'sponsor', 'value' => 'neighborhood', 'field' => 'Bairro', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'sponsor', 'value' => 'city', 'field' => 'Cidade', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'sponsor', 'value' => 'state', 'field' => 'UF', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ['model' => 'sponsor', 'value' => 'responsible', 'field' => 'Responsável', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],


                    ]);

            }

            DB::commit();

            return 'Configurações Padrão realizadas com sucesso';
        }
        catch(\Exception $e)
        {
            DB::rollback();

            return $e->getMessage();
        }

    }

    /*
     * Enviar alterações para a produção
     */
    public function sendChangesProd($churches)
    {
        try{

            foreach ($churches as $church)
            {
                $church = $church->id;

                $rm = DB::table('register_models')
                    ->where(['model' => 'sponsor', 'church_id' => $church])
                    ->get();

                if(count($rm) == 0)
                {
                    DB::table('register_models')
                        ->insert([

                            //['model' => 'exhibitor', 'text' => 'Expositores', 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                            ['model' => 'sponsor', 'text' => 'Patrocinadores', 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ]);

                    DB::table('required_fields')
                        ->insert([
                            ['model' => 'sponsor', 'value' => 'name', 'field' => 'Nome', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                            ['model' => 'sponsor', 'value' => 'description', 'field' => 'Descrição', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                            ['model' => 'sponsor', 'value' => 'site', 'field' => 'Site', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                            ['model' => 'sponsor', 'value' => 'tel', 'field' => 'Telefone', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                            ['model' => 'sponsor', 'value' => 'email', 'field' => 'Email', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                            ['model' => 'sponsor', 'value' => 'category_id', 'field' => 'Categoria', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                            ['model' => 'sponsor', 'value' => 'zipCode', 'field' => 'CEP', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                            ['model' => 'sponsor', 'value' => 'street', 'field' => 'Logradouro', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                            ['model' => 'sponsor', 'value' => 'number', 'field' => 'Número', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                            ['model' => 'sponsor', 'value' => 'neighborhood', 'field' => 'Bairro', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                            ['model' => 'sponsor', 'value' => 'city', 'field' => 'Cidade', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                            ['model' => 'sponsor', 'value' => 'state', 'field' => 'UF', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                            ['model' => 'sponsor', 'value' => 'responsible', 'field' => 'Responsável', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ]);

                }

                $rm = DB::table('register_models')
                    ->where(['model' => 'exhibitor', 'church_id' => $church])
                    ->get();


                if(count($rm) == 0)
                {
                    DB::table('register_models')
                        ->insert([

                            ['model' => 'exhibitor', 'text' => 'Expositores', 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],

                        ]);

                    DB::table('required_fields')
                        ->insert([
                            ['model' => 'exhibitor', 'value' => 'name', 'field' => 'Nome', 'required' => 1, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                            ['model' => 'exhibitor', 'value' => 'description', 'field' => 'Descrição', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                            ['model' => 'exhibitor', 'value' => 'site', 'field' => 'Site', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                            ['model' => 'exhibitor', 'value' => 'tel', 'field' => 'Telefone', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                            ['model' => 'exhibitor', 'value' => 'email', 'field' => 'Email', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                            ['model' => 'exhibitor', 'value' => 'category_id', 'field' => 'Categoria', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                            ['model' => 'exhibitor', 'value' => 'zipCode', 'field' => 'CEP', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                            ['model' => 'exhibitor', 'value' => 'street', 'field' => 'Logradouro', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                            ['model' => 'exhibitor', 'value' => 'number', 'field' => 'Número', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                            ['model' => 'exhibitor', 'value' => 'neighborhood', 'field' => 'Bairro', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                            ['model' => 'exhibitor', 'value' => 'city', 'field' => 'Cidade', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                            ['model' => 'exhibitor', 'value' => 'state', 'field' => 'UF', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                            ['model' => 'exhibitor', 'value' => 'responsible', 'field' => 'Responsável', 'required' => null, 'church_id' => $church, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()],
                        ]);

                }

            }

            DB::commit();

            return 'Configurações já realizadas, nenhum dado foi adicionado';


        }catch (\Exception $e){
            DB::rollback();

            return $e->getMessage();
        }

    }
}
