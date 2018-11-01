<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Repositories\PlansRepository;
use App\Repositories\TypePlansRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * @var PlansRepository
     */
    private $plansRepository;
    /**
     * @var TypePlansRepository
     */
    private $typePlansRepository;

    public function __construct(PlansRepository $plansRepository, TypePlansRepository $typePlansRepository)
    {
        $this->plansRepository = $plansRepository;
        $this->typePlansRepository = $typePlansRepository;
    }

    public function storePlan(Request $request)
    {
        $data = $request->all();

        if($request->exists('check-insert'))
        {
            $data['most_popular'] = 1;

            DB::table('plans')
                ->where([
                    'type_id' => $data['type_id'],
                    'most_popular' => 1
                ])->update(['most_popular' => 0]);

        }
        else{
            $data['most_popular'] = 0;
        }

        $data['description'] = trim($data['description']);

        $data['price'] = str_replace(",", ".", $data['price']);

        if(is_numeric($data['price'])){

            $id = $this->plansRepository->create($data)->id;

            if($id)
            {
                $pay = new Payment();

                $data['name'] = str_replace(" ", "_", $data['name']);

                $data['name'] = strtoupper($data['name']);

                $a['payu_code'] = $pay->planStore($data);

                $this->plansRepository->update($a, $id);

                $request->session()->flash('success.msg', 'Plano inserido com sucesso');

            }else{

                $request->session()->flash('error.msg', 'Um erro ocorreu');
            }
        }
        else{

            $request->session()->flash('error.msg', 'Digite um número válido');
        }


        return redirect()->back();
    }

    public function updatePlan(Request $request)
    {
        $data = $request->except(['input-id', 'item']);

        $id = $request->get('input-id');

        $itens = $request->get('item');

        if($request->exists('most_popular'))
        {
            $data['most_popular'] = 1;

            DB::table('plans')
                ->where([
                    'type_id' => $data['type_id'],
                    'most_popular' => 1
                ])->update(['most_popular' => 0]);

        }
        else{
            $data['most_popular'] = 0;
        }

        $data['description'] = trim($data['description']);

        $data['price'] = str_replace(",", ".", $data['price']);

        if(is_numeric($data['price'])){

            if($this->plansRepository->update($data, $id))
            {
                if($itens)
                {
                    foreach ($itens as $item)
                    {
                        $exists = DB::table('plan_features')
                            ->where([
                                'plan_id' => $id,
                                'plan_item_id' => $item
                            ])->get();

                        if(count($exists) == 0)
                        {
                            DB::table('plan_features')
                                ->insert([
                                    'plan_id' => $id,
                                    'plan_item_id' => $item,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now()
                                ]);
                        }

                    }
                }

                $pay = new Payment();

                $data['name'] = str_replace(" ", "_", $data['name']);

                $data['name'] = strtoupper($data['name']);

                $payu_code = $this->plansRepository->findByField('id', $id)->first()->payu_code;

                if($pay->planUpdate($data, $payu_code))
                {
                    $request->session()->flash('success.msg', 'Plano inserido com sucesso');
                }
                else{
                    $request->session()->flash('error.msg', 'Ocorreu um erro no servidor da Payu');
                }


            }else{

                $request->session()->flash('error.msg', 'Um erro ocorreu');
            }
        }
        else{

            $request->session()->flash('error.msg', 'Digite um número válido');
        }

        return redirect()->back();
    }

    public function deletePlan($id)
    {
        $payu_code = $this->plansRepository->findByField('id', $id)->first()->payu_code;

        if($this->plansRepository->delete($id) && count($payu_code) == 1)
        {
            DB::table('plan_features')
                ->where('plan_id', $id)
                ->delete();

            $pay = new Payment();

            $pay->planDelete($payu_code);

            return json_encode(['status' => true]);
        }

        return json_encode(['status' => false]);
    }



    public function newPlanType(Request $request)
    {
        $data = $request->all();

        if(!$data['save_money'])
        {
            $data['save_money'] = 0;
        }

        if($this->typePlansRepository->create($data))
        {
            $request->session()->flash('success.msg', 'Tipo inserido com sucesso');

        }else{

            $request->session()->flash('error.msg', 'Um erro ocorreu');
        }

        return redirect()->back();
    }


}
