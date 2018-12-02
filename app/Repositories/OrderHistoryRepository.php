<?php

namespace App\Repositories;

use App\Models\OrderHistory;
use App\Contracts\Repository\OrderHistoryInterface;

class OrderHistoryRepository implements OrderHistoryInterface
{
    /**
     * Create an Order History Record
     *
     * @return \App\Models\OrderHistory
     */
    public function create($data)
    {
        return OrderHistory::create($data);
    }
}
