<?php

namespace App\Repositories;

use App\Contracts\Repository\UserGroupInterface;
use App\Models\UserGroup;

class UserGroupRepository implements UserGroupInterface
{
    /**
     * Find an User Group by given Id
     *
     * @param $id
     * @return \App\UserGroup
     */
    public function find($id)
    {
        return UserGroup::find($id);
    }

    /**
     * Find an User Group by given Id
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return UserGroup::all();
    }

    /**
     * Paginate User Group
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate($noOfItem = 10)
    {
        return UserGroup::paginate($noOfItem);
    }

    /**
     * Find an User Group Query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return UserGroup::query();
    }

    /**
     * Find an User Group Query
     *
     * @return \App\UserGroup
     */
    public function create($data)
    {
        return UserGroup::create($data);
    }
}
