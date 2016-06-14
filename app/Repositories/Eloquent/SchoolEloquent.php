<?php

namespace Teachat\Repositories\Eloquent;

use Teachat\Models\School;
use Teachat\Repositories\Interfaces\SchoolInterface;

class SchoolEloquent implements SchoolInterface
{
    /**
     * @var School
     */
    private $school;

    /**
     * @param School $school
     */
    public function __construct(School $school)
    {
        $this->school = $school;
    }

    /**
     * Get all schools
     *
     * @return School
     */
    public function getAll()
    {
        return $this->school->orderBy('school_name')->get()->toArray();
    }

    /**
     * Get schools by id
     *
     * @param int $id
     * @return School
     */
    public function getById($id)
    {
        return $this->school->find($id)->toArray();
    }

    /**
     * Get schools by attributes
     *
     * @param array $attributes
     * @param array $conditions
     * @return School
     */
    public function getByAttributes(array $attributes, array $conditions = [])
    {
        return $this->school->where($attributes)->first()->toArray();
    }

    /**
     * Update a certain school.
     *
     * @param int $id
     * @param array $payload
     * @return boolean
     */
    public function update($id, array $payload)
    {
        return $this->school->find($id)->update($payload);
    }
}
