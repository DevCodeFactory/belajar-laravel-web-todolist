<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLoginPage()
    {
        $this->get('/login')
            ->assertStatus(200)
            ->assertSeeText('Login');
    }

    public function testLoginSuccess()
    {
        $this->post('/login', [
            'user' => 'azdyf',
            'password' => 'rahasia',
        ])->assertRedirect('/')
            ->assertSessionHas('user', 'azdyf');
    }

    public function testLoginValidationError()
    {
        $this->post('/login', [])
            ->assertSeeText('User or Password is required');
    }

    public function testLoginFailed()
    {
        $this->post('/login', [
            'user' => 'wrong',
            'password' => 'wrong',
        ])->assertSeeText('User or Password is incorrect');
    }
}
