<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
   // public function __construct()
   // {
     //   $this->authorizeResource(Task::class);
   // }

    public function index()
    {
        $tasks = QueryBuilder::for(Task::class)
            ->orderBy('id')
            ->paginate(15);
        return view('task.index', compact('tasks'));
    }

    public function create()
    {
        $task = new Task();
        $statuses = TaskStatus::pluck('name', 'id');

        $execs = User::pluck('name', 'id');

        return view('task.create', compact('task', 'statuses', 'execs'));
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
            'assigned_to_id' => '',
        ], $messages);

        $task = new Task();
        $task->fill($data);
        $task->created_by_id = (int) Auth::id();
        $task->save();

        flash(__('messages.The task was successfully created'))->success();
        return redirect()->route('tasks.index');
    }

    public function show(Task $task)
    {
        return view('task.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $statuses = TaskStatus::pluck('name', 'id');

        $execs = User::pluck('name', 'id');

        return view('task.edit', compact('task', 'statuses', 'execs'));
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
            'assigned_to_id' => '',
        ], $messages);

        $task->fill($data);
        $task->save();

        flash(__('messages.The task has been successfully updated'))->success();
        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        flash(__('views.task.flash.destroy.success'));

        return redirect()->route('tasks.index');
    }
}
