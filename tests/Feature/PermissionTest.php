<?php

namespace Tests;

use Tests\TestCase;

class PermissionTest extends TestCase {
    public function getToken() {
        $user = $this->post('api/auth/login', [
            'email' => 'admin@mail.com',
            'password' => 'password'
        ]);

        $body = json_decode($user->getContent());
        $token = $body[0]->access_token;
        return $token;
    }

    public function testInsertPermission() {
        $response = $this->post('/api/permissao', [
            'name' => 'Permissão de Teste',
            'sigla' => 'PT'
        ], [
            'Authorization' => 'Bearer ' . $this->getToken()
        ]);

        $response->assertStatus(200);
    }

    public function testGetPermission() {
        $response = $this->get('/api/permissao', [
            'Authorization' => 'Bearer ' . $this->getToken()
        ]);

        $response->assertStatus(200);
        $permission = json_decode($response->getContent());
        $this->assertNotEmpty($permission);
    }
}
