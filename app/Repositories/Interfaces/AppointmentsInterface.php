<?php

namespace Teachat\Repositories\Interfaces;

use Teachat\Models\Appointments;

interface AppointmentsInterface
{
    /**
     * Get Appointments by id
     *
     * @param int $id
     * @return Appointments
     */
    public function getById($id);

    /**
     * Get Appointments by id with relations.
     *
     * @param int $id
     * @param sting $role
     * @return Appointments
     */
    public function getByIdWithRelations($id, $role = 'teacher');

    /**
     * Get count of Appointments by attributes
     *
     * @param array $attributes
     * @param string $appt_stime
     * @param string $appt_etime
     * @return integer
     */
    public function getCountByAttributes(array $attributes, $appt_stime, $appt_etime);

    /**
     * Get Appointments by attributes
     *
     * @param array $attributes
     * @param array $conditions
     * @return Appointments
     */
    public function getByAttributes(array $attributes, array $conditions = []);

    /**
     * Get Appointments for edit page.
     *
     * @param array $attributes
     * @return Appointments
     */
    public function edit(array $attributes);

    /**
     * Get all Appointments by attributes
     *
     * @param array $attributes
     * @param string $orderBy
     * @param string $sort
     * @return Appointments
     */
    public function getAllByAttributes(array $attributes, $orderBy = '', $sort = 'ASC');

    /**
     * Get all activity logs.
     *
     * @param array $attributes
     * @param array $relations
     * @param string $orderBy
     * @param string $sort
     * @return Appointments
     */
    public function getActivityLogs(array $attributes, array $relations, $orderBy = '', $sort = 'ASC');

    /**
     * Get all appointments today
     *
     * @param string $date
     * @param integer $user_id
     * @return Appointments
     */
    public function getTimeSchedule($date, $user_id, $role = 'teacher');

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
    public function getAllByAttributesWithRelations(array $attributes, array $relations, $orderBy = '', $sort = 'ASC', $toArray = true);

    /**
     * Get the count of Appointments
     *
     * @return Appointments
     */
    public function getCount($id);

    /**
     * Get all appointments today
     *
     * @param int $id
     * @param strint $date
     * @return Appointments
     */
    public function getAppointmentsToday($id, $date);

    /**
     * Get Appointments by attributes with conditions
     *
     * @param array $attributes
     * @param string $field
     * @return Appointments
     */
    public function getByAttributesByGroup(array $attributes, $field = 'parent');

    /**
     * Get Appointments by attributes with conditions
     *
     * @param array $attributes
     * @return Appointments
     */
    public function getAllByAttributesWithConditions(array $attributes);

    /**
     * Create a new appointment.
     *
     * @param array $payload
     * @return Appointments
     */
    public function create(array $payload);

    /**
     * Update a certain announcement.
     *
     * @param int $id
     * @param array $payload
     * @return boolean
     */
    public function update($id, array $payload);

    /**
     * Update a certain appointment by attributes.
     *
     * @param int $id
     * @param array $payload
     * @return boolean
     */
    public function updateByAttributes(array $attributes, array $payload);

    /**
     * Delete a certain announcement.
     *
     * @param int $id
     * @return boolean
     */
    public function delete($id);
}
