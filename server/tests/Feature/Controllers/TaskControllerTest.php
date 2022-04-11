<?php

namespace Tests\Feature\Controllers;

use App\Models\Account;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Collection $tasks;

    private const TASK_NUM = 5;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->has(Account::factory()->has(Task::factory()->count(self::TASK_NUM)))->create();
        $this->tasks = $this->user->tasks()->get();
    }

    public function test_index_has_tasks()
    {
        $response = $this->actingAs($this->user)->getJson(route('api.tasks.index'));
        $response->assertSuccessful();
        $this->assertCount(self::TASK_NUM, $response->decodeResponseJson());
    }

    public function test_store_tasks()
    {
        /** @var Account $account */
        $account = $this->user->accounts()->first();
        $task = Task::factory()->make(['account_id' => $account->id]);
        $response = $this->actingAs($this->user)->postJson(route('api.tasks.store'), $task->toArray());
        $response->assertSuccessful()
            ->assertJson([
                'keyword' => $task->keyword,
                'start_time_period' => $task->start_time_period,
                'account' => [
                    'id' => $account->id
                ]
            ]);
    }

    public function test_show_task()
    {
        /** @var Task $task */
        $task = $this->tasks->random();
        $response = $this->actingAs($this->user)->get(route('api.tasks.show', ['task' => $task->uuid]));
        $response->assertSuccessful()
            ->assertJson([
                'keyword' => $task->keyword,
                'start_time_period' => $task->start_time_period,
                'account' => [
                    'id' => $task->account->id
                ]
            ]);
    }

    public function test_failed_show_other_user_task()
    {
        $task = Task::factory()->create();
        $response = $this->actingAs($this->user)->get(route('api.tasks.show', ['task' => $task->uuid]));
        $response->assertForbidden();
    }


    public function test_update_task()
    {
        /** @var Task $task */
        $task = $this->tasks->random();
        $updateTask = Task::factory()->make(['account_id' => $task->account_id]);
        $response = $this->actingAs($this->user)->putJson(route('api.tasks.update', ['task' => $task->uuid]), $updateTask->toArray());
        $response->assertSuccessful()
            ->assertJson([
                'keyword' => $updateTask->keyword,
                'start_time_period' => $updateTask->start_time_period,
                'account' => [
                    'id' => $task->account->id
                ]
            ]);
        $this->assertDatabaseHas('tasks', ['uuid' => $task->uuid]);
    }

    public function test_failed_update_other_user_tasks()
    {
        $task = Task::factory()->create();
        $account = $this->user->accounts()->first();
        $updateTask = Task::factory()->make(['account_id' => $account->id]);
        $response = $this->actingAs($this->user)->putJson(route('api.tasks.update', ['task' => $task->uuid]), $updateTask->toArray());
        $response->assertForbidden();
    }

    public function test_delete_tasks()
    {
        $task = $this->tasks->random();
        $response = $this->actingAs($this->user)->deleteJson(route('api.tasks.destroy', ['task' => $task->uuid]));
        $response->assertSuccessful();
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_failed_delete_other_user_tasks()
    {
        $task = Task::factory()->create();
        $response = $this->actingAs($this->user)->deleteJson(route('api.tasks.destroy', ['task' => $task->uuid]));
        $response->assertForbidden();
    }
}
