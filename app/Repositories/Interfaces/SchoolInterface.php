<?php

namespace Teachat\Repositories\Interfaces;

use Teachat\Models\School;

interface SchoolInterface
{
    /**
     * Get all schools
     *
     * @return School
     */
    public function getAll();

    /**
     * Get schools by id
     *
     * @param int $id
     * @return School
     */
    public function getById($id);

    /**
     * Get schools by attributes
     *
     * @param array $attributes
     * @param array $conditions
     * @return School
     */
    public function getByAttributes(array $attributes, array $conditions = []);

    /**
     * Update a certain school.
     *
     * @param int $id
     * @param array $payload
     * @return boolean
     */
    public function update($id, array $payload);

}
