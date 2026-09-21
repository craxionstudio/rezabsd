<?php

namespace App\Http\Controllers;

use App\Models\LegalContent;
use Inertia\Inertia;
use Inertia\Response;

class LegalController extends Controller
{
    public function privacy(): Response
    {
        return Inertia::render('Legal/Show', [
            'title' => 'Kebijakan Privasi',
            'content' => LegalContent::current()->privacy_policy,
            'seo' => [
                'title' => 'Kebijakan Privasi',
                'description' => 'Kebijakan privasi penggunaan website ini.',
                'canonical' => url('/kebijakan-privasi'),
            ],
        ]);
    }

    public function terms(): Response
    {
        return Inertia::render('Legal/Show', [
            'title' => 'Syarat & Ketentuan',
            'content' => LegalContent::current()->terms_conditions,
            'seo' => [
                'title' => 'Syarat & Ketentuan',
                'description' => 'Syarat dan ketentuan penggunaan website ini.',
                'canonical' => url('/syarat-ketentuan'),
            ],
        ]);
    }
}
