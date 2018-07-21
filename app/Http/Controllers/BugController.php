<?php

namespace App\Http\Controllers;

use App\Repositories\BugRepository;
use App\Traits\ConfigTrait;
use Illuminate\Http\Request;

class BugController extends Controller
{
    use ConfigTrait;
    /**
     * @var BugRepository
     */
    private $repository;

    public function __construct(BugRepository $repository)
    {

        $this->repository = $repository;
    }

    public function bugs()
    {
        $desk = $this->repository->findWhere(['status' => 'pending', 'platform' => 'Desktop']);

        $app = $this->repository->findWhere(['status' => 'pending', 'platform' => 'App']);

        return view('bugs.index', compact('desk','app'));
    }

    public function store(Request $request)
    {
        $bug = $request->all();

        $bug['platform'] = 'Desktop';

        if(!isset($bug['church_id']) || $bug['church_id'] == "")
        {
            $bug['church_id'] = $this->getUserChurch();
        }

        $this->repository->create($bug);

        return redirect()->route('index');
    }

    public function storeApp(Request $request)
    {
        $bug = $request->all();

        $bug['platform'] = 'App';

        $this->repository->create($bug);

        return json_encode(['status' => true]);
    }
}
