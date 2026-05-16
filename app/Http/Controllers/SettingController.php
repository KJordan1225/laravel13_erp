<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        $settings = CompanySetting::firstOrCreate([]);

        return view('settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = CompanySetting::firstOrCreate([]);

        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string'],
            'currency' => ['required', 'string', 'max:10'],
            'tax_rate' => ['required', 'numeric', 'min:0'],
            'logo' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo_path'] = $request->file('logo')->store('company', 'public');
        }

        unset($validated['logo']);

        $settings->update($validated);

        return redirect()
            ->route('settings.edit')
            ->with('success', 'Company settings updated successfully.');
    }
}
