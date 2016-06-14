<?php

namespace Teachat\Repositories\Eloquent;

use Teachat\Models\User;
use Teachat\Repositories\Interfaces\UserInterface;

class UserEloquent implements UserInterface
{
    /**
     * @var User
     */
    private $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get users by id
     *
     * @param int $id
     * @return User
     */
    public function getById($id)
    {
        return $this->user->find($id)->toArray();
    }

    /**
     * Get users by id with relationships
     *
     * @param int $id
     * @param array $relations
     * @return User
     */
    public function getByIdWithRelations($id, array $relations)
    {
        return $this->user->with($relations)->find($id);
    }

    /**
     * Get users by attributes
     *
     * @param array $attributes
     * @param array $conditions
     * @return User
     */
    public function getByAttributes(array $attributes, array $conditions = [])
    {
        if ($user = $this->user->where($attributes)->first()) {
            return $user->toArray();
        }

        return false;
    }

    /**
     * Get all user by attributes
     *
     * @param array $attributes
     * @param string $orderBy
     * @param string $sort
     * @return Grades
     */
    public function getAllByAttributes(array $attributes, $orderBy = '', $sort = 'ASC')
    {
        return $this->user->where($attributes)->orderBy($orderBy, $sort)->get()->toArray();
    }

    /**
     * Create a new user.
     *
     * @param array $payload
     * @return User
     */
    public function create(array $payload)
    {
        return $this->user->create($payload);
    }

    /**
     * Update a certain user.
     *
     * @param int $id
     * @param array $payload
     * @return boolean
     */
    public function update($id, array $payload)
    {
        return $this->user->find($id)->update($payload);
    }

    /**
     * Update a certain user by attributes.
     *
     * @param array $payload
     * @param array $update_fields
     * @return boolean
     */
    public function updateByAttributes(array $attributes, array $update_fields)
    {
        return $this->user->where($attributes)->update($update_fields);
    }
}
