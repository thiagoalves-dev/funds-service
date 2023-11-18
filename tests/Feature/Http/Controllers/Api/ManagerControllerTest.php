<?php

namespace Feature\Http\Controllers\Api;

use Tests\TestCase;

class ManagerControllerTest extends TestCase
{
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
