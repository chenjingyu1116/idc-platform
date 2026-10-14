<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
class MemberController extends Controller {
    public function index() {
        $user = auth()->user();
        $levels = \App\Models\MemberLevel::orderBy('min_points')->get();
        return view('client.member.index', compact('user','levels'));
    }
}
