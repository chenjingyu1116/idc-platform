<?php
namespace App\Http\Middleware;
use App\Models\ApiToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class ApiTokenAuth {
    public function handle(Request $request, Closure $next): Response {
        $token = $request->bearerToken() ?? $request->input('token');
        if (!$token) return response()->json(['code'=>401,'msg'=>'缺少 Token'], 401);
        $apiToken = ApiToken::where('token', $token)->first();
        if (!$apiToken) return response()->json(['code'=>401,'msg'=>'Token 无效'], 401);
        if ($apiToken->expires_at && $apiToken->expires_at->isPast()) {
            return response()->json(['code'=>401,'msg'=>'Token 已过期'], 401);
        }
        $apiToken->update(['last_used_at' => now()]);
        auth()->login($apiToken->user);
        return $next($request);
    }
}
