<?php

namespace App\Livewire\CMS;

use App\Models\CmsMenu;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CmsMenuEditor extends Component
{
    public string $selectedSlug = 'header_menu';
    public array $menuItems = [];

    // Fields for adding new item
    public string $newItemLabel = '';
    public string $newItemUrl = '';
    public string $newItemTarget = '_self';

    public function mount(): void
    {
        if (!\Illuminate\Support\Facades\Auth::user()->hasRole('super_admin')) {
            abort(403, 'Unauthorized. Super Admin access only.');
        }

        $this->loadMenu();
    }

    public function loadMenu(): void
    {
        $menu = CmsMenu::where('slug', $this->selectedSlug)->first();
        if ($menu) {
            $this->menuItems = $menu->items ?? [];
        } else {
            $this->menuItems = [];
        }
    }

    public function updatedSelectedSlug(): void
    {
        $this->loadMenu();
    }

    public function addMenuItem(): void
    {
        $this->validate([
            'newItemLabel' => ['required', 'string', 'max:255'],
            'newItemUrl' => ['required', 'string', 'max:255'],
        ]);

        $this->menuItems[] = [
            'label' => $this->newItemLabel,
            'url' => $this->newItemUrl,
            'target' => $this->newItemTarget,
            'children' => [],
        ];

        $this->newItemLabel = '';
        $this->newItemUrl = '';
        $this->newItemTarget = '_self';
    }

    public function removeMenuItem(int $index): void
    {
        unset($this->menuItems[$index]);
        $this->menuItems = array_values($this->menuItems);
    }

    public function moveItem(int $index, string $direction): void
    {
        $targetIndex = $direction === 'up' ? $index - 1 : $index + 1;

        if ($targetIndex >= 0 && $targetIndex < count($this->menuItems)) {
            $temp = $this->menuItems[$index];
            $this->menuItems[$index] = $this->menuItems[$targetIndex];
            $this->menuItems[$targetIndex] = $temp;
        }
    }

    /**
     * Add a child item under a specific parent item.
     */
    public function addChildItem(int $parentIdx, string $label, string $url): void
    {
        if (empty($label) || empty($url)) return;

        $this->menuItems[$parentIdx]['children'][] = [
            'label' => $label,
            'url' => $url,
            'target' => '_self',
            'children' => [],
        ];
    }

    public function removeChildItem(int $parentIdx, int $childIdx): void
    {
        unset($this->menuItems[$parentIdx]['children'][$childIdx]);
        $this->menuItems[$parentIdx]['children'] = array_values($this->menuItems[$parentIdx]['children']);
    }

    public function saveMenu(): void
    {
        $menu = CmsMenu::updateOrCreate(
            ['slug' => $this->selectedSlug],
            ['name' => ucwords(str_replace('_', ' ', $this->selectedSlug)), 'items' => $this->menuItems]
        );

        activity_log(
            event: 'cms.menu_update',
            description: "CMS menu updated: {$menu->name}",
            userId: Auth::id()
        );

        $this->dispatch('toast', ['type' => 'success', 'message' => 'Menu layout successfully saved!']);
    }

    public function render()
    {
        return view('livewire.cms.cms-menu-editor');
    }
}
