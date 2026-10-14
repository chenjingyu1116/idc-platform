<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Renewal;
use App\Services\Providers\ProviderFactory;
use Illuminate\Http\Request;
class ServiceController extends Controller {
    public function index() {
        $services = Service::where('user_id', auth()->id())->with('product')->latest()->get();
        return view('client.services.index', compact('services'));
    }
    public function show(Service $service) {
        if ($service->user_id !== auth()->id()) abort(403);
        $renewals = Renewal::where('service_id',$service->id)->latest()->limit(10)->get();
        return view('client.services.show', compact('service','renewals'));
    }
    public function renew(Request $request, Service $service) {
        if ($service->user_id !== auth()->id()) abort(403);
        if (!$service->product) return back()->with('error','产品不存在');
        $cycle = $request->input('cycle', 'monthly');
        $amount = $service->product->price;
        $user = auth()->user();
        if ($user->balance < $amount) return back()->with('error',"余额不足，需 ¥{$amount}");
        $user->decrement('balance', $amount);
        $newExpires = ($service->expires_at && $service->expires_at->isFuture())
            ? $service->expires_at->copy()->addMonth()
            : now()->addMonth();
        $service->update(['expires_at'=>$newExpires, 'status'=>'active']);
        Renewal::create([
            'service_id' => $service->id,
            'user_id' => $user->id,
            'amount' => $amount,
            'cycle' => $cycle,
            'started_at' => now(),
            'expires_at' => $newExpires,
            'status' => 'paid',
        ]);
        return back()->with('success','续费成功，新到期时间：'.$newExpires->format('Y-m-d'));
    }
    public function suspend(Service $service) {
        if ($service->user_id !== auth()->id()) abort(403);
        $provider = ProviderFactory::make($service->provider);
        if ($provider->suspend($service)) return back()->with('success','已暂停');
        return back()->with('error','暂停失败');
    }
    public function unsuspend(Service $service) {
        if ($service->user_id !== auth()->id()) abort(403);
        $provider = ProviderFactory::make($service->provider);
        if ($provider->unsuspend($service)) return back()->with('success','已恢复');
        return back()->with('error','恢复失败');
    }
}
