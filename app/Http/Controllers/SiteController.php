<?php

namespace App\Http\Controllers;

use App\Repositories\AboutItemRepository;
use App\Repositories\FeaturesItemRepository;
use App\Repositories\FeaturesRepository;
use App\Repositories\IconRepository;
use App\Repositories\SiteRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
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

    public function __construct(SiteRepository $repository, AboutItemRepository $aboutItemRepository,
                                FeaturesRepository $featuresRepository, FeaturesItemRepository $featuresItemRepository,
                                IconRepository $iconRepository)
    {
        $this->repository = $repository;
        $this->aboutItemRepository = $aboutItemRepository;
        $this->featuresRepository = $featuresRepository;
        $this->featuresItemRepository = $featuresItemRepository;
        $this->iconRepository = $iconRepository;
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

        //dd($feature_item);

        return view('site.home', compact('main', 'about', 'about_item', 'features', 'feature_item'));
    }

    public function adminHome()
    {
        $main = $this->repository->findByField('type', 'main')->first();

        $about = $this->repository->findByField('type', 'about')->first();

        $about_item = $this->aboutItemRepository->all();

        return view('site.admin', compact('main', 'about', 'about_item'));
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

    public function adminContact()
    {
        return view('site.contact');
    }

    public function editMain($data)
    {
        $data = \GuzzleHttp\json_decode($data);

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
}
