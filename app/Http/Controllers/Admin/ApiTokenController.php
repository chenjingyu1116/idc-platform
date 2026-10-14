<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\ApiToken;
class ApiTokenController extends Controller {
    public function index() {
        $tokens = ApiToken::with('user')->latest()->paginate(20);
        return view('admin.api-tokens.index', compact('tokens'));
    }
}
