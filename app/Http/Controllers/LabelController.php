<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $messages = [
            'name' => 'Это обязательное поле',
            'name.unique' => 'Метка с таким именем уже существует'
          ];

        $data = $this->validate($request, [
            'name' => 'required|unique:labels',
            'description' => 'nullable',
        ], $messages);

        $label = new Label();
        $label->fill($data)->save();

        flash(__('views.label.flash.store'));
        return redirect()->route('labels.index');
    }

  //  public function show(Label $label)
    //{
        //
    //}

    public function edit(Label $label)
    {
        return view('label.edit', compact('label'));
    }

    public function update(Request $request, Label $label)
    {
        $data = $request->all();

        $label->fill($data);

        $label->save();
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
