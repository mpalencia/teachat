<?php

namespace Teachat\Repositories\Eloquent;

use Teachat\Models\SubjectCategory;
use Teachat\Repositories\Interfaces\SubjectCategoryInterface;

class SubjectCategoryEloquent implements SubjectCategoryInterface
{
    /**
     * @var SubjectCategory
     */
    private $subjectCategory;

    /**
     * @param SubjectCategory $subjectCategory
     */
    public function __construct(SubjectCategory $subjectCategory)
    {
        $this->subjectCategory = $subjectCategory;
    }

    /**
     * Get Subject Category by id
     *
     * @param int $id
     * @return SubjectCategory
     */
    public function getById($id)
    {
        return $this->subjectCategory->find($id)->toArray();
    }

    /**
     * Get Subject Category by attributes
     *
     * @param array $attributes
     * @param array $conditions
     * @return SubjectCategory
     */
    public function getByAttributes(array $attributes, array $conditions = [])
    {
        if ($subjectCategory = $this->subjectCategory->where($attributes)->first()) {
            return $subjectCategory->toArray();
        }

        return false;
    }

    /**
     * Get all Subject Category by attributes
     *
     * @param array $attributes
     * @param string $orderBy
     * @param string $sort
     * @return SubjectCategory
     */
    public function getAllByAttributes(array $attributes, $orderBy = '', $sort = 'ASC')
    {
        return $this->subjectCategory->where($attributes)->orderBy($orderBy, $sort)->get()->toArray();
    }

    /**
     * Create a new subjectCategory.
     *
     * @param array $payload
     * @return SubjectCategory
     */
    public function create(array $payload)
    {
        return $this->subjectCategory->create($payload);
    }

    /**
     * Update a certain subjectCategory.
     *
     * @param int $id
     * @param array $payload
     * @return boolean
     */
    public function update($id, array $payload)
    {
        return $this->subjectCategory->find($id)->update($payload);
    }

    /**
     * Delete a certain subjectCategory.
     *
     * @param int $id
     * @return boolean
     */
    public function delete($id)
    {
        return $this->subjectCategory->find($id)->delete();
    }
}
