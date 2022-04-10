<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreOrUpdateRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $tasks = $user->tasks()->get();
        return new TaskCollection($tasks);
    }

    public function store(StoreOrUpdateRequest $request)
    {
        $attributes = $request->validated();

        $task = Task::create($attributes);
        return (new TaskResource($task))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(string $uuid)
    {
        $user = Auth::user();
        $task = $user->tasks()->firstWhere(['uuid' => $uuid]);
        if (!$task) {
            return response()->json(['message' => 'target task not found.'], Response::HTTP_NOT_FOUND);
        }

        return new TaskResource($task);
    }

    public function update(StoreOrUpdateRequest $request, $uuid)
    {
        $attributes = $request->validated();
        $user = Auth::user();
        $task = $user->tasks()->firstWhere(['uuid' => $uuid]);

        if (!$task) {
            return response()->json(['message' => 'target task not found.'], Response::HTTP_NOT_FOUND);
        }
        $task = $task->fill($attributes);
        if ($task->save()) {
            return new TaskResource($task);
        }
        return response()->json(['message' => 'failed to update task.'], Response::HTTP_NOT_FOUND);
    }

    public function destroy(string $uuid)
    {
        $user = Auth::user();
        $task = $user->tasks()->firstWhere(['uuid' => $uuid]);
        if ($task && $task->delete()) {
            return response()->json(['message' => 'task deleted.']);
        }
        return response()->json(['message' => 'task not found.'], Response::HTTP_NOT_FOUND);
    }
}
