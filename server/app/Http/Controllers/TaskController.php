<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreOrUpdateRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Task::class, 'task');
    }

    public function index()
    {
        $user = Auth::user();
        $tasks = $user->tasks()->get();
        return TaskResource::collection($tasks);
    }

    public function store(StoreOrUpdateRequest $request)
    {
        $attributes = $request->validated();

        $task = Task::create($attributes);
        return (new TaskResource($task))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Task $task)
    {
        return new TaskResource($task);
    }

    public function update(StoreOrUpdateRequest $request, Task $task)
    {
        $attributes = $request->validated();
        $task = $task->fill($attributes);
        $task->save();
        return new TaskResource($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['message' => 'task deleted.']);
    }
}
