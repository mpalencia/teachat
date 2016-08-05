<?php

namespace Teachat\Repositories\Interfaces;

use Teachat\Models\Grades;
use Teachat\Repositories\Interfaces\GradesInterface;

interface GradesInterface
{
    /**
     * @param Grades $grades
     */
    public function __construct(Grades $grades);

    /**
     * Get Grades by id
     *
     * @param int $id
     * @return Grades
     */
    public function getById($id);

    /**
     * Get all grades.
     *
     * @return Grades
     */
    public function getAll();

    /**
     * Get Grades by attributes
     *
     * @param array $attributes
     * @return Grades
     */
    public function getByIdAndAttributes(array $attributes);

    /**
     * Get Grades by attributes
     *
     * @param array $attributes
     * @param array $conditions
     * @return Grades
     */
    public function getByAttributes(array $attributes, array $conditions = []);

    /**
     * Get all Grades by attributes
     *
     * @param array $attributes
     * @param string $orderBy
     * @param string $sort
     * @return Grades
     */
    public function getAllByAttributes(array $attributes, $orderBy = '', $sort = 'ASC');

    /**
     * Create a new grades.
     *
     * @param array $payload
     * @return Grades
     */
    public function create(array $payload);

    /**
     * Update a certain grade.
     *
     * @param int $id
     * @param array $payload
     * @return boolean
     */
    public function update($id, array $payload);

    /**
     * Delete a certain grade.
     *
     * @param int $id
     * @return boolean
     */
    public function delete($id);
}
