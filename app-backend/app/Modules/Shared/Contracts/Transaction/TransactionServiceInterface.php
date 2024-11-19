<?php

namespace App\Shared\Contracts\Transaction;

use App\Transactions\Domain\Models\Transaction;

interface TransactionServiceInterface
{
    public function toArray(Transaction $transaction): array;
}
