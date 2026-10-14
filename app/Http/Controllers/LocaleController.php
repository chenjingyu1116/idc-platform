<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function switch(Request $request, string $locale)
    {
        if (!in_array($locale, ['zh_CN', 'en'])) {
            $locale = 'zh_CN';
        }
        session(['locale' => $locale]);
        app()->setLocale($locale);
        return back();
    }
}
