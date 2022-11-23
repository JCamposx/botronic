<?php

namespace App\Http\Controllers;

use App\DBConnection\DBAdminDashboard;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        // User is admin
        if ($user->type === 1) {
            $user_bots_allowed = DBAdminDashboard::getUserBotsAllowedInfo();
            $user_bots_created = DBAdminDashboard::getUserBotsCreatedInfo();
            $questions_without_answer = DBAdminDashboard::getUserQuestionToBotWithoutAnswerInfo();
            $db_info = DBAdminDashboard::getDBInfo();

            return view('home.admin', compact(
                'user_bots_allowed',
                'user_bots_created',
                'questions_without_answer',
                'db_info',
            ));
        }

        // User is normal user
        return view('home.user', [
            'bots' => Auth::user()->bots()->latest()->take(6)->get()
        ]);
    }
}
