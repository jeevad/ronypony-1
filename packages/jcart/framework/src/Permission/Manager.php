<?php

namespace Jcart\Framework\Permission;

use Illuminate\Support\Collection;

class Manager
{
    /**
     * Collect all the Permissions from all the modules.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $permissions;

    public function __construct()
    {
        $this->permissions = Collection::make([]);
    }

    /**
     * Get all  Permission Collection.
     *
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
        return $this->permissions;
    }

    /**
     * Add Permission into Collection.
     *
     * @param string $key
     * @return \Jcart\Framework\Permission\Manager
     */
    public function add($key)
    {
        $permissionGroup = new PermissionGroup();

        $permissionGroup->key($key);
        $this->permissions->put($key, $permissionGroup);

        return $permissionGroup;
    }

    /**
     * Get Permission Collection if exists or Return Empty Collection.
     *
     * @param array $item
     * @return \Illuminate\Support\Collection
     */
    public function get($key)
    {
        if ($this->permissions->has($key)) {
            return $this->permissions->get($key);
        }

        return $collection = Collection::make([]);
    }

    /**
     * Get Permission Collection if exists or Return Empty Collection.
     *
     * @param array $item
     * @return \Illuminate\Support\Collection
     */
    public function set($key, $permissionCollection)
    {
        $this->permissions->put($key, $permissionCollection);
        return $this;
    }
}
