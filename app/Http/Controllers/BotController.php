<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBotRequest;
use App\Models\Bot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use PDO;
use PDOException;

class BotController extends Controller
{
    public function __construct()
    {
        $this->conn = null;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bots = Auth::user()
            ->bots()
            ->orderBy('name')
            ->paginate(9);

        return view('bots.index', compact('bots'));
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

        $result = $this->verify_db_and_tables($data);

        if (!$result['success']) {
            $message = $result['message'];

            return back()->withInput($data)->with('alert', [
                'message' => "Conexión fallida: $message",
                'type' => 'danger'
            ]);
        }

        $data['table_names'] = json_encode($data['table_names']);

        $data['password'] = Crypt::encryptString($data['password']);

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
        $this->authorize('view', $bot);

        Auth::user()->update(['selected_bot' => $bot->id]);

        $user_answers = Auth::user()
            ->userAnswers()
            ->where('bot_id', $bot->id)
            ->orderByDesc('quantity')
            ->get();

        $messages = [];
        $quantities = [];

        foreach ($user_answers as $row) {
            array_push($messages, $row['message']);
            array_push($quantities, $row['quantity']);
            if (count($messages) === 5) break;
        }

        $user_answers = [$messages, $quantities];

        $table_answers = Auth::user()
            ->tableAnswers()
            ->where('bot_id', $bot->id)
            ->orderByDesc('quantity')
            ->get();

        $table_names = [];
        $quantities = [];

        foreach ($table_answers as $row) {
            array_push($table_names, $row['table_name']);
            array_push($quantities, $row['quantity']);
            if (count($table_names) === 5) break;
        }

        $table_answers = [$table_names, $quantities];

        $custom_answers = Auth::user()
            ->customAnswers()
            ->where('bot_id', $bot->id)
            ->get();

        return view('bots.show', compact('bot', 'user_answers', 'table_answers', 'custom_answers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bot  $bot
     * @return \Illuminate\Http\Response
     */
    public function edit(Bot $bot)
    {
        $this->authorize('update', $bot);

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
        $this->authorize('update', $bot);

        $data = $request->validated();

        $result = $this->verify_db_and_tables($data);

        if (!$result['success']) {
            $message = $result['message'];

            return back()->withInput($data)->with('alert', [
                'message' => "Conexión fallida: $message",
                'type' => 'danger'
            ]);
        }

        $data['password'] = Crypt::encryptString($data['password']);

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
        $this->authorize('delete', $bot);

        $bot->delete();

        return back()->with('alert', [
            'message' => "El bot \"$bot->name\" ha sido eliminado correctamente",
            'type' => 'danger'
        ]);
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
    private function connect_db($ip, $username, $password, $db_name)
    {
        try {
            $this->conn = new PDO(
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
        } catch (PDOException $e) {
            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        }
    }

    /**
     * Check if tables exists in previous connected database
     *
     * @param array<string> $table_names
     * @return array[
     *      'success' => bool,
     *      'message' => string
     * ]
     */
    private function check_tables($table_names)
    {
        try {
            foreach ($table_names as $table_name) {
                $result = $this->conn->query("SELECT * FROM $table_name");

                $result->setFetchMode(PDO::FETCH_ASSOC);
            }

            return [
                "success" => true,
                "message" => "Tablas correctas"
            ];
        } catch (PDOException $e) {
            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        }
    }

    /**
     * Check database and tables information
     *
     * @param array $data
     * @return string|array
     */
    private function verify_db_and_tables($data)
    {
        $status_conn = $this->connect_db(
            $data['ip'],
            $data['username'],
            $data['password'],
            $data['db_name']
        );

        if (!$status_conn['success']) {
            return $status_conn;
        }

        $status_tables = $this->check_tables($data['table_names']);

        return $status_tables;
    }
}
