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
}
