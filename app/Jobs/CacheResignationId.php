<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Transaction;
use App\Services\Cache\WalletCache;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class CacheResignationId implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(public Transaction $transaction)
    {
    }

    public function handle(WalletCache $cache): void
    {
        $cache->setResignationId($this->transaction->sender_public_key, $this->transaction->id);
    }
}
