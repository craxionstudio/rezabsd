<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $settings = Setting::current();

        return [
            ...parent::share($request),
            'settings' => [
                'nama_sales' => $settings->nama_sales,
                'jabatan' => $settings->jabatan,
                'nama_agensi' => $settings->nama_agensi,
                'whatsapp' => $settings->whatsapp,
                'email' => $settings->email,
                'alamat_agensi' => $settings->alamat_agensi,
                'instagram' => $settings->instagram,
                'facebook' => $settings->facebook,
                'tiktok' => $settings->tiktok,
                'bio' => $settings->bio,
                'disclaimer' => $settings->disclaimer,
                'foto_profil' => $settings->fotoProfilUrl(),
            ],
        ];
    }
}
