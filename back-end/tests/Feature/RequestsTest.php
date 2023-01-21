<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RequestsTest extends TestCase
{
    public function test_api_resource_students()
    {
        $response = $this->get('/api/students');
        $response->assertStatus(200);
    }

    public function test_api_resource_assists()
    {
        $response = $this->get('/api/assists');
        $response->assertStatus(200);

        $response = $this->postJson(
            '/api/assists',
            [
                'data' => [
                    [
                        'id' => 1,
                        'status' => 'test'
                    ],
                ],
                'date' => '2023-01-21'
            ]
        );
        $response->assertStatus(200);

        $date = '2023-01-21';
        $response = $this->get("/api/assists/{$date}");
        $response->assertStatus(200);
    }
}
