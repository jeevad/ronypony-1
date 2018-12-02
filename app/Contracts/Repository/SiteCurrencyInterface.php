<?php
namespace App\Contracts\Repository;

interface SiteCurrencyInterface {


    /**
     * Find an Site currency by given Id which returns Site currency
     * 
     * @param $id
     * @return \App\SiteCurrency
     */
    public function find($id);

    /**
     * Find an Site currency by given currency code which returns Site currency
     * 
     * @param string $code
     * @return \App\SiteCurrency
     */
    public function findByCode($code);


    /**
     * Find an All Site currency which returns Eloquent Collection
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();


    /**
     * Site currency Collection with Limit which returns paginate class
     * 
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate($noOfItem = 10);



    /**
     * Site currency Query 
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query();


    /**
     * Create an Site currency
     * 
     * @param array $data
     * @return \App\AdminUser
     */
    public function create($data);

}