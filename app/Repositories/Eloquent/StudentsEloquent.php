<?php

namespace Teachat\Repositories\Eloquent;

use Teachat\Models\Students;
use Teachat\Repositories\Interfaces\StudentsInterface;

class StudentsEloquent implements StudentsInterface
{
    /**
     * @var Students
     */
    private $students;

    /**
     * @param Students $students
     */
    public function __construct(Students $students)
    {
        $this->students = $students;
    }

    /**
     * Get Students
     *
     * @return Students
     */
    public function get()
    {
        return $this->students;
    }

    /**
     * Get students by id
     *
     * @param int $id
     * @return Students
     */
    public function getById($id)
    {
        return $this->students->find($id);
    }

    /**
     * Get studentss by id with relationships
     *
     * @param int $id
     * @param array $relations
     * @return Students
     */
    public function getByIdWithRelations($id, array $relations)
    {
        return $this->students->with($relations)->find($id);
    }

    /**
     * Get students by id with relationships and attributes
     *
     * @param int $id
     * @param array $relations
     * @param array $conditions
     * @return Students
     */
    public function getByIdWithRelationsAndAttributes($id, array $relations, array $conditions)
    {
        return $this->students->with($relations)->where($conditions)->find($id);
    }

    /**
     * Get students by attributes
     *
     * @param array $attributes
     * @param array $conditions
     * @return Students
     */
    public function getByAttributes(array $attributes, array $conditions = [])
    {
        if ($students = $this->students->where($attributes)->first()) {
            return $students->toArray();
        }

        return false;
    }

    /**
     * Get students by attributes
     *
     * @param array $attributes
     * @param array $conditions
     * @return Students
     */
    public function getByAttributesFirst(array $attributes, array $conditions = [])
    {
        return $this->students->where($attributes)->first();
    }

    /**
     * Get all students by attributes
     *
     * @param array $attributes
     * @param string $orderBy
     * @param string $sort
     * @return Grades
     */
    public function getAllByAttributes(array $attributes, $orderBy = '', $sort = 'ASC')
    {
        return $this->students->where($attributes)->orderBy($orderBy, $sort)->get()->toArray();
    }

    /**
     * Get all Curriculum by attributes with relationships
     *
     * @param array $attributes
     * @param array $relations
     * @param string $orderBy
     * @param string $sort
     * @return Curriculum
     */
    public function getAllByAttributesWithRelations(array $attributes, array $relations, $orderBy = '', $sort = 'ASC')
    {
        return $this->students->with($relations)->where($attributes)->orderBy($orderBy, $sort)->get()->toArray();
    }

    /**
     * Get all Curriculum by attributes with relationships
     *
     * @param array $attributes
     * @return Curriculum
     */
    public function getCustom(array $attributes)
    {
        return $this->students
            ->with('teacher')
            ->with(['curriculum' => function ($query) {
                $query->select('id', 'subject_category_id', 'subject');
                $query->with(['subjectCategory' => function ($query) {
                    $query->select('id', 'description');
                }]);
            }])
            ->where($attributes)
            ->get()
            ->toArray();
    }

    /**
     * Create a new students.
     *
     * @param array $payload
     * @return Students
     */
    public function create(array $payload)
    {
        return $this->students->create($payload);
    }

    /**
     * Update a certain students.
     *
     * @param int $id
     * @param array $payload
     * @return boolean
     */
    public function update($id, array $payload)
    {
        return $this->students->find($id)->update($payload);
    }

    /**
     * Update a certain student by attributes.
     *
     * @param array $payload
     * @param array $update_fields
     * @return boolean
     */
    public function updateByAttributes(array $attributes, array $update_fields)
    {
        return $this->students->where($attributes)->update($update_fields);
    }

    /**
     * Delete a certain student.
     *
     * @param int $id
     * @return boolean
     */
    public function delete($id)
    {
        return $this->students->find($id)->delete();
    }
}
