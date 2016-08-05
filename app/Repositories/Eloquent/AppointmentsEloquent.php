<?php

namespace Teachat\Repositories\Eloquent;

use Carbon\Carbon;
use DB;
use Teachat\Models\Appointments;
use Teachat\Repositories\Interfaces\AppointmentsInterface;

class AppointmentsEloquent implements AppointmentsInterface
{
    /**
     * @var Appointments
     */
    private $appointments;

    /**
     * @param Appointments $appointments
     */
    public function __construct(Appointments $appointments)
    {
        $this->appointments = $appointments;
    }

    /**
     * Get Appointments by id
     *
     * @param int $id
     * @return Appointments
     */
    public function getById($id)
    {
        return $this->appointments->find($id)->toArray();
    }

    /**
     * Get Appointments by id with relations.
     *
     * @param int $id
     * @param sting $role
     * @return Appointments
     */
    public function getByIdWithRelations($id, $role = 'teacher')
    {
        if ($role == 'teacher') {
            return $this->appointments->select('appointment.id as Appt_id', 'appointment.*', 'users.id', 'users.first_name', 'users.last_name', 'users.profile_img', 'users.email', 'users.role_id')
                ->join('users', 'appointment.teacher_id', '=', 'users.id')
                ->where('appointment.id', $id)
                ->get()
                ->toArray();
        }

        return $this->appointments->select('appointment.id as Appt_id', 'appointment.*', 'users.id', 'users.first_name', 'users.last_name', 'users.profile_img', 'users.email', 'users.role_id')
            ->join('users', 'appointment.parent_id', '=', 'users.id')
            ->where('appointment.id', $id)
            ->get()
            ->toArray();
    }

    /**
     * Get count of Appointments by attributes
     *
     * @param array $attributes
     * @param string $appt_stime
     * @param string $appt_etime
     * @return integer
     */
    public function getCountByAttributes(array $attributes, $appt_stime, $appt_etime)
    {
        //return $this->appointments->where($attributes)->count();
        return $this->appointments
            ->where($attributes)
            ->where('appt_stime', '<=', $appt_stime)
            ->where('appt_etime', '>=', $appt_etime)
            ->count();
    }

    /**
     * Get Appointments by attributes
     *
     * @param array $attributes
     * @param array $conditions
     * @return Appointments
     */
    public function getByAttributes(array $attributes, array $conditions = [])
    {
        if ($appointments = $this->appointments->where($attributes)->first()) {
            return $appointments->toArray();
        }

        return false;
    }

    /**
     * Get Appointments for edit page.
     *
     * @param array $attributes
     * @return Appointments
     */
    public function edit(array $attributes)
    {
        return $this->appointments
            ->with(['parent' => function ($query) {
                $query->select('id', 'first_name', 'last_name');
            }])
            ->where($attributes)
            ->first();
    }

    /**
     * Get all Appointments by attributes
     *
     * @param array $attributes
     * @param string $orderBy
     * @param string $sort
     * @return Appointments
     */
    public function getAllByAttributes(array $attributes, $orderBy = '', $sort = 'ASC')
    {
        return $this->appointments->where($attributes)->orderBy($orderBy, $sort)->get()->toArray();
    }

    /**
     * Get all Appointments by attributes with relationships
     *
     * @param array $attributes
     * @param array $relations
     * @param string $orderBy
     * @param string $sort
     * @param boolean $toArray
     * @return Appointments
     */
    public function getAllByAttributesWithRelations(array $attributes, array $relations, $orderBy = '', $sort = 'ASC', $toArray = true)
    {
        return $this->appointments->with($relations)->where($attributes)->orderBy($orderBy, $sort)->get();
    }

    /**
     * Get all activity logs.
     *
     * @param array $attributes
     * @param array $relations
     * @param string $orderBy
     * @param string $sort
     * @return Appointments
     */
    public function getActivityLogs(array $attributes, array $relations, $orderBy = '', $sort = 'ASC')
    {
        return $this->appointments->with($relations)->where($attributes)->where('appt_date', '<=', date('Y-m-d'))->orderBy($orderBy, $sort)->get();
    }

