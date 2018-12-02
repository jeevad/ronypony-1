<?php

namespace App\Repositories;

use App\Contracts\Repository\ConfigurationInterface;
use App\Models\Configuration;

class ConfigurationRepository implements ConfigurationInterface
{
    /**
     * Find an Configuration by  given Id
     *
     * @param $id
     * @return \App\Models\Configuration
     */
    public function find($id)
    {
        return Configuration::find($id);
    }

    /**
     * Find an Configuration by  given Id
     *
     * @param $id
     * @return \App\Models\Configuration
     */
    public function findByKey($key)
    {
        return Configuration::whereConfigurationKey($key)->first();
    }

    /**
    * Find an Configuration_value  by  given configurationKey
    *
    * @param string $key
    * @return string $configurationValue
    */
    public function getValueByKey($key)
    {
        $model = Configuration::whereConfigurationKey($key)->first();

        if (null === $model) {
            return null;
        }

        return $model->configuration_value;
    }

    /**
    * Find all Configuration
    *
    * @return \Illuminate\Database\Eloquent\Collection
    */
    public function all()
    {
        return Configuration::all();
    }

    /**
     * Find an Attribute Query
     *
     * @return \App\Models\Configuration
     */
    public function create($data)
    {
        return Configuration::create($data);
    }
}
