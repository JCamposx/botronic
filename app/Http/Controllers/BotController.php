<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBotRequest;
use App\Models\Bot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BotController extends Controller
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
    public function create()
    {
        return view('bots.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreBotRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBotRequest $request)
    {
        $data = $request->validated();

        $bot = Auth::user()->bots()->create($data);

        return redirect()->route('home')->with('alert', [
            'message' => "Bot \"$bot->name\" creado correctamente",
            'type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bot  $chatbot
     * @return \Illuminate\Http\Response
     */
    public function show(Bot $chatbot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bot  $chatbot
     * @return \Illuminate\Http\Response
     */
    public function edit(Bot $chatbot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bot  $chatbot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bot $chatbot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bot  $chatbot
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bot $chatbot)
    {
        //
    }
}
