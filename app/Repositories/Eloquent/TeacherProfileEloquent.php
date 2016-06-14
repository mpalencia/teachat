<?php

namespace Teachat\Repositories\Eloquent;

use Teachat\Models\TeacherProfile;
use Teachat\Repositories\Interfaces\TeacherProfileInterface;

class TeacherProfileEloquent implements TeacherProfileInterface
{
    /**
     * @var TeacherProfile
     */
    private $teacherProfile;

    /**
     * @param TeacherProfile $teacherProfile
     */
    public function __construct(TeacherProfile $teacherProfile)
    {
        $this->teacherProfile = $teacherProfile;
    }

    /**
     * Get teacherProfiles by id
     *
     * @param int $id
     * @return TeacherProfile
     */
    public function getById($id)
    {
        return $this->teacherProfile->find($id)->toArray();
    }

    /**
     * Get Teacher Profiles by attributes
     *
     * @param array $attributes
     * @param array $conditions
     * @return TeacherProfile
     */
    public function getByAttributes(array $attributes, array $conditions = [])
    {
        if ($teacherProfile = $this->teacherProfile->where($attributes)->first()) {
            return $teacherProfile->toArray();
        }

        return false;
    }

    /**
     * Create a new teacher profile.
     *
     * @param array $payload
     * @return TeacherProfile
     */
    public function create(array $payload)
    {
        return $this->teacherProfile->create($payload);
    }

    /**
     * Update a certain teacher profile.
     *
     * @param int $id
     * @param array $payload
     * @return boolean
     */
    public function update($id, array $payload)
    {
        return $this->teacherProfile->find($id)->update($payload);
    }
}
