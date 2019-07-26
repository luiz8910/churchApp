<?php

namespace App\Http\Controllers;

use App\Models\Bug;
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
        $desk = Bug::where([
            'status' => 'Pendente',
            'platform' => 'Back-end'
        ])
            ->orderBy('created_at', 'desc')
            ->get();


        $app = Bug::where([
            'status' => 'Pendente',
            'platform' => 'App'
        ])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('bugs.index', compact('desk','app'));
    }

    public function store(Request $request)
    {
        $bug = $request->all();

        $bug['platform'] = 'Back-end';

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

    public function bug_solved($id)
    {
        $bug['status'] = 'OK';

        try{
            $this->repository->update($bug, $id);

            \DB::commit();

            return json_encode(['status' => true]);

        }catch (\Exception $e)
        {
            \DB::rollBack();

            return json_encode(['status' => false]);
        }

    }
}
