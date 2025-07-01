<?php

namespace Tests\Feature;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::table('users')->delete();
    }

    public function testLoginPage()
    {
        $this->get('/login')
            ->assertStatus(200)
            ->assertSeeText('Login');
    }

    public function testLoginPageForMember()
    {
        $this->withSession([
            'user' => 'azdyf'
        ])->get('/login')
            ->assertRedirect('/');
    }


    public function testLoginSuccess()
    {
        $this->seed([UserSeeder::class]);
        $this->post('/login', [
            'user' => 'fahmi@test.com',
            'password' => 'rahasia',
        ])->assertRedirect('/')
            ->assertSessionHas('user', 'fahmi@test.com');
    }

    public function testLoginForUserAlreadyLogin()
    {
        $this->withSession([
            'user' => 'azdyf',
        ])->post('/login', [
            'user' => 'azdyf',
            'password' => 'rahasia',
        ])->assertRedirect('/');
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

    public function testLogout()
    {
        $this->withSession([
            'user' => 'azdyf',
        ])->post('/logout')
            ->assertRedirect('/')
            ->assertSessionMissing('user');
    }

    public function testLogoutGuest()
    {
        $this->post('/logout')
            ->assertRedirect('/');
    }
}
