<?php

namespace App\Http\Controllers;

use App\Models\BoardingHouse;
use Illuminate\Http\Request;

class PublicBoardingHouseController extends Controller
{
    /**
     * Display the public landing page for a boarding house.
     */
    public function show(string $slug)
    {
        // Fetch boarding house by slug with public visibility enabled
        $boardingHouse = BoardingHouse::with([
            'facilities',
            'galleries',
            'rules' => function ($query) {
                $query->where('is_active', true)->where('is_visible_public', true);
            },
            'rooms' => function ($query) {
                $query->available(); // list available rooms
            }
        ])
        ->where('slug', $slug)
        ->where('is_public', true)
        ->firstOrFail();

        // Dynamically parse custom visual settings if any
        $settings = $boardingHouse->settings ?? [];
        $primaryColor = $settings['primary_color'] ?? '#4f46e5'; // default indigo-600
        $instagram = $settings['social_instagram'] ?? '';
        $facebook = $settings['social_facebook'] ?? '';
        
        return view('public.boarding-house.show', compact('boardingHouse', 'primaryColor', 'instagram', 'facebook'));
    }
}
