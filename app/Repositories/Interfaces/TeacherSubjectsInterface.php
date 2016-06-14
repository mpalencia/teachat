<?php

namespace Teachat\Repositories\Interfaces;

use Teachat\Models\TeacherSubjects;

interface TeacherSubjectsInterface
{
    /**
     * Get Teacher Subjects by id
     *
     * @param int $id
     * @return TeacherSubjects
     */
    public function getById($id);

    /**
     * Get Teacher Subjects by attributes
     *
     * @param array $attributes
     * @param array $conditions
     * @return TeacherSubjects
     */
    public function getByAttributes(array $attributes, array $conditions = []);

    /**
     * Get all Teacher Subjects by attributes
     *
     * @param array $attributes
     * @param string $orderBy
     * @param string $sort
     * @return TeacherSubjects
     */
    public function getAllByAttributes(array $attributes, $orderBy = '', $sort = 'ASC');

    /**
     * Get all Teacher Subjects by attributes with relationships
     *
     * @param array $attributes
     * @param array $relations
     * @param string $orderBy
     * @param string $sort
     * @return TeacherSubjects
     */
    public function getAllByAttributesWithRelations(array $attributes, array $relations, $orderBy = '', $sort = 'ASC');

    /**
     * Create a new Teacher Subjects.
     *
     * @param array $payload
     * @return TeacherSubjects
     */
    public function create(array $payload);

    /**
     * Update a certain Teacher Subject.
     *
     * @param int $id
     * @param array $payload
     * @return boolean
     */
    public function update($id, array $payload);

    /**
     * Delete a certain Teacher Subject.
     *
     * @param int $id
     * @return boolean
     */
    public function delete($id);
}
