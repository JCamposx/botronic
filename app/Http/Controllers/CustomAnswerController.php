<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomAnswerRequest;
use App\Models\Bot;
use App\Models\CustomAnswer;
use Illuminate\Support\Facades\Auth;

class CustomAnswerController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Bot  $bot
     * @return \Illuminate\Http\Response
     */
    public function create(Bot $bot)
    {
        return view('bots.customize.create', compact('bot'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\Bot  $bot
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bot  $bot
     * @param  \App\Models\CustomAnswer  $customAnswer
     * @return \Illuminate\Http\Response
     */
    public function edit(Bot $bot, CustomAnswer $customAnswer)
    {
        $this->authorize('update', $customAnswer);

        return view('bots.customize.edit', compact('bot', 'customAnswer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\StoreCustomAnswerRequest  $request
     * @param  \App\Models\Bot  $bot
     * @param  \App\Models\CustomAnswer  $customAnswer
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCustomAnswerRequest $request, Bot $bot, CustomAnswer $customAnswer)
    {
        $this->authorize('update', $customAnswer);

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
     * @param  \App\Models\Bot  $bot
     * @param  \App\Models\CustomAnswer  $customAnswer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bot $bot, CustomAnswer $customAnswer)
    {
        $this->authorize('delete', $customAnswer);

        $customAnswer->delete();

        return redirect()->route('bots.show', $bot->id)->with('alert', [
            'message' => "Respuesta personalizada eliminada exitosamente.",
            'type' => 'danger'
        ]);
    }
}
