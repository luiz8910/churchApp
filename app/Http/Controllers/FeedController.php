<?php

namespace App\Http\Controllers;

use App\Repositories\FeedRepository;
use App\Traits\ConfigTrait;
use App\Traits\CountRepository;
use App\Traits\NotifyRepository;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    use CountRepository, NotifyRepository, ConfigTrait;
    /**
     * @var FeedRepository
     */
    private $repository;

    public function __construct(FeedRepository $repository)
    {

        $this->repository = $repository;
    }

    public function index()
    {
        $church_id = $this->getUserChurch();

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $notify = $this->notify();

        $qtde = count($notify) or 0;

        $leader = $this->getLeaderRoleId();

        $role = $this->getUserRole();

        return view('feeds.index', compact('groups', 'countPerson', 'countMembers',
            'countGroups', 'notify', 'qtde', 'leader', 'role', 'church_id'));
    }
}
