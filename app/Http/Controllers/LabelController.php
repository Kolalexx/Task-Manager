<?php

namespace App\Http\Controllers;

use App\Http\Requests\LabelStoreRequest;
use App\Http\Requests\LabelUpdateRequest;
use App\Models\Label;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class LabelController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Label::class);
    }

    public function index(): View
    {
        $labels = Label::all();
        return view('label.index', compact('labels'));
    }

    public function create(): View
    {
        $label = new Label();
        return view('label.create', compact('label'));
    }

    public function store(LabelStoreRequest $request): RedirectResponse
    {
        $label = new Label();
        $label->fill($request->validated())->save();

        flash(__('views.label.flash.store'));
        return redirect()->route('labels.index');
    }

    public function edit(Label $label): View
    {
        return view('label.edit', compact('label'));
    }

    public function update(LabelUpdateRequest $request, Label $label): RedirectResponse
    {
        $label->fill($request->validated())->save();

        flash(__('views.label.flash.update'));
        return redirect()->route('labels.index');
    }

    public function destroy(Label $label): RedirectResponse
    {
        if ($label->tasks()->exists()) {
            flash(__('views.label.flash.destroy.constraint'))->error();
            return back();
        }

        $label->delete();
        flash(__('views.label.flash.destroy.success'))->success();
        return redirect()->route('labels.index');
    }
}
