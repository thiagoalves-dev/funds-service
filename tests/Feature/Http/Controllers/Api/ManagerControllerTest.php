<?php

namespace Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ManagerControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testIndexSuccess(): void
    {
        $this
            ->get(route('api.managers.index'))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                    ],
                ],
            ]);
    }
}
