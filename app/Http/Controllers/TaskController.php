<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
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
            ->get();

        $statuses = TaskStatus::pluck('name', 'id');
        $execs = User::pluck('name', 'id');
        $creators = User::pluck('name', 'id');

        return view('task.index', compact('tasks', 'creators', 'statuses', 'execs'));
    }

    public function create()
    {
        $task = new Task();
        $statuses = TaskStatus::pluck('name', 'id');
        $execs = User::pluck('name', 'id');
        $labels = Label::pluck('name', 'id');

        return view('task.create', compact('task', 'statuses', 'execs', 'labels'));
    }

    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'Это обязательное поле',
            'name.unique' => 'Задача с таким именем уже существует',
            'status_id' => 'Это обязательное поле',
        ];
        $data = $this->validate($request, [
            'name' => 'required|unique:tasks',
            'description' => 'nullable',
            'status_id' => 'required',
            'assigned_to_id' => 'nullable',
        ], $messages);

        $task = new Task();
        $task->fill($data);
        $task->created_by_id = (int) Auth::id();
        $task->save();
        $labels = collect($request->input('labels'))
            ->filter(fn($label) => $label !== null);
        $label = Label::find($labels);
        $task->labels()->attach($label);

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
        $statuses = TaskStatus::pluck('name', 'id');
        $execs = User::pluck('name', 'id');
        $labels = Label::pluck('name', 'id');

        return view('task.edit', compact('task', 'statuses', 'execs', 'labels'));
    }

    public function update(Request $request, Task $task)
    {
        $messages = [
            'name' => 'Это обязательное поле',
            'status_id' => 'Это обязательное поле',
        ];

        $data = $this->validate($request, [
            'name' => 'required:tasks,name,' . $task->id,
            'description' => 'nullable:tasks,description',
            'status_id' => 'required:tasks,status_id' . $task->id,
            'assigned_to_id' => 'nullable',
        ], $messages);

        $task->fill($data);
        $task->save();

        $labels = collect($request->input('labels'))
            ->filter(fn($label) => $label !== null);
        $label = Label::find($labels);
        $task->labels()->sync($label);

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
