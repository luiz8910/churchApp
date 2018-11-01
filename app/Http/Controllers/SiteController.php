<?php

namespace App\Http\Controllers;

use App\Models\Plans;
use App\Repositories\AboutItemRepository;
use App\Repositories\FaqRepository;
use App\Repositories\FeaturesItemRepository;
use App\Repositories\FeaturesRepository;
use App\Repositories\IconRepository;
use App\Repositories\PlansItensRepository;
use App\Repositories\PlansRepository;
use App\Repositories\SiteRepository;
use App\Repositories\TypePlansRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class SiteController extends Controller
{
    /**
     * @var SiteRepository
     */
    private $repository;
    /**
     * @var AboutItemRepository
     */
    private $aboutItemRepository;
    /**
     * @var FeaturesRepository
     */
    private $featuresRepository;
    /**
     * @var FeaturesItemRepository
     */
    private $featuresItemRepository;
    /**
     * @var IconRepository
     */
    private $iconRepository;
    /**
     * @var FaqRepository
     */
    private $faqRepository;
    /**
     * @var PlansRepository
     */
    private $plansRepository;
    /**
     * @var PlansItensRepository
     */
    private $plansItensRepository;
    /**
     * @var TypePlansRepository
     */
    private $typePlansRepository;

    public function __construct(SiteRepository $repository, AboutItemRepository $aboutItemRepository,
                                FeaturesRepository $featuresRepository, FeaturesItemRepository $featuresItemRepository,
                                IconRepository $iconRepository, FaqRepository $faqRepository, PlansRepository $plansRepository,
                                PlansItensRepository $plansItensRepository, TypePlansRepository $typePlansRepository)
    {
        $this->repository = $repository;
        $this->aboutItemRepository = $aboutItemRepository;
        $this->featuresRepository = $featuresRepository;
        $this->featuresItemRepository = $featuresItemRepository;
        $this->iconRepository = $iconRepository;
        $this->faqRepository = $faqRepository;
        $this->plansRepository = $plansRepository;
        $this->plansItensRepository = $plansItensRepository;
        $this->typePlansRepository = $typePlansRepository;
    }

    public function index()
    {
        $main = $this->repository->findByField('type', 'main')->first();

        $about = $this->repository->findByField('type', 'about')->first();

        $about_item = $this->aboutItemRepository->all();

        $features = $this->featuresRepository->all();

        $feature_item = $this->featuresItemRepository->all();

        foreach ($feature_item as $item) {
            $icon = DB::table('icons')->where('id', $item->icon_id)->select('path')->first();

            if(count($icon) == 1)
            {
                $item->icon_name = $icon;
            }
            else{
                $item->icon_name = null;
            }

        }

        $faq = $this->faqRepository->all();

        $plans = $this->plansRepository->orderBy('price')->all();

        $plans_item = $this->plansItensRepository->all();

        $plans_types = $this->typePlansRepository->orderBy('save_money')->all();

        $plan_features = DB::table('plan_features')->get();

        foreach ($plans as $plan) {
            $plan->type_name = $this->typePlansRepository->find($plan->type_id)->type;
        }


        return view('site.home', compact('main', 'about', 'about_item',
            'features', 'feature_item', 'faq', 'plans', 'plans_item', 'plans_types', 'plan_features'));
    }

    public function adminHome()
    {
        $main = $this->repository->findByField('type', 'main')->first();

        $about = $this->repository->findByField('type', 'about')->first();

        $about_item = $this->aboutItemRepository->all();

        $faq = $this->faqRepository->all();

        return view('site.admin', compact('main', 'about', 'about_item', 'faq'));
    }

    public function adminFeatures()
    {
        $features = $this->featuresRepository->all();

        $features_item = $this->featuresItemRepository->all();

        foreach ($features_item as $item) {

            if($item->icon_id)
            {
                $item->icon_name = $this->iconRepository->find($item->icon_id)->path;
            }
            else{
                $item->icon_name = 'uploads/icons/ic-alerta.png';
            }

        }

        $icons = $this->iconRepository->all();

        return view('site.features', compact('features', 'features_item', 'icons'));
    }

    public function adminPlans()
    {
        $plans = $this->plansRepository->orderBy('type_id')->all();

        $plans_item = $this->plansItensRepository->all();

        $plans_types = $this->typePlansRepository->orderBy('save_money')->all();

        $plan_features = DB::table('plan_features')->get();

        foreach ($plans as $plan) {
            $plan->type_name = $this->typePlansRepository->find($plan->type_id)->type;
        }

        $url = '/newPlan';

        $url2 = '/newPlanType';


        return view('site.plans', compact('plans', 'plans_item', 'url', 'url2', 'plans_types', 'plan_features'));
    }



    public function adminContact()
    {
        return view('site.contact');
    }

    public function editMain($data)
    {
        $data = \GuzzleHttp\json_decode($data);

        $i = 0;

        while($i < count($data))
        {
            $data[$i] = str_replace("--", '?', $data[$i]);
            $i++;
        }

        $id = $this->repository->findByField('type', 'main')->first()->id;

        $stop = false;

        $i = 0;
        $x = 1;

        $d = [];

        while(!$stop)
        {
            if(array_key_exists($i, $data))
            {
                $d['text_'.$x] = $data[$i];
            }
            else{
                $stop = true;
            }

            $i++;
            $x++;
        }

        $this->repository->update($d, $id);

        return json_encode(['status' => true]);
    }

    public function editAbout($data)
    {
        $data = \GuzzleHttp\json_decode($data);

        $i = 0;

        while($i < count($data))
        {
            $data[$i] = str_replace("--", '?', $data[$i]);
            $i++;
        }

        $id = $this->repository->findByField('type', 'about')->first()->id;

        $stop = false;

        $i = 0;
        $x = 1;

        $d = [];

        while(!$stop)
        {
            if(array_key_exists($i, $data))
            {
                $d['text_'.$x] = $data[$i];
            }
            else{
                $stop = true;
            }

            $i++;
            $x++;
        }

        $this->repository->update($d, $id);

        return json_encode(['status' => true]);
    }

    public function editAboutItem($data)
    {
        $data = \GuzzleHttp\json_decode($data);

        $i = 0;

        while($i < count($data))
        {
            $data[$i] = str_replace("--", '?', $data[$i]);
            $i++;
        }

        //print_r($data);

        $i = 0;
        $x = 1;
        $y = 1;

        while($i < 7)
        {
            $d['title'] = $data[$i];
            $d['text'] = $data[$x];

            $this->aboutItemRepository->update($d, $y);

            $y++;
            $i = $i + 2;
            $x = $x + 2;
        }


        return json_encode(['status' => true]);
    }



    public function newFeature($data)
    {
        $data = \GuzzleHttp\json_decode($data);

        $i = 0;

        while($i < count($data))
        {
            $data[$i] = str_replace("--", '?', $data[$i]);
            $i++;
        }

        $d['title'] = $data[0];
        $d['text'] = $data[1];

        if($this->featuresRepository->create($d)){
            return json_encode(['status' => true]);
        }

        return json_encode(['status' => false]);
    }

    public function deleteFeature($id)
    {
        try{
            $feature = $this->featuresRepository->find($id);

            $item = $this->featuresItemRepository->findByField('feature_id', $id);

            if(count($item) > 0)
            {
                foreach ($item as $value)
                {
                    $i = $this->featuresItemRepository->find($value->id);

                    $i->delete();
                }
            }

            $feature->delete();

            DB::commit();

            return json_encode(['status' => true]);

        }catch(\Exception $e)
        {
            DB::rollback();

            return json_encode(['status' => false]);
        }

    }

    public function newFeatureItem($data, $id)
    {
        $data = \GuzzleHttp\json_decode($data);

        $i = 0;

        while($i < count($data))
        {
            $data[$i] = str_replace("--", '?', $data[$i]);
            $i++;
        }

        foreach ($data as $item)
        {
            $d['text'] = $item;
            $d['feature_id'] = $id;

            $this->featuresItemRepository->create($d);
        }


        return json_encode(['status' => true]);

    }

    public function deleteItemFeature($id)
    {
        try{
            $feature_item = $this->featuresItemRepository->find($id);

            $feature_item->delete();

            DB::commit();

            return json_encode(['status' => true]);

        }catch(\Exception $e)
        {
            DB::rollback();

            return json_encode(['status' => false]);
        }

    }

    public function editFeatures($data, $id)
    {
        $data = \GuzzleHttp\json_decode($data);

        $i = 0;

        while($i < count($data))
        {
            $data[$i] = str_replace("--", '?', $data[$i]);
            $i++;
        }

        try{

            foreach($data as $item)
            {
                $feature_id = str_replace('feature_id-', '', $item->name, $count);

                if($count > 0)
                {
                    $d['text'] = $item->value;

                    $this->featuresItemRepository->update($d, $feature_id);
                }
                else{
                    if($item->name == 'title')
                    {
                        $x['title'] = $item->value;

                        $this->featuresRepository->update($x, $id);
                    }
                    else{

                        $x['text'] = $item->value;

                        $this->featuresRepository->update($x, $id);
                    }
                }
            }

            DB::commit();

            return json_encode(['status' => true]);

        }catch(\Exception $e)
        {
            DB::rollback();

            return json_encode(['status' => false]);
        }

    }

    public function uploadIcons(Request $request)
    {
        $file = $request->file('img');

        $name = $file->getClientOriginalName();

        $imgName = 'uploads/icons/' . $name ;

        if(!File::exists($imgName))
        {
            $file->move('uploads/icons', $imgName);

            $arr['path'] = $imgName;

            $this->iconRepository->create($arr);

            $request->session()->flash('img.success', 'Upload do arquivo ' . $name . ' Realizado com sucesso');

        }else{
            $request->session()->flash('img.error', 'O arquivo ja existe no servidor');

        }

        return redirect()->route('admin.home');
    }

    public function uploadIconsBatch(Request $request)
    {
        $files = $request->file('file');

        $i = 0;

        foreach ($files as $file)
        {
            $name = $file->getClientOriginalName();

            $imgName = 'uploads/icons/' . $name ;

            if(!File::exists($imgName))
            {
                $file->move('uploads/icons', $imgName);

                $arr['path'] = $imgName;

                $this->iconRepository->create($arr);

                $i++;
            }
        }

        if($i == 0)
        {
            $request->session()->flash('img.error', 'O upload de nenhum arquivo foi realizado');
        }
        else{
            $request->session()->flash('img.success', 'Upload de ' . $i . ' arquivos realizado com sucesso');
        }



        return redirect()->route('admin.home');
    }

    public function changeIcons($feature_item_id, $icon_id)
    {
        $data['icon_id'] = $icon_id;

        if($this->featuresItemRepository->update($data, $feature_item_id))
        {
            return json_encode(['status' => true]);
        }

        return json_encode(['status' => false]);

    }

    public function newFaq($data)
    {
        $data = \GuzzleHttp\json_decode($data);

        $i = 0;

        while($i < count($data))
        {
            $data[$i] = str_replace("--", '?', $data[$i]);
            $i++;
        }

        $d['question'] = $data[0];
        $d['answer'] = $data[1];

        if($this->faqRepository->create($d))
        {
            return json_encode(['status' => true]);
        }

        return json_encode(['status' => false]);

    }

    public function editFaq($data, $id)
    {
        $data = \GuzzleHttp\json_decode($data);

        $i = 0;

        while($i < count($data))
        {
            $data[$i] = str_replace("--", '?', $data[$i]);
            $i++;
        }

        $d['question'] = $data[0];
        $d['answer'] = $data[1];

        if($this->faqRepository->update($d, $id))
        {
            return json_encode(['status' => true]);
        }

        return json_encode(['status' => false]);
    }

    public function deleteFaq($id)
    {
        if($this->faqRepository->delete($id))
        {
            return json_encode(['status' => true]);
        }

        return json_encode(['status' => false]);
    }


    public function newPlanItem(Request $request)
    {
        $data['text'] = $request->get('text');

        if($this->plansItensRepository->create($data))
        {
            $request->session()->flash('success.msg', 'Novo Item criado com sucesso');

        }else{

            $request->session()->flash('error.msg', 'Um erro ocorreu');
        }

        return redirect()->back();
    }

    public function deletePlanItem($id)
    {
        if($this->plansItensRepository->delete($id))
        {
            DB::table('plan_features')
                ->where('plan_item_id', $id)
                ->delete();

            return json_encode(['status' => true]);
        }

        return json_encode(['status' => false]);
    }

    public function editPlanType(Request $request)
    {
        $data = $request->except('input-id');

        $id = $request->get('input-id');

        if($this->typePlansRepository->update($data, $id))
        {
            $request->session()->flash('success.msg', 'Tipo de plano alterado com sucesso');

        }else{

            $request->session()->flash('error.msg', 'Um erro ocorreu');
        }

        return redirect()->back();
    }

    public function deletePlanType($id)
    {
        if($this->typePlansRepository->delete($id))
        {
            $plans = $this->plansRepository->findByField('type_id', $id);

            foreach ($plans as $plan) {
                $this->deletePlan($plan->id);
            }

            return json_encode(['status' => true]);
        }

        return json_encode(['status' => false]);
    }

    public function trial($id)
    {
        $plan = $this->plansRepository->find($id);

        $plan_type = $this->typePlansRepository->find($plan->type_id);

        $plan_features = DB::table('plan_features')->where('plan_id', $id)->get();

        $plan_items = $this->plansItensRepository->all();

        $plans_types = $this->typePlansRepository->all();

        /*
         * Usado quando um plano tem mais de uma frequencia de pagamento
         * Exemplo:
         * O plano x pode ser pago anualmente e mensalmente
         * Então $multi_plan = true
         */

        $multi_plan = false;

        $types = $this->plansRepository->findByField('name', $plan->name);

        if(count($types) > 1)
        {
            $multi_plan = true;
        }

        return view('site.confirmation-trial', compact('plan', 'plan_type', 'plan_items',
            'plan_features', 'plans_types', 'types', 'multi_plan'));
    }

    public function changePlan($type, $id)
    {
        $name = $this->plansRepository->find($id)->name;

        $plan = DB::table('plans')->where([
            'name' => $name,
            ['id', '<>', $id],
            'type_id' => $type
        ])->whereNull('deleted_at')->first();

        if(count($plan) > 0)
        {
            return json_encode(['status' => true, 'id' => $plan->id]);
        }

        return json_encode(['status' => false]);
    }

    public function signupTrial()
    {
        return view('site.signup-trial');
    }
}
