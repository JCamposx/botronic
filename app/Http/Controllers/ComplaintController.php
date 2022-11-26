<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComplaintRequest;
use App\Models\Complaint;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $complaints = Complaint::orderBy('status')->paginate(15);

        return view('complaints.index', compact('complaints'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('complaints.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreComplaintRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreComplaintRequest $request)
    {
        $data = $request->validated();

        $data['title'] = ucfirst(strtolower($data['title']));
        $data['message'] = ucfirst(strtolower($data['message']));

        Auth::user()->complaints()->create($data);

        return redirect()->route('home')->with('alert', [
            'message' => 'Reclamo creado correctamente',
            'type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Complaint  $complaint
     * @return \Illuminate\Http\Response
     */
    public function show(Complaint $complaint)
    {
        $this->authorize('view', $complaint);

        $user = User::find($complaint->user_id);

        return view('complaints.show', compact('complaint', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Complaint  $complaint
     * @return \Illuminate\Http\Response
     */
    public function update(Complaint $complaint)
    {
        $this->authorize('update', $complaint);

        $complaint->update([
            'status' => ($complaint->status === 0) ? 1 : 0,
        ]);

        return redirect()->route('complaints.index')->with('alert', [
            'message' => "Estado del reclado #$complaint->id actualizado correctamente.",
            'type' => 'info'
        ]);
    }
}