    /**
     * Get the count of Appointments
     *
     * @param int $id
     * @return Appointments
     */
    public function getCount($id)
    {
        return $this->appointments->select('appointment.*', 'appointment.id as Appt_id', 'users.*')
            ->join('users', 'appointment.parent_id', '=', 'users.id')
            ->where('appointment.teacher_id', '=', $id)
            ->where('appointment.status', '=', '0')
            ->whereNotNull('appointment.action')
            ->count();
    }

    /**
     * Get all appointments today
     *
     * @param int $id
     * @param strint $date
     * @return Appointments
     */
    public function getAppointmentsToday($id, $date, $role = 'teacher')
    {
        if ($role == 'teacher') {
            return DB::table('appointment')->select('appointment.id as Appt_id', 'appointment.*', 'users.id', 'users.first_name', 'users.last_name', 'users.profile_img')
                ->join('users', 'appointment.parent_id', '=', 'users.id')
                ->where('appointment.teacher_id', '=', $id)
                ->where('appointment.appt_date', '=', $date)
                ->get();
        }

        return DB::table('appointment')->select('appointment.id as Appt_id', 'appointment.*', 'users.id', 'users.first_name', 'users.last_name', 'users.profile_img')
            ->join('users', 'appointment.teacher_id', '=', 'users.id')
            ->where('appointment.parent_id', '=', $id)
            ->where('appointment.appt_date', '=', $date)
            ->get();
    }

    /**
     * Get all appointments today
     *
     * @param string $date
     * @param integer $user_id
     * @return Appointments
     */
    public function getTimeSchedule($date, $user_id, $role = 'teacher')
    {
        if ($role == 'teacher') {
            return $this->appointments->select('appointment.id as Appt_id', 'appointment.id', 'appointment.appt_stime', 'appointment.appt_etime', 'users.id as uid')
                ->join('users', 'appointment.teacher_id', '=', 'users.id')
                ->where('appointment.teacher_id', '=', $user_id)
                ->where('appointment.appt_date', '=', $date)
                ->get()
                ->toArray();
        }

        return $this->appointments->select('appointment.id as Appt_id', 'appointment.id', 'appointment.appt_stime', 'appointment.appt_etime', 'users.id as uid', 'users.first_name', 'users.last_name')
            ->join('users', 'appointment.teacher_id', '=', 'users.id')
            ->where('appointment.parent_id', '=', $user_id)
            ->where('appointment.appt_date', '=', $date)
            ->get()
            ->toArray();
    }

    /**
     * Get Appointments by attributes with conditions
     *
     * @param array $attributes
     * @param string $field
     * @return Appointments
     */
    public function getByAttributesByGroup(array $attributes, $field = 'parent')
    {
        return $this->appointments
            ->with([$field => function ($query) {
                $query->select('id', 'first_name', 'last_name', 'profile_img');
            }])
            ->where($attributes)
            ->where('appt_date', '>=', Carbon::now()->toDateString())
            ->orderBy('appt_date')
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->appt_date)->format('Y-m-d');
            })
            ->toArray();
    }

    /**
     * Get Appointments by attributes with conditions
     *
     * @param array $attributes
     * @return Appointments
     */
    public function getAllByAttributesWithConditions(array $attributes)
    {
        return DB::table('appointment')
            ->where($attributes)
            ->where('appt_date', '>=', Carbon::now()->toDateString())
            ->get();
    }

    /**
     * Create a new appointments.
     *
     * @param array $payload
     * @return Appointments
     */
    public function create(array $payload)
    {
        return $this->appointments->create($payload);
    }

    /**
     * Update a certain appointment.
     *
     * @param int $id
     * @param array $payload
     * @return boolean
     */
    public function update($id, array $payload)
    {
        return $this->appointments->find($id)->update($payload);
    }

    /**
     * Update a certain appointment by attributes.
     *
     * @param int $id
     * @param array $payload
     * @return boolean
     */
    public function updateByAttributes(array $attributes, array $payload)
    {
        return $this->appointments->where($attributes)->update($payload);
    }

    /**
     * Delete a certain appointment.
     *
     * @param int $id
     * @return boolean
     */
    public function delete($id)
    {
        return $this->appointments->find($id)->delete();
    }
}
