<?php

namespace App\Contracts\Repository;

interface OrderHistoryInterface
{
    /**
     * Create an Order History
     *
     * @param array $data
     * @return \App\Database\Order History
     */
    public function create($data);
}
