<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function edit()
    {
        return view('admin.settings.edit', [
            'settings' => SiteSetting::current(),
        ]);
    }

    public function update(Request $request)
    {
        $settings = SiteSetting::current();

        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:80'],
            'tagline' => ['nullable', 'string', 'max:160'],
            'description' => ['nullable', 'string', 'max:600'],
            'contact_email' => ['nullable', 'email', 'max:150'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:400'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'default_meta_title' => ['nullable', 'string', 'max:160'],
            'default_meta_description' => ['nullable', 'string', 'max:255'],
        ]);

        $settings->update($data);

        AuditLog::create([
            'user_id' => $request->user()->id,
            'action' => 'Update site settings',
            'auditable_type' => SiteSetting::class,
            'auditable_id' => $settings->id,
            'ip_address' => $request->ip(),
        ]);

        return back()->with('status', 'Site settings berhasil diperbarui.');
    }
}
