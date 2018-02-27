<?php

namespace App\Http\Controllers;

use App\Repositories\AboutItemRepository;
use App\Repositories\FeaturesItemRepository;
use App\Repositories\FeaturesRepository;
use App\Repositories\SiteRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function __construct(SiteRepository $repository, AboutItemRepository $aboutItemRepository,
                                FeaturesRepository $featuresRepository, FeaturesItemRepository $featuresItemRepository)
    {
        $this->repository = $repository;
        $this->aboutItemRepository = $aboutItemRepository;
        $this->featuresRepository = $featuresRepository;
        $this->featuresItemRepository = $featuresItemRepository;
    }

    public function index()
    {
        $main = $this->repository->findByField('type', 'main')->first();

        $about = $this->repository->findByField('type', 'about')->first();

        $about_item = $this->aboutItemRepository->all();

        $features = $this->featuresRepository->all();

        $feature_item = $this->featuresItemRepository->all();

        return view('site.home', compact('main', 'about', 'about_item', 'features', 'feature_item'));
    }

    public function adminHome()
    {
        $main = $this->repository->findByField('type', 'main')->first();

        $about = $this->repository->findByField('type', 'about')->first();

        $about_item = $this->aboutItemRepository->all();

        return view('site.admin', compact('main', 'about', 'about_item'));
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

    public function adminFeatures()
    {
        $features = $this->featuresRepository->all();

        $features_item = $this->featuresItemRepository->all();

        return view('site.features', compact('features', 'features_item'));
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
}
