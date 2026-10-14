<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Service;
class ApiController extends Controller {
    public function me() {
        $user = auth()->user();
        return response()->json(['code'=>0,'data'=>['id'=>$user->id,'name'=>$user->name,'email'=>$user->email,'balance'=>$user->balance]]);
    }
    public function services() {
        $list = Service::where('user_id', auth()->id())->get();
        return response()->json(['code'=>0,'data'=>$list]);
    }
    public function orders() {
        $list = Order::where('user_id', auth()->id())->get();
        return response()->json(['code'=>0,'data'=>$list]);
    }
}
