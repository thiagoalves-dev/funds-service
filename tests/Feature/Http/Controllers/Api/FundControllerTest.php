<?php

namespace Feature\Http\Controllers\Api;

use App\Events\Fund\FundCreated;
use App\Models\Fund;
use App\Models\Manager;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class FundControllerTest extends TestCase
{
    public function testStoreValidationRequiredData(): void
    {
        $this
            ->sendStoreRequest()
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'manager_id',
                'name',
                'start_year',
                'aliases',
            ]);
    }

    public function testStoreValidationDataSpecifications(): void
    {
        $this
            ->sendStoreRequest([
                'manager_id' => 'a',
                'name'       => fake()->realTextBetween(300, 350),
                'start_year' => 'a',
                'aliases'    => 'a',
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'manager_id',
                'name',
                'start_year',
                'aliases',
            ]);
    }

    public function testStoreValidationManagerIdExists(): void
    {
        $managerId = Manager::max('id') + 1;

        $this
            ->sendStoreRequest([
                'manager_id' => $managerId,
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'manager_id',
            ]);
    }

    public function testStoreValidationAliasesArrayLength(): void
    {
        $this
            ->sendStoreRequest([
                'aliases' => [],
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'aliases',
            ]);
    }

    public function testStoreValidationAliasesType(): void
    {
        $this
            ->sendStoreRequest([
                'aliases' => [1],
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'aliases.0',
            ]);
    }

    public function testStoreValidationAliasesStringLength(): void
    {
        $this
            ->sendStoreRequest([
                'aliases' => [fake()->realTextBetween(30)],
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'aliases.0',
            ]);
    }

    public function testStoreSuccess(): void
    {
        Event::fake();

        $fundData = Fund::factory()->make();

        $this
            ->sendStoreRequest($fundData->toArray())
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'manager',
                    'name',
                    'start_year',
                    'aliases',
                ],
            ])
            ->assertJsonFragment([
                'manager'    => [
                    'id'   => $fundData->manager->getKey(),
                    'name' => $fundData->manager->name,
                ],
                'name'       => $fundData->name,
                'start_year' => $fundData->start_year,
                'aliases'    => $fundData->aliases,
            ]);

        Event::assertDispatched(FundCreated::class);
    }

    private function sendStoreRequest(array $data = [])
    {
        return $this->sendRequest('post', 'api.funds.store', $data);
    }

    private function sendRequest(string $method, string $route, array $data = [])
    {
        return $this->json($method, route($route), $data);
    }
}
