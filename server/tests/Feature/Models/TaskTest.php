<?php

namespace Tests\Feature\Models;

use App\Models\Task;
use App\Models\TaskLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_relation()
    {
        /** @var Task $task */
        $task = Task::factory()
            ->has(TaskLog::factory()->count(2), 'taskLogs')
            ->create();

        $this->assertNotNull($task->account()->first());
        $this->assertNotNull($task->taskLogs()->get());
        $this->assertCount(2, $task->taskLogs()->get());
    }
}
