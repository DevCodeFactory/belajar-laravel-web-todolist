<?php

namespace Tests\Feature;

use Database\Seeders\TodoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::table('todos')->delete();
    }

    public function testTodolist()
    {
        $this->seed(TodoSeeder::class);

        $this->withSession([
            'user' => 'azdyf',
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

    public function testRemoveTodolist()
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
        ])->post('/todolist/1/delete')
            ->assertRedirect('/todolist');
    }

}
