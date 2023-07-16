<?php

namespace App\DBConnection;

use App\Models\Bot;
use App\Models\Complaint;
use App\Models\User;
use App\Models\UserAnswer;

class DBAdminDashboard
{

    /**
     * Get information about bots allowed for each user.
     *
     * @return array<
     *  array<string>,
     *  array<int>
     * >
     */
    public static function getUserBotsAllowedInfo()
    {
        $user_bots_allowed = User::where('type', 0)
            ->orderByDesc('allowed_bots')
            ->take(10)
            ->get();

        $labels = [];
        $data = [];

        foreach ($user_bots_allowed as $row) {
            array_push($labels, $row['email']);
            array_push($data, $row['allowed_bots']);
        }

        return [$labels, $data];
    }

    /**
     * Get information about bots created for each user.
     *
     * @return array<
     *  array<string>,
     *  array<int>
     * >
     */
    public static function getUserBotsCreatedInfo()
    {
        $user_bots_allowed = User::where('type', 0)
            ->orderByDesc('created_bots')
            ->take(10)
            ->get();

        $labels = [];
        $data = [];

        foreach ($user_bots_allowed as $row) {
            array_push($labels, $row['email']);
            array_push($data, $row['created_bots']);
        }

        return [$labels, $data];
    }

    /**
     * Get information about all inputs to bots without default answer.
     *
     * @return array<
     *  array<string>,
     *  array<int>
     * >
     */
    public static function getUserQuestionToBotWithoutAnswerInfo()
    {
        $questions_without_answer = UserAnswer::select('message', 'quantity')
            ->orderByDesc('quantity')
            ->take(10)
            ->get();

        $arr = [];

        foreach ($questions_without_answer as $row) {
            if (!isset($arr[$row['message']])) {
                $arr[$row['message']] = $row['quantity'];
            } else {
                $arr[$row['message']] += $row['quantity'];
            }
        }

        $labels = [];
        $data = [];

        foreach ($arr as $key => $value) {
            array_push($labels, $key);
            array_push($data, $value);
        }

        return [$labels, $data];
    }

    /**
     * Get general information about the database.
     *
     * @return array<array<string, int>>
     */
    public static function getDBInfo()
    {
        $info = [];

        array_push($info, [
            'field' => session()->has('localization') && session()->get('localization') === 'es'
                ? 'Total de usuarios'
                : 'Total users',
            'quantity' => count(User::where('type', 0)->get())
        ]);

        array_push($info, [
            'field' => session()->has('localization') && session()->get('localization') === 'es'
                ? 'Total de bots'
                : 'Total bots',
            'quantity' => count(Bot::all())
        ]);

        array_push($info, [
            'field' => session()->has('localization') && session()->get('localization') === 'es'
                ? 'Total de reclamos'
                : 'Total complaints',
            'quantity' => count(Complaint::all())
        ]);

        return $info;
    }
}
