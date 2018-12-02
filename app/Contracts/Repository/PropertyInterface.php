<?php

namespace App\Contracts\Repository;

interface PropertyInterface
{
    /**
     * Find a Product Property Model of a given Id
     *
     * @param integer $id
     * @return \App\Database\Property
     */
    public function find($id);
    
    /**
     * Find an Property collection by given an array of Ids
     *
     * @param array $ids
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findMany($ids);

    /**
     * Product Property Query Builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query();

    /**
     * Product Property Query Builder
     * 
     * @param array $data
     * @return \App\Database\Property
     */
    public function create($data);
}
