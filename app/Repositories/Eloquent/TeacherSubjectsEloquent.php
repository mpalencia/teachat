<?php

namespace Teachat\Repositories\Eloquent;

use Teachat\Models\TeacherSubjects;
use Teachat\Repositories\Interfaces\TeacherSubjectsInterface;

class TeacherSubjectsEloquent implements TeacherSubjectsInterface
{
    /**
     * @var TeacherSubjects
     */
    private $teacherSubjects;

    /**
     * @param TeacherSubjects $teacherSubjects
     */
    public function __construct(TeacherSubjects $teacherSubjects)
    {
        $this->teacherSubjects = $teacherSubjects;
    }

    /**
     * Get TeacherSubjects by id
     *
     * @param int $id
     * @return TeacherSubjects
     */
    public function getById($id)
    {
        return $this->teacherSubjects->find($id)->toArray();
    }

    /**
     * Get Teacher Subjects by attributes
     *
     * @param array $attributes
     * @param array $conditions
     * @return TeacherSubjects
     */
    public function getByAttributes(array $attributes, array $conditions = [])
    {
        if ($teacherSubjects = $this->teacherSubjects->where($attributes)->first()) {
            return $teacherSubjects->toArray();
        }

        return false;
    }

    /**
     * Get all Teacher Subjects by attributes
     *
     * @param array $attributes
     * @param string $orderBy
     * @param string $sort
     * @return TeacherSubjects
     */
    public function getAllByAttributes(array $attributes, $orderBy = '', $sort = 'ASC')
    {
        return $this->teacherSubjects->where($attributes)->orderBy($orderBy, $sort)->get()->toArray();
    }

    /**
     * Get all Teacher Subjects by attributes with relationships
     *
     * @param array $attributes
     * @param array $relations
     * @param string $orderBy
     * @param string $sort
     * @return TeacherSubjects
     */
    public function getAllByAttributesWithRelations(array $attributes, array $relations, $orderBy = '', $sort = 'ASC')
    {
        return $this->teacherSubjects->with($relations)->where($attributes)->orderBy($orderBy, $sort)->get()->toArray();
    }

    /**
     * Create a new Teacher Subject.
     *
     * @param array $payload
     * @return TeacherSubjects
     */
    public function create(array $payload)
    {
        return $this->teacherSubjects->create($payload);
    }

    /**
     * Update a certain teacher subject.
     *
     * @param int $id
     * @param array $payload
     * @return boolean
     */
    public function update($id, array $payload)
    {
        return $this->teacherSubjects->find($id)->update($payload);
    }

    /**
     * Delete a certain teacher subject.
     *
     * @param int $id
     * @return boolean
     */
    public function delete($id)
    {
        return $this->teacherSubjects->find($id)->delete();
    }
}
