<?php

namespace Teachat\Repositories\Interfaces;

use Teachat\Models\User;

interface UserInterface
{

    /**
     * Get users by id
     *
     * @param int $id
     * @return User
     */
    public function getById($id);

    /**
     * Get Appointments where in.
     *
     * @param array $whereIn
     * @param array $attributes
     * @return Appointments
     */
    public function getAppointmentsWhereIn(array $school_ids);

    /**
     * Get users by id with relationships
     *
     * @param int $id
     * @param array $relations
     * @return User
     */
    public function getByIdWithRelations($id, array $relations);

    /**
     * Get users by attributes
     *
     * @param array $attributes
     * @param array $conditions
     * @return User
     */

    public function getByAttributes(array $attributes, array $conditions = []);

    /**
     * Get all user by attributes
     *
     * @param array $relations
     * @param array $attributes
     * @param string $orderBy
     * @param string $sort
     * @return Grades
     */
    public function getAllByAttributesWithRelations(array $relations, array $attributes, $orderBy = '', $sort = 'ASC');

    /**
     * Get users by id with relations
     *
     * @param array $attributes
     * @param array $conditions
     * @return User
     */
    public function getByIdWithRelationsAndAttributes($id, array $relations, array $conditions);

    /**
     * Get users by attributes
     *
     * @param array $attributes
     * @return User
     */
    public function getByAttributesFirst(array $attributes);

    /**
     * Get all user by attributes
     *
     * @param array $attributes
     * @param string $orderBy
     * @param string $sort
     * @return Grades
     */
    public function getAllByAttributes(array $attributes, $orderBy = '', $sort = 'ASC');

    /**
     * Create a new user.
     *
     * @param array $payload
     * @return User
     */
    public function create(array $payload);

    /**
     * Update a certain user.
     *
     * @param int $id
     * @param array $payload
     * @return boolean
     */
    public function update($id, array $payload);

    /**
     * Update a certain user by attributes.
     *
     * @param array $payload
     * @param array $update_fields
     * @return boolean
     */
    public function updateByAttributes(array $attributes, array $update_fields);

    /**
     * Delete a certain user.
     *
     * @param int $id
     * @return boolean
     */
    public function delete($id);

    /**
     * Get All parents associated with teacher.
     *
     * @param integer $teacher_id
     * @return User
     */
    public function getParentsByStudent($teacher_id);

    /**
     * Get all teachers associated with parent's children.
     *
     * @param integer $teacher_id
     * @return User
     */
    public function getTeachersByChild($parent_id);
}
