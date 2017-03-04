<?php

namespace App\Events;

use App\Models\Person;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PersonEvent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var
     */
    public $person = [];

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Person $person)
    {
        $this->person[] = $person->id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        //dd($this->person);
        //return [$this->person->id];
        return ['my-channel'];
    }
}
