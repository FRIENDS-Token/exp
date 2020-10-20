<?php

declare(strict_types=1);

namespace App\Aggregates;

use App\Contracts\Aggregate;
use App\Facades\Network;
use App\Models\Block;
use App\Services\NumberFormatter;

final class ForgedFeesAggregate implements Aggregate
{
    public function aggregate(): string
    {
        return NumberFormatter::currency(Block::sum('total_fee') / 1e8, Network::currency());
    }
}
