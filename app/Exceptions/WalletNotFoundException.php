<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Exceptions\Contracts\EntityNotFoundInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\HtmlString;
use ARKEcosystem\UserInterface\Components\TruncateMiddle;

final class WalletNotFoundException extends ModelNotFoundException implements EntityNotFoundInterface
{
    public function getCustomMessage(): HtmlString
    {
        $truncateMiddle = new TruncateMiddle();

        [$walletID] = $this->getIds();

        $truncatedWalletID = $truncateMiddle->render()([
            'slot'       => $walletID,
            'attributes' => ['length' => 17],
        ]);

        $message = trans('errors.wallet_not_found', [
            'truncatedWalletID' => $truncatedWalletID,
            'walletID'          => $walletID,
        ]);

        return new HtmlString($message);
    }
}
