<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class Header extends Component
{
    public $tenants;
    public $currentTenant;
    public $notifications;
    public $unreadCount;
    public array $breadcrumbs = [];

    public function __construct()
    {
        $user = Auth::user();
        
        $this->tenants = $user ? $user->tenants()->where('is_active', true)->get() : collect();
        $this->currentTenant = tenant();
        $this->notifications = $user ? \App\Models\InAppNotification::where('user_id', $user->id)->whereNull('read_at')->latest()->take(5)->get() : collect();
        $this->unreadCount = $user ? \App\Models\InAppNotification::where('user_id', $user->id)->whereNull('read_at')->count() : 0;

        $this->generateBreadcrumbs();
    }

    protected function generateBreadcrumbs(): void
    {
        $segments = request()->segments();
        $url = '';

        foreach ($segments as $segment) {
            $url .= '/' . $segment;
            
            // Skip UUID or dynamic parameters in breadcrumb labels
            if (preg_match('/^[0-9a-fA-F-]{36}$/', $segment)) {
                continue;
            }

            $this->breadcrumbs[] = [
                'name' => ucwords(str_replace('-', ' ', $segment)),
                'url' => url($url),
            ];
        }
    }

    public function render()
    {
        return view('components.header');
    }
}
