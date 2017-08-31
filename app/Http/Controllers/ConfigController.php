<?php

namespace App\Http\Controllers;

use App\Models\RequiredFields;
use App\Repositories\RegisterModelsRepository;
use App\Repositories\RequiredFieldsRepository;
use App\Repositories\RoleRepository;
use App\Traits\ConfigTrait;
use App\Traits\CountRepository;
use App\Traits\NotifyRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfigController extends Controller
{
    use ConfigTrait, CountRepository, NotifyRepository;

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

    public function index()
    {
        /*
        * Variáveis gerais p/ todas as páginas
        *
        */

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $leader = $this->getLeaderRoleId();

        $notify = $this->notify();

        $qtde = count($notify) or 0;

        $church_id = $this->getUserChurch();

        $class = [];

        $models = $this->modelsRepository->findByField('church_id', $church_id);

        foreach ($models as $model)
        {
            $class[] = $this->fieldsRepository->findWhere([
                'model' => $model->model,
                'church_id' => $church_id
            ]);
        }

        //dd($models);

        //Fim Variáveis

        return view('config.index', compact('countPerson', 'countGroups', 'leader', 'notify', 'qtde',
            'class', 'models'));
    }

    /**
     * @param Request $request
     * @param $model
     * @return \Illuminate\Http\RedirectResponse
     *
     * Função secreta para cadastrar novos campos
     */
    public function newRule(Request $request, $model)
    {
        $data = $request->all();

        if($data["field"] == "")
        {
            $request->session()->flash('error.field', 'Preencha o campo Nome do Campo');
            return redirect()->back();
        }

        //$required = isset($data["required"]) ? 1 : null;

        $data["model"] = $model;

        $data["church_id"] = $this->getUserChurch();

        $this->fieldsRepository->create($data);

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @param $model
     *
     * Usuário faz update da lista dos campos obrigatórios
     */
    public function updateRule(Request $request, $model)
    {
        $data = $request->all();

        $church_id = $this->getUserChurch();

        unset($data["_token"]);

        $list = $this->fieldsRepository->findWhere([
            'model' => $model,
            'church_id' => $church_id
        ]);

        $array = array_keys($data);

        $i = 0;
        $x = 0;

        $stop = false;

        while(!$stop)
        {
            while($x < count($list))
            {
                if($array[$i] == $list[$x]->value)
                {
                    DB::table("required_fields")
                        ->where([
                            'model' => $model,
                            'church_id' => $church_id,
                            'value' => $list[$x]->value
                        ])
                        ->update([
                            "required" => 1
                        ]);

                    if($i != (count($array) - 1)){
                        $i++;
                    }

                    $x++;

                }else{
                    DB::table("required_fields")
                        ->where([
                            'model' => $model,
                            'church_id' => $church_id,
                            'value' => $array[$i]
                        ])
                        ->update([
                            "required" => 1
                        ]);

                    DB::table("required_fields")
                        ->where([
                            'model' => $model,
                            'church_id' => $church_id,
                            'value' => $list[$x]->value
                        ])
                        ->update([
                            "required" => null
                        ]);

                    $x++;
                }
            }

            $stop = true;
        }


        return redirect()->route('config.index');

    }

    public function newModel(Request $request)
    {
        $data = $request->all();

        $data["church_id"] = $this->getUserChurch();

        $this->modelsRepository->create($data);

        return redirect()->route('config.index');
    }

    public function getPusherKey()
    {
        return $this->getPusherKeyTrait();
    }

    /*
     * Marca todas as notificações como lidas
     */
    public function markAllAsRead()
    {
        $user = \Auth::user();

        $user->unreadNotifications()->update(['read_at' => Carbon::now()]);

        return json_encode(["status" => true]);
    }

    //Recupera o endereço completo da igreja
    public function getChurchZipCode()
    {
        $address = \DB::table('churches')
            ->where('id', $this->getUserChurch())
            ->first();

        return json_encode($address);
    }

    public function import()
    {
        /*
        * Variáveis gerais p/ todas as páginas
        *
        */

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $leader = $this->getLeaderRoleId();

        $notify = $this->notify();

        $qtde = count($notify) or 0;

        $church_id = $this->getUserChurch();

        /*
         * Fim Variáveis
         */

        return view('config.dropzone', compact('countPerson', 'countGroups', 'leader', 'notify', 'qtde', 'church_id'));
    }
}
