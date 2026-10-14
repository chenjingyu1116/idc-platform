<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\Setting\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        SettingService::init();
        $settings = Setting::orderBy('group_name')->orderBy('key')->get()->groupBy('group_name');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);
        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }
        Setting::forget();
        return back()->with('success', '设置已保存');
    }
}
