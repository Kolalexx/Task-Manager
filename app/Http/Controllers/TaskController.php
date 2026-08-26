<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Task;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\TaskStatus;
use App\Models\User;
use App\Models\Label;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Task::class);
    }

    public function index()
    {
        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters([
                AllowedFilter::exact('status_id'),
                AllowedFilter::exact('created_by_id'),
                AllowedFilter::exact('assigned_to_id'),
            ])
            ->with(['status', 'creator', 'executor'])
            ->get();

        $statuses = TaskStatus::options();
        $execs = User::options();
        $creators = User::options();

        return view('task.index', compact('tasks', 'creators', 'statuses', 'execs'));
    }

    public function create()
    {
        $task = new Task();
        $statuses = TaskStatus::options();
        $execs = User::options();
        $labels = Label::options();

        return view('task.create', compact('task', 'statuses', 'execs', 'labels'));
    }

    public function store(TaskStoreRequest $request)
    {
        $task = new Task();
        $task->fill($request->validated());
        $task->created_by_id = (int) Auth::id();
        $task->save();
        $task->labels()->attach($request->validated('labels') ?? []);

        flash(__('views.task.flash.store'));
        return redirect()->route('tasks.index');
    }

    public function show(Task $task)
    {
        $labels = $task->labels;
        return view('task.show', compact('task', 'labels'));
    }

    public function edit(Task $task)
    {
        $statuses = TaskStatus::options();
        $execs = User::options();
        $labels = Label::options();

        return view('task.edit', compact('task', 'statuses', 'execs', 'labels'));
    }

    public function update(TaskUpdateRequest $request, Task $task)
    {
        $task->fill($request->validated());
        $task->save();
        $task->labels()->sync($request->validated('labels') ?? []);

        flash(__('views.task.flash.update'));
        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        flash(__('views.task.flash.destroy.success'));

        return redirect()->route('tasks.index');
    }
}
