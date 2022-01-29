<?php

namespace Tests\Unit\Models;

use App\Models\TaskLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskLogTest extends TestCase
{
    use RefreshDatabase;

    public function test_relation()
    {
        /** @var TaskLog $log */
        $log = TaskLog::factory()
            ->create();

        $this->assertNotNull($log->task()->first());;
    }
}
