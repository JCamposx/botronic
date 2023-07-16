<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocalizationController extends Controller
{
    public function __invoke($locale)
    {
        if (!in_array($locale, ['en', 'es'])) {
            return redirect()->back();
        }

        session()->put('localization', $locale);

        return redirect()->back();
    }
}
