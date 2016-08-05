<?php

namespace Teachat\Repositories\Eloquent;

use Teachat\Models\Children;
use Teachat\Models\Students;
use Teachat\Models\User;
use Teachat\Repositories\Interfaces\UserInterface;

class UserEloquent implements UserInterface
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var Students
     */
    private $student;

    /**
     * @var Students
     */
    private $children;

    /**
     * @param User $user
     */
    public function __construct(User $user, Students $student, Children $children)
    {
        $this->user = $user;
        $this->student = $student;
        $this->children = $children;
    }

    /**
     * Get all by attribures with relations
     *
     * @param int $id
     * @return User
     */
    public function getByAttributesWithRelations(array $attributes, array $relations, $orderBy = '', $sort = 'ASC')
    {
        return $this->user->with($relations)
            ->where($attributes)
            ->orderBy($orderBy)
            ->get()
            ->toArray();
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

    public function getAll()
    {
        return $this->user->get()->toArray();
    }

    /**
     * Get Appointments where in.
     *
     * @param array $whereIn
     * @param array $attributes
     * @return Appointments
     */
    public function getAppointmentsWhereIn(array $school_ids)
    {
        return $this->user->whereIn('school_id', $school_ids)->where('role_id', 2)->orderBy('last_name')->get()->toArray();
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
     * Get users by attributes
     *
     * @param array $attributes
     * @return User
     */
    public function getByAttributesFirst(array $attributes)
    {
        return $this->user->where($attributes)->first();
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
     * Get all user by attributes
     *
     * @param array $relations
     * @param array $attributes
     * @param string $orderBy
     * @param string $sort
     * @return Grades
     */
    public function getAllByAttributesWithRelations(array $relations, array $attributes, $orderBy = '', $sort = 'ASC')
    {
        return $this->user->with($relations)->where($attributes)->orderBy($orderBy, $sort)->get()->toArray();
    }

    /**
     * Get user by id with relationships and attributes
     *
     * @param int $id
     * @param array $relations
     * @param array $conditions
     * @return Children
     */
    public function getByIdWithRelationsAndAttributes($id, array $relations, array $conditions)
    {
        return $this->user->with($relations)->where($conditions)->find($id);
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
     * Delete a certain user.
     *
     * @param int $id
     * @param array $payload
     * @return boolean
     */
    public function delete($id)
    {
        return $this->user->find($id)->delete();
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

    /**
     * Get All parents associated with teacher.
     *
     * @param integer $teacher_id
     * @return User
     */
    public function getParentsByStudent($teacher_id)
    {
        return \DB::table('users')
            ->select('users.id', 'users.first_name', 'users.last_name', 'users.profile_img', 'students.parent_id', 'students.teacher_id', 'students.school_id')
            ->leftJoin('students', 'users.id', '=', 'students.parent_id')
            ->orderBy('users.first_name')
            ->where(['users.role_id' => 3, 'students.school_id' => \Auth::user()->school_id, 'students.teacher_id' => \Auth::user()->id])
            ->groupBy('students.parent_id')
            ->get();
    }

    /**
     * Get all teachers associated with parent's children.
     *
     * @param integer $teacher_id
     * @return User
     */
    public function getTeachersByChild($parent_id)
    {
        return \DB::table('users')
            ->select('users.id', 'users.first_name', 'users.last_name', 'users.profile_img', 'students.parent_id', 'students.teacher_id', 'students.school_id')
            ->leftJoin('students', 'users.id', '=', 'students.teacher_id')
            ->orderBy('users.first_name')
            ->where(['users.role_id' => 2, 'students.parent_id' => $parent_id])
            ->groupBy('students.teacher_id')
            ->get();
    }

    /**
     * Get Users
     *
     * @param int $id
     * @return Announcements
     */
    public function gets()
    {
        return $this->user;
    }
}
