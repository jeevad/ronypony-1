<?php

namespace App\Repositories;

use App\Models\CategoryFilter;
use App\Contracts\Repository\CategoryFilterInterface;

class CategoryFilterRepository implements CategoryFilterInterface
{
    /**
    * Find a Category filter by Id
    *
    * @param integer $id
    * @return \App\Models\CategoryFilter
    */
    public function find($id)
    {
        return CategoryFilter::find($id);
    }

    /**
    * Category Filter Query Builder
    *
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function query()
    {
        return CategoryFilter::query();
    }

    /**
    * Save Categoy Filter

    * @param integer $categoryId
    * @param integer $filterId
    * @param string $type
    * @return \App\Models\CategoryFilter
    */
    public function saveFilter($categoryId, $filterId, $type)
    {
        $filterModel = CategoryFilter::whereCategoryId($categoryId)
                                        ->whereFilterId($filterId)
                                        ->whereType('PROPERTY')->first();
        if (null === $filterModel) {
            CategoryFilter::create([
                'category_id' => $categoryId,
                'filter_id' => $filterId,
                'type' => 'PROPERTY'
            ]);
        }
    }
}
