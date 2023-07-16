<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSuggestionRequest;
use App\Models\Suggestion;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SuggestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suggestions = Suggestion::orderBy('status')->orderByDesc('id')->paginate(15);

        return view('suggestions.index', compact('suggestions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('suggestions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSuggestionRequest $request)
    {
        $data = $request->validated();

        $data['title'] = ucfirst(strtolower($data['title']));
        $data['message'] = ucfirst(strtolower($data['message']));

        Auth::user()->suggestions()->create($data);

        return redirect()->route('home')->with('alert', [
            'message' => session()->has('localization') && session()->get('localization') === 'es'
                ? 'Sugerencia creada correctamente'
                : 'Suggestion successfully created',
            'type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Suggestion  $suggestion
     * @return \Illuminate\Http\Response
     */
    public function show(Suggestion $suggestion)
    {
        $this->authorize('view', $suggestion);

        $user = User::find($suggestion->user_id);

        return view('suggestions.show', compact('suggestion', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Suggestion  $suggestion
     * @return \Illuminate\Http\Response
     */
    public function update(Suggestion $suggestion)
    {
        $this->authorize('update', $suggestion);

        $suggestion->update([
            'status' => ($suggestion->status === 0) ? 1 : 0,
        ]);

        return redirect()->route('suggestions.index')->with('alert', [
            'message' => session()->has('localization') && session()->get('localization') === 'es'
                ? "Estado de la sugerencia #$suggestion->id actualizada correctamente."
                : "Status of suggestion #$suggestion->id updated successfully.",
            'type' => 'info'
        ]);
    }
}
