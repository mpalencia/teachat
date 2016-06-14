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
     * Get Appointments by attributes
     *
     * @param array $attributes
     * @param array $conditions
     * @return Appointments
     */
    public function getByAttributes(array $attributes, array $conditions = []);

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
     * Get all Appointments by attributes with relationships
     *
     * @param array $attributes
     * @param array $relations
     * @param string $orderBy
     * @param string $sort
     * @return Appointments
     */
    public function getAllByAttributesWithRelations(array $attributes, array $relations, $orderBy = '', $sort = 'ASC');

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
