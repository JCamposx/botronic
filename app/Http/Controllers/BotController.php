<?php

namespace App\Http\Controllers;

use App\DBConnection\DBConnection;
use App\Http\Requests\StoreBotRequest;
use App\Models\Bot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use LDAP\Result;
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

        $table_names = $this->verify_db_and_tables($data);

        if (is_string($table_names)) {
            $message = $table_names;

            return back()->withInput($data)->with('alert', [
                'message' => "Conexión fallida: $message",
                'type' => 'danger'
            ]);
        }

        $data['table_names'] = json_encode($table_names);

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
        $user = Auth::user();

        $user->update(['selected_bot' => $bot->id]);

        $bot_id = Auth::user()->selected_bot;

        $bot = Bot::find($bot_id);

        return view('bots.show', compact('bot'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bot  $bot
     * @return \Illuminate\Http\Response
     */
    public function edit(Bot $bot)
    {
        $bot['table_names'] = implode(", ", json_decode($bot['table_names']));

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

        $table_names = $this->verify_db_and_tables($data);

        if (is_string($table_names)) {
            $message = $table_names;

            return back()->withInput($data)->with('alert', [
                'message' => "Conexión fallida: $message",
                'type' => 'danger'
            ]);
        }

        $data['table_names'] = json_encode($table_names);

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
            return $status_conn['message'];
        }

        $table_names = array_filter(preg_split('/[\ \n\,]+/', $data['table_names']));

        $status_tables = $this->check_tables($table_names);

        if (!$status_tables['success']) {
            return $status_tables['message'];
        }

        return $table_names;
    }
}
