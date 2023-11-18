<?php

namespace Feature\Http\Controllers\Api;

use App\Events\Fund\FundCreated;
use App\Events\FundDeleted;
use App\Events\FundUpdated;
use App\Models\Fund;
use App\Models\Manager;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class FundControllerTest extends TestCase
{
    use DatabaseMigrations;

    private Fund $defaultFund;

    protected function setUp(): void
    {
        parent::setUp();

        $this->defaultFund = Fund::factory()->create();
    }

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

        $response = $this
            ->sendStoreRequest($fundData->toArray())
            ->assertStatus(201);

        $this->assertFundResource($response, $fundData);

        Event::assertDispatched(FundCreated::class);
    }

    public function testShowBinding()
    {
        $fundId = Fund::max('id') + 1;

        $this
            ->sendShowRequest($fundId)
            ->assertStatus(404);
    }

    public function testShowSuccess()
    {
        $response = $this
            ->sendShowRequest($this->defaultFund->getKey())
            ->assertStatus(200);

        $this->assertFundResource($response, $this->defaultFund);
    }

    public function testUpdateBinding()
    {
        $fundId = Fund::max('id') + 1;

        $this
            ->sendUpdateRequest($fundId)
            ->assertStatus(404);
    }

    public function testUpdateValidationRequiredData(): void
    {
        $this
            ->sendUpdateRequest($this->defaultFund->getKey())
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'manager_id',
                'name',
                'start_year',
                'aliases',
            ]);
    }

    public function testUpdateValidationDataSpecifications(): void
    {
        $this
            ->sendUpdateRequest($this->defaultFund->getKey(), [
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

    public function testUpdateValidationManagerIdExists(): void
    {
        $managerId = Manager::max('id') + 1;

        $this
            ->sendUpdateRequest($this->defaultFund->getKey(), [
                'manager_id' => $managerId,
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'manager_id',
            ]);
    }

    public function testUpdateValidationAliasesArrayLength(): void
    {
        $this
            ->sendUpdateRequest($this->defaultFund->getKey(), [
                'aliases' => [],
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'aliases',
            ]);
    }

    public function testUpdateValidationAliasesType(): void
    {
        $this
            ->sendUpdateRequest($this->defaultFund->getKey(), [
                'aliases' => [1],
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'aliases.0',
            ]);
    }

    public function testUpdateValidationAliasesStringLength(): void
    {
        $this
            ->sendUpdateRequest($this->defaultFund->getKey(), [
                'aliases' => [fake()->realTextBetween(30)],
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'aliases.0',
            ]);
    }

    public function testUpdateSuccess(): void
    {
        Event::fake();

        $newFundData = Fund::factory()->make();

        $response = $this
            ->sendUpdateRequest($this->defaultFund->getKey(), $newFundData->toArray())
            ->assertStatus(200);

        $this->assertFundResource($response, $this->defaultFund->refresh());

        Event::assertDispatched(FundUpdated::class);
    }

    public function testDestroyBinding()
    {
        $fundId = Fund::max('id') + 1;

        $this
            ->sendDestroyRequest($fundId)
            ->assertStatus(404);
    }

    public function testDestroySuccess()
    {
        Event::fake();

        $this
            ->sendDestroyRequest($this->defaultFund->getKey())
            ->assertStatus(200)
            ->assertJsonStructure(['message']);

        Event::assertDispatched(FundDeleted::class);
    }

    private function sendStoreRequest(array $data = [])
    {
        return $this->sendRequest('post', route('api.funds.store'), $data);
    }

    private function sendShowRequest(int $id)
    {
        return $this->sendRequest('get', route('api.funds.show', $id));
    }

    private function sendUpdateRequest(int $id, array $data = [])
    {
        return $this->sendRequest('put', route('api.funds.update', $id), $data);
    }

    private function sendDestroyRequest(int $id)
    {
        return $this->sendRequest('delete', route('api.funds.destroy', $id));
    }

    private function sendRequest(string $method, string $route, array $data = [])
    {
        return $this->json($method, $route, $data);
    }

    private function assertFundResource(TestResponse $response, Fund $fundData)
    {
        $response
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

        if ($id = $fundData->getKey()) {
            $response
                ->assertJsonFragment(compact('id'));
        }
    }
}
