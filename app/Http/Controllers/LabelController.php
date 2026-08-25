<?php

namespace App\Http\Controllers;

use App\Http\Requests\LabelStoreRequest;
use App\Http\Requests\LabelUpdateRequest;
use App\Models\Label;

class LabelController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Label::class);
    }

    public function index()
    {
        $labels = Label::all();
        return view('label.index', compact('labels'));
    }

    public function create()
    {
        $label = new Label();
        return view('label.create', compact('label'));
    }

    public function store(LabelStoreRequest $request)
    {
        $label = new Label();
        $label->fill($request->validated())->save();

        flash(__('views.label.flash.store'));
        return redirect()->route('labels.index');
    }

    public function edit(Label $label)
    {
        return view('label.edit', compact('label'));
    }

    public function update(LabelUpdateRequest $request, Label $label)
    {
        $label->fill($request->validated())->save();

        flash(__('views.label.flash.update'));
        return redirect()->route('labels.index');
    }

    public function destroy(Label $label)
    {
        if ($label->tasks->isNotEmpty()) {
            flash(__('views.label.flash.destroy.fail.constraint'));
        } else {
            $label->delete();
            flash(__('views.label.flash.destroy.success'));
        }
        return redirect()->route('labels.index');
    }
}
