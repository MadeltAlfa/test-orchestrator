<?php

declare(strict_types=1);

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Path to the settings JSON store.
     */
    protected string $settingsPath = 'settings.json';

    /**
     * Get default application settings.
     *
     * @return array<string, mixed>
     */
    protected function getDefaults(): array
    {
        return [
            'institution_name' => 'Universitas Negeri Yogyakarta',
            'contact_email' => 'admin@uny.ac.id',
            'registration_enabled' => true,
            'default_pagination' => 10,
            'min_suitable_score' => 60.00,
        ];
    }

    /**
     * Read settings from the JSON store.
     *
     * @return array<string, mixed>
     */
    protected function readSettings(): array
    {
        if (!Storage::exists($this->settingsPath)) {
            $defaults = $this->getDefaults();
            Storage::put($this->settingsPath, json_encode($defaults, JSON_PRETTY_PRINT));
            return $defaults;
        }

        try {
            $content = Storage::get($this->settingsPath);
            return array_merge($this->getDefaults(), json_decode($content, true) ?? []);
        } catch (\Throwable $e) {
            Log::error('Gagal membaca file settings.json: ' . $e->getMessage());
            return $this->getDefaults();
        }
    }

    /**
     * Display the settings form.
     */
    public function index()
    {
        $settings = $this->readSettings();

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update application settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'institution_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'registration_enabled' => 'nullable|boolean',
            'default_pagination' => 'required|integer|min:5|max:100',
            'min_suitable_score' => 'required|numeric|min:0|max:100',
        ]);

        try {
            // Normalize boolean
            $validated['registration_enabled'] = $request->has('registration_enabled');

            // Save to JSON store
            Storage::put(
                $this->settingsPath, 
                json_encode($validated, JSON_PRETTY_PRINT)
            );

            return redirect()
                ->route('superadmin.settings.index')
                ->with('success', 'Pengaturan sistem berhasil diperbarui!');
        } catch (\Throwable $e) {
            Log::error('Gagal memperbarui settings.json: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan pengaturan.');
        }
    }
}
