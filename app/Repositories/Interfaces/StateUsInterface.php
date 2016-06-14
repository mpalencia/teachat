<?php

namespace Teachat\Repositories\Interfaces;

use Teachat\Models\StateUs;

interface StateUsInterface
{
    /**
     * Get all states
     *
     * @return StateUs
     */
    public function getAll();

    /**
     * Get stateUss by id
     *
     * @param int $id
     * @return StateUs
     */
    public function getById($id);

    /**
     * Get stateUss by attributes
     *
     * @param array $attributes
     * @param array $conditions
     * @return StateUs
     */
    public function getByAttributes(array $attributes, array $conditions = []);

    /**
     * Update a certain stateUs.
     *
     * @param int $id
     * @param array $payload
     * @return boolean
     */
    public function update($id, array $payload);

}
