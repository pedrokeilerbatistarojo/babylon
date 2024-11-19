<?php

namespace App\Shared\Contracts\Transaction;

use App\Batches\Domain\Models\Batch;

interface BatchServiceInterface
{
    public function getCurrentBatch(int $business_id): Batch;
}
