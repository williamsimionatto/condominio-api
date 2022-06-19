<?php

namespace Tests;

use App\Models\User;
use Tests\TestCase;

class AuthTest extends TestCase {
    public function testNoTokenInformed() {
        $response = $this->get('/api/permissao');
        $response->assertStatus(403);
        $response->assertJson(['message' => 'Token de autorização não informado!']);
    }

    public function testInvalidToken() {
        $response = $this->get('/api/permissao', [
            'Authorization' => 'Bearer 12345'
        ]);
        $response->assertStatus(403);
        $response->assertJson(['message' => 'Token inválido!']);
    }

    public function testAuthLogin() {
        $response = $this->post('api/auth/login', [
            'email' => 'admin@mail.com',
            'password' => 'password'
        ]);

        $body = json_decode($response->getContent());
        $response->assertStatus(200);
    }
}
