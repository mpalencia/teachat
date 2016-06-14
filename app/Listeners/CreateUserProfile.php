<?php

namespace Teachat\Listeners;

use Teachat\Events\UserWasCreated;
use Teachat\Repositories\Interfaces\TeacherProfileInterface;

class CreateUserProfile
{
    /**
     * @var TeacherProfileInterface
     */
    public $teacherProfile;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(TeacherProfileInterface $teacherProfile)
    {
        $this->teacherProfile = $teacherProfile;
    }

    /**
     * Handle the event.
     *
     * @param  UserWasCreated  $event
     * @return void
     */
    public function handle(UserWasCreated $event)
    {
        return $this->teacherProfile->create($event->request->all());
    }
}
