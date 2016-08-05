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
     * Get all states
     *
     * @return StateUs
     */
    public function getAllWithRelations(array $relations, $orderBy = '', $sort = 'ASC')
    {
        return $this->stateUs->with($relations)->orderBy($orderBy, $sort)->get()->toArray();
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
     * Get stateUss by attributes
     *
     * @param array $attributes
     * @return StateUs
     */
    public function getAllByAttributes(array $attributes)
    {
        return $this->stateUs->where($attributes)->orderBy('state_name')->get()->toArray();
    }


    /**
     * Get all stateus by attributes with relationships
     *
     * @param array $attributes
     * @param array $relations
     * @param string $orderBy
     * @param string $sort
     * @return Curriculum
     */
    public function getAllByAttributesWithRelations(array $attributes, array $relations, $orderBy = '', $sort = 'ASC')
    {
        return $this->stateUs->with($relations)->where($attributes)->orderBy($orderBy, $sort)->get()->toArray();
    }

    /**
     * Get children by attributes first
     *
     * @param array $attributes
     * @return User
     */
    public function getByAttributesFirst(array $attributes)
    {
        return $this->stateUs->where($attributes)->first();
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

    /**
     * Create a new state.
     *
     * @param array $payload
     * @return User
     */
    public function create(array $payload)
    {
        return $this->stateUs->create($payload);
    }

    /**
     * Delete a certain state.
     *
     * @param int $id
     * @return boolean
     */
    public function delete($id)
    {
        return $this->stateUs->find($id)->delete();
    }
}
