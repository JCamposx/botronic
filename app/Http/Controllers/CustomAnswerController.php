<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomAnswerRequest;
use App\Models\Bot;
use App\Models\CustomAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Bot $bot)
    {
        return view('bots.customize.create', compact('bot'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreCustomAnswer  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Bot $bot, StoreCustomAnswerRequest $request)
    {
        $data = $request->validated();

        $data['question'] = strtolower($data['question']);
        $data['bot_id'] = $bot->id;

        Auth::user()->customAnswers()->create($data);

        return redirect()->route('bots.show', $bot->id)->with('alert', [
            'message' => "Respuesta personalizada creada exitosamente.",
            'type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CustomAnswer  $customAnswer
     * @return \Illuminate\Http\Response
     */
    public function show(CustomAnswer $customAnswer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomAnswer  $customAnswer
     * @return \Illuminate\Http\Response
     */
    public function edit(Bot $bot, CustomAnswer $customAnswer)
    {
        return view('bots.customize.edit', compact('bot', 'customAnswer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\StoreCustomAnswerRequest  $request
     * @param  \App\Models\CustomAnswer  $customAnswer
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCustomAnswerRequest $request, Bot $bot, CustomAnswer $customAnswer)
    {
        $data = $request->validated();

        $customAnswer->update($data);

        return redirect()->route('bots.show', $bot->id)->with('alert', [
            'message' => "Respuesta personalizada actualizada correctamente",
            'type' => 'info'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomAnswer  $customAnswer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bot $bot, CustomAnswer $customAnswer)
    {
        $customAnswer->delete();

        return redirect()->route('bots.show', $bot->id)->with('alert', [
            'message' => "Respuesta personalizada eliminada exitosamente.",
            'type' => 'danger'
        ]);
    }
}
