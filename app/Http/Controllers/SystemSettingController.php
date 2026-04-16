<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SystemSettingController extends Controller
{
   public function index() {
        if(!auth()->user()->isAdmin()) abort(403);
        $settings = \App\Models\SystemSetting::all();
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request, $id) {
        $setting = \App\Models\SystemSetting::findOrFail($id);
        $setting->update(['setting_value' => $request->setting_value]);
        return back()->with('success', 'Setting updated!');
    }
}
