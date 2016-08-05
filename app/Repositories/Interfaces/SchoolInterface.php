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
     * Get all schools and their status
     *
     * @return School
     */
    public function getAllSchool();

    /**
     * Get all schools with limit
     *
     * @return School
     */
    public function getAllWithLimit();

    /**
     * Get all Announcements by attributes
     *
     * @param array $attributes
     * @return Announcements
     */
    public function getAllByAttributes(array $attributes);

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
