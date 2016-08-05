<?php

namespace Teachat\Repositories\Interfaces;

use Teachat\Models\Students;

interface StudentsInterface
{
    /**
     * Get Students
     *
     * @return Students
     */
    public function get();

    /**
     * Get students by id
     *
     * @param int $id
     * @return Students
     */
    public function getById($id);

    /**
     * Get students by id with relationships
     *
     * @param int $id
     * @param array $relations
     * @return Students
     */
    public function getByIdWithRelations($id, array $relations);

    /**
     * Get students by id with relationships and attributes
     *
     * @param int $id
     * @param array $relations
     * @param array $conditions
     * @return Students
     */
    public function getByIdWithRelationsAndAttributes($id, array $relations, array $conditions);

    /**
     * Get students by attributes
     *
     * @param array $attributes
     * @param array $conditions
     * @return Students
     */
    public function getByAttributes(array $attributes, array $conditions = []);

    /**
     * Get students by attributes
     *
     * @param array $attributes
     * @param array $conditions
     * @return Students
     */
    public function getByAttributesFirst(array $attributes, array $conditions = []);

    /**
     * Get all students by attributes
     *
     * @param array $attributes
     * @param string $orderBy
     * @param string $sort
     * @return Grades
     */
    public function getAllByAttributes(array $attributes, $orderBy = '', $sort = 'ASC');

    /**
     * Get all Curriculum by attributes with relationships
     *
     * @param array $attributes
     * @param array $relations
     * @param string $orderBy
     * @param string $sort
     * @return Curriculum
     */
    public function getAllByAttributesWithRelations(array $attributes, array $relations, $orderBy = '', $sort = 'ASC');

    /**
     * Get all Curriculum by attributes with relationships
     *
     * @param array $attributes
     * @return Curriculum
     */
    public function getCustom(array $attributes);

    /**
     * Create a new student.
     *
     * @param array $payload
     * @return Students
     */
    public function create(array $payload);

    /**
     * Update a certain student.
     *
     * @param int $id
     * @param array $payload
     * @return boolean
     */
    public function update($id, array $payload);

    /**
     * Update a certain student by attributes.
     *
     * @param array $payload
     * @param array $update_fields
     * @return boolean
     */
    public function updateByAttributes(array $attributes, array $update_fields);

    /**
     * Delete a certain student.
     *
     * @param int $id
     * @return boolean
     */
    public function delete($id);
}
