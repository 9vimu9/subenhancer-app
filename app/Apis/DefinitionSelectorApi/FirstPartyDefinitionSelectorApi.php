<?php

declare(strict_types=1);

namespace App\Apis\DefinitionSelectorApi;

use App\Core\Contracts\Apis\DefinitionSelectorApiInterface;
use App\Exceptions\DefinitionSelectionApiErrorException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class FirstPartyDefinitionSelectorApi implements DefinitionSelectorApiInterface
{
    public function pickADefinitionBasedOnContext(string $context, array $definitionArray, string $word, int $orderInTheContext): string
    {
        $response = Http::post(
            config('app.definition_pick_endpoint'),
            [
                'definitions' => $definitionArray,
                'word' => $word,
                'order_in_the_context' => $orderInTheContext,
            ]);
        if ($response->status() !== Response::HTTP_OK) {
            throw new DefinitionSelectionApiErrorException();
        }

        return $response->json()['definition'];
    }
}
