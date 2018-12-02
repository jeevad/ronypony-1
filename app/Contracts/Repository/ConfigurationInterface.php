<?php

namespace App\Contracts\Repository;

interface ConfigurationInterface
{
    /**
     * Find an Configuration by given Id which returns Configuration Model
     *
     * @param integer $id
     * @return \App\Database\Configuration
     */
    public function find($id);

    /**
    * Find an Configuration by given Id which returns Configuration Model
    *
    * @param string $key
    * @return \App\Database\Configuration
    */
    public function findByKey($key);

    /**
    * Find an Configuration_value  by  given configurationKey
    *
    * @param string $key
    * @return string $configurationValue
    */
    public function getValueByKey($key);

    /**
     * Find an All Configuration which returns Eloquent Collection
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Create an Configuration
     *
     * @param array $data
     * @return \App\Database\Configuration
     */
    public function create($data);
}
