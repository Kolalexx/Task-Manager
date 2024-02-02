<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Http\Request;

class TaskStatusController extends Controller
{
    
    public function index()
    {
        $statuses = TaskStatus::paginate();
        return view('task_status.index', compact('statuses'));
    }

    public function create()
    {
        $status = new TaskStatus();
        return view('task_status.create', compact('status'));
    }

    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'Это обязательное поле',
            'name.unique' => 'Статус с таким именем уже существует'
        ];
        $data = $this->validate($request, [
            'name' => 'required|unique:task_statuses',
        ], $messages);

        $request->session()->flash('errors', 'Статус успешно создан');

        $status = new TaskStatus();
        $status->fill($data);
        $status->save();

        return redirect()
            ->route('task_statuses.index');
    }

    public function edit(TaskStatus $taskStatus)
    {
        return view('task_status.edit', compact('taskStatus'));
    }

    public function update(Request $request, TaskStatus $taskStatus)
    {
        $messages = [
            'name.required' => 'Это обязательное поле',
            'name.unique' => 'Статус с таким именем уже существует'
        ];
        $data = $this->validate($request, [
            'name' => 'required|unique:task_statuses,name,' . $taskStatus->id,
        ], $messages);

        $taskStatus->fill($data)->save();
        return redirect()
            ->route('task_statuses.index');
    }

    public function destroy(TaskStatus $taskStatus)
    {
        if (!$taskStatus->tasks()->exists($taskStatus->id)) {
            $taskStatus->delete();
            flash(__('messages.Статус успешно удалён'))->success();
        } else {
            flash(__('messages.Failed to delete status'))->error();
        }

        return redirect()->route('task_statuses.index');
    }
}
