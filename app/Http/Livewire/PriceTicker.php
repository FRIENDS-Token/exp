<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Facades\Network;
use App\Services\Cache\NetworkStatusBlockCache;
use App\Services\NumberFormatter;
use App\Services\Settings;
use Illuminate\View\View;
use Livewire\Component;

final class PriceTicker extends Component
{
    /** @phpstan-ignore-next-line */
    protected $listeners = [
        'currencyChanged' => 'setValues',
    ];

    public string $price;

    public string $from;

    public string $to;

    public bool $isAvailable = false;

    public function mount(): void
    {
        $this->setValues();
    }

    public function setValues(): void
    {
        $this->isAvailable = (new NetworkStatusBlockCache())->getIsAvailable(Network::currency(), Settings::currency());
        $this->price       = $this->getPriceFormatted();
        $this->from        = Network::currency();
        $this->to          = Settings::currency();
    }

    private function getPriceFormatted(): string
    {
        $price = (new NetworkStatusBlockCache())->getPrice(Network::currency(), Settings::currency());

        if ($price === null) {
            return '';
        }

        return NumberFormatter::currencyWithDecimalsWithoutSuffix($price, Settings::currency());
    }

    public function render(): View
    {
        return view('livewire.price-ticker', [
            'from'  => $this->from,
            'to'    => $this->to,
            'price' => $this->price,
        ]);
    }
}
