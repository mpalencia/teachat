<?php

namespace Teachat\Repositories\Eloquent;

use Teachat\Models\Country;
use Teachat\Repositories\Interfaces\CountryInterface;

class CountryEloquent implements CountryInterface
{
    /**
     * @var StateUs
     */
    private $country;

    /**
     * @param StateUs $stateUs
     */
    public function __construct(Country $country)
    {
        $this->country = $country;
    }

    /**
     * Get all country
     *
     * @return StateUs
     */
    public function getAll()
    {
        return $this->country->orderBy('name')->get()->toArray();
    }

    /**
     * Get country by id
     *
     * @param int $id
     * @return StateUs
     */
    public function getById($id)
    {
        return $this->country->find($id)->toArray();
    }

    /**
     * Get Country by id with relationships
     *
     * @param integer $id
     * @param array $relations
     * @return Announcements
     */
    public function getByIdWithRelations($id, array $relations)
    {
        return $this->country->with($relations)->find($id);

    }

    /**
     * Get country by attributes
     *
     * @param array $attributes
     * @param array $conditions
     * @return StateUs
     */
    public function getByAttributes(array $attributes, array $conditions = [])
    {
        return $this->country->where($attributes)->first()->toArray();
    }

    /**
     * Get country by all attributes
     *
     * @param array $attributes
     * @param array $conditions
     * @return StateUs
     */
    public function getAllByAttributes(array $attributes, $orderBy = '', $sort = 'ASC')
    {
        return $this->country->where($attributes)->orderBy($orderBy, $sort)->get()->toArray();
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
        return $this->country->with($relations)->where($attributes)->orderBy($orderBy, $sort)->get()->toArray();
    }

    /**
     * Update a certain country.
     *
     * @param int $id
     * @param array $payload
     * @return boolean
     */
    public function update($id, array $payload)
    {
        return $this->country->find($id)->update($payload);
    }
}
