<?php

namespace Teachat\Repositories\Interfaces;

use Teachat\Models\Curriculum;

interface CurriculumInterface
{
    /**
     * Get Curriculum by id
     *
     * @param int $id
     * @return Curriculum
     */
    public function getById($id);

    /**
     * Get Curriculum by attributes
     *
     * @param array $attributes
     * @param array $conditions
     * @return Curriculum
     */
    public function getByAttributes(array $attributes, array $conditions = []);

    /**
     * Get all Curriculum by attributes
     *
     * @param array $attributes
     * @param string $orderBy
     * @param string $sort
     * @return Curriculum
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
     * Create a new curriculum.
     *
     * @param array $payload
     * @return Curriculum
     */
    public function create(array $payload);

    /**
     * Update a certain curriculum.
     *
     * @param int $id
     * @param array $payload
     * @return boolean
     */
    public function update($id, array $payload);

    /**
     * Delete a certain curriculum.
     *
     * @param int $id
     * @return boolean
     */
    public function delete($id);
}
