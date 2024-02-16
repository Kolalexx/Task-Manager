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
        $data = $request->all();
        Label::create($data);
        flash(__('views.label.flash.store'));
        return redirect()->route('labels.index');
    }

    /**
     * Display the specified resource.
     */
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
