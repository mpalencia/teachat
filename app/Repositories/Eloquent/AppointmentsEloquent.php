<?php

namespace Teachat\Repositories\Eloquent;

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
     * @return Appointments
     */
    public function getAllByAttributesWithRelations(array $attributes, array $relations, $orderBy = '', $sort = 'ASC')
    {
        return $this->appointments->with($relations)->where($attributes)->orderBy($orderBy, $sort)->get()->toArray();
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
    public function getAppointmentsToday($id, $date)
    {
        return DB::table('appointment')->select('appointment.id as Appt_id', 'appointment.*', 'users.*')
            ->join('users', 'appointment.parent_id', '=', 'users.id')
            ->where('appointment.teacher_id', '=', $id)
            ->where('appointment.appt_date', '=', $date)
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
