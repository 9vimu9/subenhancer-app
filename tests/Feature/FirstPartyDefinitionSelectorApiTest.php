<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Apis\DefinitionSelectorApi\FirstPartyDefinitionSelectorApi;
use App\Exceptions\DefinitionSelectionApiErrorException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class FirstPartyDefinitionSelectorApiTest extends TestCase
{
    public function test_pickADefinitionBasedOnContext(): void
    {

        $response = ['definition' => 'sample defition'];
        Http::fake([
            config('app.definition_pick_endpoint') => Http::response($response, Response::HTTP_OK),

        ]);
        $definitionSelectorApi = new FirstPartyDefinitionSelectorApi();
        $this->assertEquals(
            $response['definition'],
            $definitionSelectorApi->pickADefinitionBasedOnContext(
                'RANDOM TEXT',
                [],
                'RANDOM', 1)
        );
    }

    public function test_pickADefinitionBasedOnContext_throws_exception_when_on_error(): void
    {

        Http::fake([
            config('app.definition_pick_endpoint') => Http::response([], Response::HTTP_INTERNAL_SERVER_ERROR),

        ]);
        $this->expectException(DefinitionSelectionApiErrorException::class);
        (new FirstPartyDefinitionSelectorApi())->pickADefinitionBasedOnContext(
            'RANDOM TEXT',
            [],
            'RANDOM', 1);
    }
}
