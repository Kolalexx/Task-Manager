<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Task;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\TaskStatus;
use App\Models\User;
use App\Models\Label;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\QueryBuilder\AllowedFilter;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Task::class);
    }

    public function index(): View
    {
        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters([
                AllowedFilter::exact('status_id')->ignore(''),
                AllowedFilter::exact('created_by_id')->ignore(''),
                AllowedFilter::exact('assigned_to_id')->ignore(''),
            ])
            ->with(['status', 'creator', 'executor'])
            ->paginate()
            ->withQueryString();

        $statuses = TaskStatus::options();
        $executors = User::options();
        $creators = User::options();

        return view('task.index', compact('tasks', 'creators', 'statuses', 'executors'));
    }

    public function create(): View
    {
        $task = new Task();
        $statuses = TaskStatus::options();
        $executors = User::options();
        $labels = Label::options();

        return view('task.create', compact('task', 'statuses', 'executors', 'labels'));
    }

    public function store(TaskStoreRequest $request): RedirectResponse
    {
        $labels = $request->validated('labels') ?? [];

        $task = new Task();
        $task->fill($request->validated());
        $task->created_by_id = $request->user()->id;
        $task->save();
        $task->labels()->attach($labels);

        flash(__('views.task.flash.store'));
        return redirect()->route('tasks.index');
    }

    public function show(Task $task): View
    {
        $labels = $task->labels;
        return view('task.show', compact('task', 'labels'));
    }

    public function edit(Task $task): View
    {
        $statuses = TaskStatus::options();
        $executors = User::options();
        $labels = Label::options();

        return view('task.edit', compact('task', 'statuses', 'executors', 'labels'));
    }

    public function update(TaskUpdateRequest $request, Task $task): RedirectResponse
    {
        $labels = $request->validated('labels') ?? [];

        $task->fill($request->validated());
        $task->save();
        $task->labels()->sync($labels);

        flash(__('views.task.flash.update'));
        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();
        flash(__('views.task.flash.destroy.success'));

        return redirect()->route('tasks.index');
    }
}
