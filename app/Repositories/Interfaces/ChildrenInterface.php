<?php

namespace Teachat\Repositories\Interfaces;

use Teachat\Models\Children;

interface ChildrenInterface
{
    /**
     * Get children
     *
     * @return Children
     */
    public function get();

    /**
     * Get children by id
     *
     * @param int $id
     * @return Children
     */
    public function getById($id);

    /**
     * Get children by id with relationships
     *
     * @param int $id
     * @param array $relations
     * @return Children
     */
    public function getByIdWithRelations($id, array $relations);

    /**
     * Get children by id with relationships and attributes
     *
     * @param int $id
     * @param array $relations
     * @param array $conditions
     * @return Children
     */
    public function getByIdWithRelationsAndAttributes($id, array $relations, array $conditions);

    /**
     * Get children by attributes
     *
     * @param array $attributes
     * @param array $conditions
     * @return Children
     */
    public function getByAttributes(array $attributes, array $conditions = []);

    /**
     * Get all children by attributes
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
     * Create a new child.
     *
     * @param array $payload
     * @return Children
     */
    public function create(array $payload);

    /**
     * Update a certain child.
     *
     * @param int $id
     * @param array $payload
     * @return boolean
     */
    public function update($id, array $payload);

    /**
     * Update a certain child by attributes.
     *
     * @param array $payload
     * @param array $update_fields
     * @return boolean
     */
    public function updateByAttributes(array $attributes, array $update_fields);

    /**
     * Delete a certain child.
     *
     * @param int $id
     * @return boolean
     */
    public function delete($id);
}
