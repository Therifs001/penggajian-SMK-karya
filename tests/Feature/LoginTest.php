<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * Test admin login.
     */
    public function test_admin_login(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin');
    }

    /**
     * Test guru login.
     */
    public function test_guru_login(): void
    {
        $response = $this->post('/login', [
            'email' => 'guru@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/guru');
    }
}
