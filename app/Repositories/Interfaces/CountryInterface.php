<?php

namespace Teachat\Repositories\Interfaces;

use Teachat\Models\Country;

interface CountryInterface
{
    /**
     * Get all country
     *
     * @return country
     */
    public function getAll();

    /**
     * Get country by id
     *
     * @param int $id
     * @return country
     */
    public function getById($id);

    /**
     * Get country by attributes
     *
     * @param array $attributes
     * @param array $conditions
     * @return country
     */
    public function getByAttributes(array $attributes, array $conditions = []);

    /**
     * Get country by all attributes
     *
     * @param array $attributes
     * @param array $conditions
     * @return country
     */
    public function getAllByAttributes(array $attributes, $orderBy = '', $sort = 'ASC');

    /**
     * Update a certain country.
     *
     * @param int $id
     * @param array $payload
     * @return boolean
     */
    public function update($id, array $payload);

}
