<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomAnswerRequest;
use App\Models\DefaultBotAnswer;

class DefaultBotAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $default_answers = DefaultBotAnswer::all();

        return view('bots.default.index', compact('default_answers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bots.default.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreCustomAnswerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomAnswerRequest $request)
    {
        $data = $request->validated();

        $data['question'] = strtolower($data['question']);

        DefaultBotAnswer::create($data);

        return redirect()->route('default-answers.index')->with('alert', [
            'message' => 'Respuesta predeterminada creada exitosamente.',
            'type' => 'success'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DefaultBotAnswer  $default_answer
     * @return \Illuminate\Http\Response
     */
    public function edit(DefaultBotAnswer $default_answer)
    {
        return view('bots.default.edit', compact('default_answer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\StoreCustomAnswerRequest  $request
     * @param  \App\Models\DefaultBotAnswer  $default_answer
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCustomAnswerRequest $request, DefaultBotAnswer $default_answer)
    {
        $data = $request->validated();

        $default_answer->update($data);

        return redirect()->route('default-answers.index')->with('alert', [
            'message' => "Respuesta predeterminada #$default_answer->id editada exitosamente.",
            'type' => 'info'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DefaultBotAnswer  $default_answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(DefaultBotAnswer $default_answer)
    {
        $default_answer->delete();

        return redirect()->route('default-answers.index')->with('alert', [
            'message' => 'Respuesta predeterminada eliminada exitosamente.',
            'type' => 'danger'
        ]);
    }
}
