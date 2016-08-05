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
        return $this->school->with(['state' => function ($query) {

        }])
            ->with(['country' => function ($query) {

            }])
            ->where('active', 1)
            ->orderBy('school_name')
            ->get()
            ->toArray();
    }

    /**
     * Get all schools and their status
     *
     * @return School
     */
    public function getAllSchool()
    {
        return $this->school->with(['state' => function ($query) {

        }])
            ->with(['country' => function ($query) {

            }])
            ->orderBy('school_name')
            ->get()
            ->toArray();
    }

    /**
     * Get all schools with limit
     *
     * @return School
     */
    public function getAllWithLimit()
    {
        return $this->school->with(['state' => function ($query) {

        }])
            ->with(['country' => function ($query) {

            }])
            ->where('active', 1)
            ->orderBy('school_name')
            ->limit(10)
            ->get()
            ->toArray();
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
     * Get all Announcements by attributes
     *
     * @param array $attributes
     * @return Announcements
     */
    public function getAllByAttributes(array $attributes)
    {
        return $this->school->with('country')->where($attributes)->orderBy('school_name', 'ASC')->get()->toArray();
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
     * Get all by attribures with relations
     *
     * @param array $attributes
     * @param array $relations
     * @param string $orderBy
     * @param string $sort
     * @return User
     */
    public function getByAttributesWithRelations(array $attributes, array $relations, $orderBy = '', $sort = 'ASC')
    {
        return $this->user->with($relations)
            ->where($attributes)
            ->orderBy($orderBy)
            ->get()
            ->toArray();
    }

    /**
     * Create a school.
     *
     * @param array $payload
     * @return School
     */
    public function create(array $payload)
    {
        return $this->school->create($payload);
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

    /**
     * Delete a certain school.
     *
     * @param int $id
     * @return boolean
     */
    public function delete($id)
    {
        return $this->school->find($id)->delete();
    }
}
