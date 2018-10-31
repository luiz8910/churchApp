<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Repositories\PlansRepository;
use App\Repositories\TypePlansRepository;
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
