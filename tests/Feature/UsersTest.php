<?php

namespace Tests\Feature;

use Tests\TestCase;

class UsersTest extends TestCase
{
    private $token;

    public function test_get_token(): void
    {
        $response = $this->get('/api/token');
        $response->assertStatus(200);
        $this->token = $response->decodeResponseJson()['token'];
    }

    public function test_users_index(): void
    {
        $response = $this->get('/api/users?count=6&page=1');
        $response->assertStatus(200);
        $response = $this->get('/api/users?count=6');
        $response->assertStatus(302);
    }

    public function test_users_store(): void
    {
        $data = [
            'photo' => config('app.url') . '/images/9187604.png',
            'name' => 'Name',
            'email' => 'test' . time() . '@test.com',
            'phone' => '+380' . rand(100000000,999999999),
            'position_id' => rand(1,4),
        ];
        $token = $this->get('/api/token')->decodeResponseJson()['token'];
        $this->registerUser($data, 200, $token);

        $data = [
            'photo' => config('app.url') . '/images/9187604.png',
            'name' => 'Name Name Name Name Name Name Name NameName Name Name Name Name Name Name Name Name Name Name Name Name Name Name Name',
            'email' => 'test' . time() . '@test.com',
            'phone' => '+380' . rand(100000000,999999999),
            'position_id' => rand(1,4),
        ];
        $this->registerUser($data, 422, $token);

        $data = [
            'photo' => config('app.url') . '/images/9187604.png',
            'name' => 'Name Name Name Name Name Name Name NameName Name Name Name Name Name Name Name Name Name Name Name Name Name Name Name',
            'email' => 'test' . time() . '@',
            'phone' => '+380' . rand(100000000,999999999),
            'position_id' => rand(1,4),
        ];
        $this->registerUser($data, 422, $token);

        $data = [
            'photo' => config('app.url') . '/images/9187604.png',
            'name' => 'Name Name Name Name Name Name Name NameName Name Name Name Name Name Name Name Name Name Name Name Name Name Name Name',
            'email' => 'test' . time() . '@',
            'phone' => '+380' . rand(100000000,999999999),
            'position_id' => null,
        ];
        $this->registerUser($data, 422, $token);
    }

    private function registerUser($data, $expectedCode, $token)
    {
        $response = $this->withHeaders([
            'token' => $token
        ])->post('/api/users', $data);
        $response->assertStatus($expectedCode);
    }
}
