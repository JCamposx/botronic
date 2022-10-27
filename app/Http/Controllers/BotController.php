<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBotRequest;
use App\Models\Bot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use PDO;
use PDOException;

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

        $status_conn = $this->connectDB(
            $data['ip'],
            $data['username'],
            $data['password'],
            $data['db_name']
        );

        if (!$status_conn['success']) {
            $message = $status_conn['message'];

            return back()->withInput($data)->with('alert', [
                'message' => "Conexión fallida: $message",
                'type' => 'danger'
            ]);
        }

        $data['password'] = Hash::make($data['password']);

        $bot = Auth::user()->bots()->create($data);

        return redirect()->route('home')->with('alert', [
            'message' => "Bot \"$bot->name\" creado correctamente",
            'type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bot  $bot
     * @return \Illuminate\Http\Response
     */
    public function show(Bot $bot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bot  $bot
     * @return \Illuminate\Http\Response
     */
    public function edit(Bot $bot)
    {
        return view('bots.edit', compact('bot'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\StoreBotRequest  $request
     * @param  \App\Models\Bot  $bot
     * @return \Illuminate\Http\Response
     */
    public function update(StoreBotRequest $request, Bot $bot)
    {
        $data = $request->validated();

        $bot->update($data);

        return redirect()->route('home')->with('alert', [
            'message' => "Datos actualizados del bot \"$bot->name\"",
            'type' => 'info'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bot  $bot
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bot $bot)
    {
        //
    }

    /**
     * Connect to remote database
     *
     * @param string $ip
     * @param string $username
     * @param string $password
     * @param string $db_name
     * @return array[
     *      'success' => bool,
     *      'message' => string
     * ]
     */
    private function connectDB($ip, $username, $password, $db_name)
    {
        try {
            $conn = new PDO(
                "mysql:host=$ip;dbname=$db_name",
                $username,
                $password,
                [
                    PDO::ATTR_TIMEOUT => 5,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            );

            return [
                "success" => true,
                "message" => "Conexión exitosa"
            ];

            // $result = $conn->query("SELECT * FROM test");

            // $result->setFetchMode(PDO::FETCH_ASSOC);

            // foreach ($result as $r) {
            //     echo print_r($r);
            // }
        } catch (PDOException $e) {
            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        }
    }
}
