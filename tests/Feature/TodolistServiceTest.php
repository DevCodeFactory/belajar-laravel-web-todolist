<?php

namespace Tests\Feature;

use App\Services\TodolistService;
use Database\Seeders\TodoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Testing\Assert;
use Tests\TestCase;

class TodolistServiceTest extends TestCase
{
    private todolistService $todolistService;

    protected function setUp(): void
    {
        parent::setUp();

        DB::table('todos')->delete();

        $this->todolistService = $this->app->make(TodolistService::class);
    }

    public function testTodolistNotNull()
    {
        self::assertNotNull($this->todolistService);
    }

    public function testSaveTodo()
    {
        $this->todolistService->saveTodo('1', 'Fahmi');

        $todolist = $this->todolistService->getTodolist();
        foreach ($todolist as $value) {
            self::assertEquals(1, $value['id']);
            self::assertEquals('Fahmi', $value['todo']);
        }
    }

    public function testGetTodolistEmpty()
    {
        self::assertEquals([], $this->todolistService->getTodolist());
    }

    public function testGetTodolistNotEmpty()
    {
        $expected = [
            [
                'id' => '1',
                'todo' => 'Fahmi'
            ],
            [
                'id' => '2',
                'todo' => 'Hasyim'
            ]
        ];

        $this->todolistService->saveTodo('1', 'Fahmi');
        $this->todolistService->saveTodo('2', 'Hasyim');

        Assert::assertArraySubset($expected, $this->todolistService->getTodolist());

    }

    public function testRemoveTodo()
    {
        $this->todolistService->saveTodo('1', 'Fahmi');
        $this->todolistService->saveTodo('2', 'Hasyim');

        self::assertEquals(2, sizeof($this->todolistService->getTodolist()));

        $this->todolistService->removeTodo('3');
        self::assertEquals(2, sizeof($this->todolistService->getTodolist()));

        $this->todolistService->removeTodo('2');
        self::assertEquals(1, sizeof($this->todolistService->getTodolist()));

        $this->todolistService->removeTodo('1');
        self::assertEquals(0, sizeof($this->todolistService->getTodolist()));
    }

}
