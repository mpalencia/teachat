<?php

namespace Teachat\Repositories\Eloquent;

use Teachat\Models\StateUs;
use Teachat\Repositories\Interfaces\StateUsInterface;

class StateUsEloquent implements StateUsInterface
{
    /**
     * @var StateUs
     */
    private $stateUs;

    /**
     * @param StateUs $stateUs
     */
    public function __construct(StateUs $stateUs)
    {
        $this->stateUs = $stateUs;
    }

    /**
     * Get all states
     *
     * @return StateUs
     */
    public function getAll()
    {
        return $this->stateUs->orderBy('state_name')->get()->toArray();
    }

    /**
     * Get stateUss by id
     *
     * @param int $id
     * @return StateUs
     */
    public function getById($id)
    {
        return $this->stateUs->find($id)->toArray();
    }

    /**
     * Get stateUss by attributes
     *
     * @param array $attributes
     * @param array $conditions
     * @return StateUs
     */
    public function getByAttributes(array $attributes, array $conditions = [])
    {
        return $this->stateUs->where($attributes)->first()->toArray();
    }

    /**
     * Update a certain stateUs.
     *
     * @param int $id
     * @param array $payload
     * @return boolean
     */
    public function update($id, array $payload)
    {
        return $this->stateUs->find($id)->update($payload);
    }
}
