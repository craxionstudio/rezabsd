<?php

namespace App\Http\Controllers;

use App\Models\AboutContent;
use App\Models\Setting;
use Inertia\Inertia;
use Inertia\Response;

class AboutController extends Controller
{
    public function index(): Response
    {
        $settings = Setting::current();

        $sameAs = array_values(array_filter([
            $settings->instagram,
            $settings->facebook,
            $settings->tiktok,
        ]));

        return Inertia::render('About', [
            'content' => AboutContent::current(),
            'seo' => [
                'title' => 'About Us',
                'description' => "Kenali {$settings->nama_sales}, {$settings->jabatan} dari {$settings->nama_agensi}.",
            ],
            'jsonLd' => [
                '@context' => 'https://schema.org',
                '@type' => 'Person',
                'name' => $settings->nama_sales,
                'jobTitle' => $settings->jabatan,
                'worksFor' => [
                    '@type' => 'RealEstateAgent',
                    'name' => $settings->nama_agensi,
                ],
                'sameAs' => $sameAs,
            ],
        ]);
    }
}
