<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    public function testTodolist()
    {
        $this->withSession([
            'user' => 'azdyf',
            'todolist' => [
                [
                    'id' => '1',
                    'todo' => 'Fahmi'
                ],
                [
                    'id' => '2',
                    'todo' => 'Hasyim'
                ]
            ]
        ])->get('/todolist')
            ->assertSeeText('1')
            ->assertSeeText('Fahmi')
            ->assertSeeText('2')
            ->assertSeeText('Hasyim');
    }

    public function testAddTodoFailed()
    {
        $this->withSession([
            'user' => 'azdyf',
        ])->post('/todolist', [])
            ->assertSeeText('Todo is required');
    }

    public function testAddTodoSuccess()
    {
        $this->withSession([
            'user' => 'azdyf',
        ])->post('/todolist', [
            'todo' => 'Fahmi'
        ])->assertRedirect('/todolist');
    }

}
