<?php

namespace Teachat\Repositories\Interfaces;

use Teachat\Models\Announcements;

interface AnnouncementsInterface
{
    /**
     * Get Announcements by id
     *
     * @param int $id
     * @return Announcements
     */
    public function get($id);

    /**
     * Get Announcements by id
     *
     * @param int $id
     * @param boolean $toArray
     * @return Announcements
     */
    public function getById($id, $toArray);

    /**
     * Get Announcement by id with relationships
     *
     * @param integer $id
     * @param array $relations
     * @return Announcements
     */
    public function getByIdWithRelations($id, array $relations);

    /**
     * Get all announcements by attributes with conditions
     *
     * @return Announcements
     */
    public function getByAttributesWithCondition();

    /**
     * Get Announcements by attributes
     *
     * @param array $attributes
     * @param array $conditions
     * @return Announcements
     */
    public function getByAttributes(array $attributes, array $conditions = []);

    /**
     * Get all Announcements by attributes
     *
     * @param array $attributes
     * @param string $orderBy
     * @param string $sort
     * @return Announcements
     */
    public function getAllByAttributes(array $attributes, $orderBy = '', $sort = 'ASC');

    /**
     * Get all Announcements by attributes with relationships
     *
     * @param array $attributes
     * @param array $relations
     * @param string $orderBy
     * @param string $sort
     * @return Announcements
     */
    public function getAllByAttributesWithRelations(array $attributes, array $relations, $orderBy = '', $sort = 'ASC', $condition = '');

    /**
     * Display the specified resource.
     *
     * @param  int  $role_id
     * @param  int  $school_id
     * @return Response
     */
    public function getDashboardAnnoucements($role_id, $school_id);

    /**
     * Create a new announcements.
     *
     * @param array $payload
     * @return Announcements
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
     * Update a certain announcement by attributes.
     *
     * @param array $payload
     * @param array $attributes
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
