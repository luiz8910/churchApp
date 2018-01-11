<?php

namespace App\Http\Controllers;

use App\Repositories\FeedRepository;
use App\Repositories\PersonRepository;
use App\Services\FeedServices;
use App\Traits\ConfigTrait;
use App\Traits\CountRepository;
use App\Traits\NotifyRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    use CountRepository, NotifyRepository, ConfigTrait;
    /**
     * @var FeedRepository
     */
    private $repository;
    /**
     * @var PersonRepository
     */
    private $personRepository;
    /**
     * @var FeedServices
     */
    private $feedServices;

    public function __construct(FeedRepository $repository, PersonRepository $personRepository, FeedServices $feedServices)
    {

        $this->repository = $repository;
        $this->personRepository = $personRepository;
        $this->feedServices = $feedServices;
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

        $feeds = $this->feedServices->feeds();

        return view('feeds.index', compact('groups', 'countPerson', 'countMembers',
            'countGroups', 'notify', 'qtde', 'leader', 'role', 'church_id', 'feeds'));
    }

    public function newFeed($feed_notif, $text, $link = null, $expires_in = null)
    {
        $result = $this->feedServices->newFeed($feed_notif, $text, $link, $expires_in);

        return json_encode($result);
    }
}
