<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Models\Service;
class RenewController extends Controller {
    public function index() {
        $services = Service::where('user_id', auth()->id())->with('product')->latest()->get();
        return view('client.renew.index', compact('services'));
    }
    public function renew(Service $service) {
        if ($service->user_id !== auth()->id()) abort(403);
        $product = $service->product;
        if (!$product) return back()->with('error', '产品不存在');
        $user = auth()->user();
        if ($user->balance < $product->price) return back()->with('error', '余额不足');
        $user->decrement('balance', $product->price);
        $service->update(['expires_at' => ($service->expires_at ?? now())->addMonth()]);
        return back()->with('success', '续费成功！');
    }
}
