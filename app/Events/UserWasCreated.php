<?php

namespace Teachat\Events;

use Illuminate\Queue\SerializesModels;
use Teachat\Events\Event;

class UserWasCreated extends Event
{
    use SerializesModels;
    /**
     * @var RegisterRequest
     */
    public $request;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
