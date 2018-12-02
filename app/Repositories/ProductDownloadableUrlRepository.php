<?php

namespace App\Repositories;

use App\Contracts\Repository\ProductDownloadableUrlInterface;
use App\Models\ProductDownloadableUrl;

class ProductDownloadableUrlRepository implements ProductDownloadableUrlInterface
{
    /**
      * Find an Downloadable Product by given Id which returns ProductDownloadableUrl Model
      *
      * @param integer $id
      * @return \App\Models\ProductDownloadableUrl
      */
    public function find($id)
    {
        return ProductDownloadableUrl::find($id);
    }

    /**
    * Find an Category by given token which returns Category Model
    *
    * @param string $token
    * @return \App\Models\ProductDownloadableUrl
    */
    public function findByToken($token)
    {
        return ProductDownloadableUrl::whereToken($token)->first();
    }

    /**
    * Get an All  which returns Eloquent Collection
    *
    * @return \Illuminate\Database\Eloquent\Collection
    */
    public function all()
    {
        return ProductDownloadableUrl::all();
    }

    /**
     * Category Collection with Limit which returns paginate class
     *
     * @param integer $noOfItem
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate($noOfItem = 10)
    {
        return ProductDownloadableUrl::paginate($noOfItem);
    }

    /**
     * Category Query Builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return ProductDownloadableUrl::query();
    }

    /**
     * Create an Product Downloadable Url
     *
     * @param array $data
     * @return \App\Models\ProductDownloadableUrl
     */
    public function create($data)
    {
        return ProductDownloadableUrl::create($data);
    }
}
