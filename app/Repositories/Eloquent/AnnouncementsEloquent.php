<?php

namespace Teachat\Repositories\Eloquent;

use Teachat\Models\Announcements;
use Teachat\Repositories\Interfaces\AnnouncementsInterface;
use Carbon\Carbon;

class AnnouncementsEloquent implements AnnouncementsInterface
{
    /**
     * @var Announcements
     */
    private $announcements;

    /**
     * @param Announcements $announcements
     */
    public function __construct(Announcements $announcements)
    {
        $this->announcements = $announcements;
    }

    /**
     * Get Announcements by id
     *
     * @param int $id
     * @return Announcements
     */
    public function get($id)
    {
        return $this->announcements
            ->select('announcement.*', 'users.*')
            ->join('users', 'announcement.user_id', '=', 'users.id')
            ->where('announcement.id', '=', $id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
    }

    /**
     * Get Announcements by id
     *
     * @param int $id
     * @param boolean $toArray
     * @return Announcements
     */
    public function getById($id, $toArray = true)
    {
        if ($toArray) {
            return $this->announcements->find($id)->toArray();
        }

        return $this->announcements->find($id);
    }

    /**
     * Get Announcement by id with relationships
     *
     * @param integer $id
     * @param array $relations
     * @return Announcements
     */
    public function getByIdWithRelations($id, array $relations)
    {
        return $this->announcements->with($relations)->find($id);

    }

    /**
     * Get all announcements by attributes with conditions
     *
     * @return Announcements
     */
    public function getByAttributesWithCondition()
    {
        return $this->announcements;
    }

    /**
     * Get Announcements by attributes
     *
     * @param array $attributes
     * @param array $conditions
     * @return Announcements
     */
    public function getByAttributes(array $attributes, array $conditions = [])
    {
        if ($announcements = $this->announcements->where($attributes)->first()) {
            return $announcements->toArray();
        }

        return false;
    }

    /**
     * Get all Announcements by attributes
     *
     * @param array $attributes
     * @param string $orderBy
     * @param string $sort
     * @return Announcements
     */
    public function getAllByAttributes(array $attributes, $orderBy = '', $sort = 'ASC')
    {
        return $this->announcements->where($attributes)->orderBy($orderBy, $sort)->get()->toArray();
    }

    /**
     * Get all Announcements by attributes with relationships
     *
     * @param array $attributes
     * @param array $relations
     * @param string $orderBy
     * @param string $sort
     * @return Announcements
     */
    public function getAllByAttributesWithRelations(array $attributes, array $relations, $orderBy = '', $sort = 'ASC', $condition = '')
    {
        $announcements = $this->announcements->with($relations)->where($attributes)->orderBy($orderBy, $sort);

        // if ($conditions != '') {
        //     $announcements = $announcements->whereNotNull('action');
        // }

        return $announcements->get()->toArray();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $role_id
     * @param  int  $school_id
     * @return Response
     */
    public function getDashboardAnnoucements($role_id, $school_id)
    {   
        $new_carbon = date("Y-m-d");


        if ($role_id == 2) {
            $rona= $this->announcements
                ->where('school_id', $school_id)
                ->where('expiration_date', '>=', $new_carbon)
                ->where('publish_on', '<=', $new_carbon)
                ->whereIn('announce_to', [1, 2])
                ->orderBy('created_at', 'desc')
                ->get()
                ->toArray();
        }

        if ($role_id == 4) {
            return $this->announcements
                ->where('school_id', $school_id)
                ->where('expiration_date', '>=', $new_carbon)
                ->where('publish_on', '<=', $new_carbon)
                ->whereIn('announce_to', [1, 2, 3])
                ->orderBy('created_at', 'desc')
                ->get()
                ->toArray();
        }

        return $this->announcements
            ->where('school_id', $school_id)
            ->where('expiration_date', '>=', $new_carbon)
            ->where('publish_on', '<=', $new_carbon)
            ->whereIn('announce_to', [1, $role_id])
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
    }

    /**
     * Create a new announcements.
     *
     * @param array $payload
     * @return Announcements
     */
    public function create(array $payload)
    {
        return $this->announcements->create($payload);
    }

    /**
     * Update a certain announcement.
     *
     * @param int $id
     * @param array $payload
     * @return boolean
     */
    public function update($id, array $payload)
    {
        return $this->announcements->find($id)->update($payload);
    }

    /**
     * Update a certain announcement by attributes.
     *
     * @param array $payload
     * @param array $attributes
     * @return boolean
     */
    public function updateByAttributes(array $attributes, array $payload)
    {
        return $this->announcements->where($attributes)->update($payload);
    }

    /**
     * Delete a certain announcement.
     *
     * @param int $id
     * @return boolean
     */
    public function delete($id)
    {
        return $this->announcements->find($id)->delete();
    }

    /**
     * Get Announcements by id
     *
     * @param int $id
     * @return Announcements
     */
    public function gets()
    {
        return $this->announcements;
    }
}
