<?php

namespace Teachat\Repositories\Interfaces;

use Teachat\Models\SubjectCategory;

interface SubjectCategoryInterface
{

    /**
     * Get Subject Category by id
     *
     * @param int $id
     * @return SubjectCategory
     */
    public function getById($id);

    /**
     * Get Subject Category by attributes
     *
     * @param array $attributes
     * @param array $conditions
     * @return SubjectCategory
     */
    public function getByAttributes(array $attributes, array $conditions = []);

    /**
     * Get all Subject Category by attributes
     *
     * @param array $attributes
     * @param string $orderBy
     * @param string $sort
     * @return SubjectCategory
     */
    public function getAllByAttributes(array $attributes, $orderBy = '', $sort = 'ASC');

    /**
     * Create a new subjectCategory.
     *
     * @param array $payload
     * @return SubjectCategory
     */
    public function create(array $payload);

    /**
     * Update a certain subjectCategory.
     *
     * @param int $id
     * @param array $payload
     * @return boolean
     */
    public function update($id, array $payload);
}
