<?php

namespace Teachat\Repositories\Interfaces;

use Teachat\Models\TeacherProfile;

interface TeacherProfileInterface
{

    /**
     * Get teacherProfiles by id
     *
     * @param int $id
     * @return TeacherProfile
     */
    public function getById($id);

    /**
     * Get Teacher Profiles by attributes
     *
     * @param array $attributes
     * @param array $conditions
     * @return TeacherProfile
     */
    public function getByAttributes(array $attributes, array $conditions = []);

    /**
     * Create a new teacher profile.
     *
     * @param array $payload
     * @return TeacherProfile
     */
    public function create(array $payload);

    /**
     * Update a certain teacher profile.
     *
     * @param int $id
     * @param array $payload
     * @return boolean
     */
    public function update($id, array $payload);

}
