<?php

namespace Teachat\Repositories\Eloquent;

use Teachat\Models\Children;
use Teachat\Repositories\Interfaces\ChildrenInterface;

class ChildrenEloquent implements ChildrenInterface
{
    /**
     * @var Children
     */
    private $children;

    /**
     * @param Children $children
     */
    public function __construct(Children $children)
    {
        $this->children = $children;
    }

    /**
     * Get children by id
     *
     * @param int $id
     * @return Children
     */
    public function getById($id)
    {
        return $this->children->find($id);
    }

    /**
     * Get childrens by id with relationships
     *
     * @param int $id
     * @param array $relations
     * @return Children
     */
    public function getByIdWithRelations($id, array $relations)
    {
        return $this->children->with($relations)->find($id);
    }

    /**
     * Get children by id with relationships and attributes
     *
     * @param int $id
     * @param array $relations
     * @param array $conditions
     * @return Children
     */
    public function getByIdWithRelationsAndAttributes($id, array $relations, array $conditions)
    {
        return $this->children->with($relations)->where($conditions)->find($id);
    }

    /**
     * Get children by attributes
     *
     * @param array $attributes
     * @param array $conditions
     * @return Children
     */
    public function getByAttributes(array $attributes, array $conditions = [])
    {
        if ($children = $this->children->where($attributes)->first()) {
            return $children->toArray();
        }

        return false;
    }

    /**
     * Get all children by attributes
     *
     * @param array $attributes
     * @param string $orderBy
     * @param string $sort
     * @return Grades
     */
    public function getAllByAttributes(array $attributes, $orderBy = '', $sort = 'ASC')
    {
        return $this->children->where($attributes)->orderBy($orderBy, $sort)->get()->toArray();
    }

    /**
     * Create a new children.
     *
     * @param array $payload
     * @return Children
     */
    public function create(array $payload)
    {
        return $this->children->create($payload);
    }

    /**
     * Update a certain children.
     *
     * @param int $id
     * @param array $payload
     * @return boolean
     */
    public function update($id, array $payload)
    {
        return $this->children->find($id)->update($payload);
    }

    /**
     * Update a certain children by attributes.
     *
     * @param array $payload
     * @param array $update_fields
     * @return boolean
     */
    public function updateByAttributes(array $attributes, array $update_fields)
    {
        return $this->children->where($attributes)->update($update_fields);
    }
}
