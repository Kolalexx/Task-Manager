<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStatusStoreRequest;
use App\Http\Requests\TaskStatusUpdateRequest;
use App\Models\TaskStatus;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class TaskStatusController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(TaskStatus::class);
    }

    public function index(): View
    {
        $statuses = TaskStatus::paginate();
        return view('task_status.index', compact('statuses'));
    }

    public function create(): View
    {
        $status = new TaskStatus();
        return view('task_status.create', compact('status'));
    }

    public function store(TaskStatusStoreRequest $request): RedirectResponse
    {
        $status = new TaskStatus();
        $status->fill($request->validated())->save();

        flash(__('views.status.flash.store'));
        return redirect()->route('task_statuses.index');
    }

    public function edit(TaskStatus $taskStatus): View
    {
        return view('task_status.edit', compact('taskStatus'));
    }

    public function update(TaskStatusUpdateRequest $request, TaskStatus $taskStatus): RedirectResponse
    {
        $taskStatus->fill($request->validated())->save();
        flash(__('views.status.flash.update'));
        return redirect()
            ->route('task_statuses.index');
    }

    public function destroy(TaskStatus $taskStatus): RedirectResponse
    {
        if ($taskStatus->tasks()->exists()) {
            flash(__('views.status.flash.destroy.constraint'))->error();
            return back();
        }

        $taskStatus->delete();
        flash(__('views.status.flash.destroy.success'))->success();
        return redirect()->route('task_statuses.index');
    }
}
