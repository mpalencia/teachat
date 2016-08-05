<?php

namespace Teachat\Repositories\Eloquent;

use Teachat\Models\Grades;
use Teachat\Repositories\Interfaces\GradesInterface;

class GradesEloquent implements GradesInterface
{
    /**
     * @var Grades
     */
    private $grades;

    /**
     * @param Grades $grades
     */
    public function __construct(Grades $grades)
    {
        $this->grades = $grades;
    }

    /**
     * Get Grades by id
     *
     * @param int $id
     * @return Grades
     */
    public function getById($id)
    {
        return $this->grades->find($id)->toArray();
    }

    /**
     * Get all grades.
     *
     * @return Grades
     */
    public function getAll()
    {
        return $this->grades->get()->toArray();
    }

    /**
     * Get Grades by attributes
     *
     * @param array $attributes
     * @return Grades
     */
    public function getByIdAndAttributes(array $attributes)
    {
        if ($grades = $this->grades->where($attributes)->first()) {
            return $grades;
        }

        return false;
    }

    /**
     * Get Grades by attributes
     *
     * @param array $attributes
     * @param array $conditions
     * @return Grades
     */
    public function getByAttributes(array $attributes, array $conditions = [])
    {
        if ($grades = $this->grades->where($attributes)->first()) {
            return $grades->toArray();
        }

        return false;
    }

    /**
     * Get all Grades by attributes
     *
     * @param array $attributes
     * @param string $orderBy
     * @param string $sort
     * @return Grades
     */
    public function getAllByAttributes(array $attributes, $orderBy = '', $sort = 'ASC')
    {
        return $this->grades->where($attributes)->orderBy($orderBy, $sort)->get()->toArray();
    }

    /**
     * Create a new grades.
     *
     * @param array $payload
     * @return Grades
     */
    public function create(array $payload)
    {
        return $this->grades->create($payload);
    }

    /**
     * Update a certain grade.
     *
     * @param int $id
     * @param array $payload
     * @return boolean
     */
    public function update($id, array $payload)
    {
        return $this->grades->find($id)->update($payload);
    }

    /**
     * Delete a certain grade.
     *
     * @param int $id
     * @return boolean
     */
    public function delete($id)
    {
        return $this->grades->find($id)->delete();
    }
}
