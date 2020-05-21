<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CoronaWeeklyEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

     public $data;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * [broadcastWith description]
     * @return [type] [description]
     */
     public function broadcastWith()
    {
        // This must always be an array. Since it will be parsed with json_encode()
        return [
            'data' => $this->data,
        ];
    }

    /**
     * [broadcastAs description]
     * @return [type] [description]
     */
    public function broadcastAs()
    {
        return 'corona.weekly';
    }

    /**
     * [broadcastOn description]
     * @return [type] [description]
     */
    public function broadcastOn()
    {
        return new Channel('daily');
    }
}
