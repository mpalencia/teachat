<?php

namespace Teachat\Repositories\Eloquent;

use Teachat\Models\Curriculum;
use Teachat\Repositories\Interfaces\CurriculumInterface;

class CurriculumEloquent implements CurriculumInterface
{
    /**
     * @var Curriculum
     */
    private $curriculum;

    /**
     * @param Curriculum $curriculum
     */
    public function __construct(Curriculum $curriculum)
    {
        $this->curriculum = $curriculum;
    }

    /**
     * Get Curriculum by id
     *
     * @param int $id
     * @return Curriculum
     */
    public function getById($id)
    {
        return $this->curriculum->find($id)->toArray();
    }

    /**
     * Get Curriculum by attributes
     *
     * @param array $attributes
     * @param array $conditions
     * @return Curriculum
     */
    public function getByAttributes(array $attributes, array $conditions = [])
    {
        if ($curriculum = $this->curriculum->where($attributes)->first()) {
            return $curriculum->toArray();
        }

        return false;
    }

    /**
     * Get all Curriculum by attributes
     *
     * @param array $attributes
     * @param string $orderBy
     * @param string $sort
     * @return Curriculum
     */
    public function getAllByAttributes(array $attributes, $orderBy = '', $sort = 'ASC')
    {
        return $this->curriculum->where($attributes)->orderBy($orderBy, $sort)->get()->toArray();
    }

    /**
     * Get all Curriculum by attributes with relationships
     *
     * @param array $attributes
     * @param array $relations
     * @param string $orderBy
     * @param string $sort
     * @return Curriculum
     */
    public function getAllByAttributesWithRelations(array $attributes, array $relations, $orderBy = '', $sort = 'ASC')
    {
        return $this->curriculum->with($relations)->where($attributes)->orderBy($orderBy, $sort)->get()->toArray();
    }

    /**
     * Create a new curriculum.
     *
     * @param array $payload
     * @return Curriculum
     */
    public function create(array $payload)
    {
        return $this->curriculum->create($payload);
    }

    /**
     * Update a certain grade.
     *
     * @param int $id
     * @param array $payload
     * @return boolean
     */
    public function update($id, array $payload)
    {
        return $this->curriculum->find($id)->update($payload);
    }

    /**
     * Delete a certain grade.
     *
     * @param int $id
     * @return boolean
     */
    public function delete($id)
    {
        return $this->curriculum->find($id)->delete();
    }
}
