<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\ApiToken;
use Illuminate\Http\Request;
class TokenController extends Controller {
    public function index() {
        $tokens = ApiToken::where('user_id', auth()->id())->latest()->get();
        return response()->json(['code'=>0,'data'=>$tokens]);
    }
    public function create(Request $request) {
        $token = ApiToken::generate(auth()->user(), $request->name ?? 'API Token');
        return response()->json(['code'=>0,'data'=>$token,'message'=>'请保存好 token，只显示一次']);
    }
    public function destroy($id) {
        ApiToken::where('user_id', auth()->id())->where('id', $id)->delete();
        return response()->json(['code'=>0]);
    }
}
