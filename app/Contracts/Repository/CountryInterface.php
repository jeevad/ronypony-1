<?php

namespace App\Contracts\Repository;

interface CountryInterface
{
    /**
     * Find a Country by given Id which returns Country Model
     *
     * @param $id
     * @return \App\Country
     */
    public function find($id);

    /**
     * Find an All Countries which returns Eloquent Collection
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Country Collection with Limit which returns paginate class
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate($noOfItem = 10);

    /**
     * Country Query Builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query();

    /**
     * Create a Country
     *
     * @param array $data
     * @return \App\Country
     */
    public function create($data);

    /**
     * Get All Country Options for Dropdown Field
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function options();
}
