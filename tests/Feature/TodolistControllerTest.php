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

}
