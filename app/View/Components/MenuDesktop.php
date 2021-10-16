<?php

namespace App\View\Components;

use App\Services\MenuService;
use Illuminate\View\Component;

class MenuDesktop extends Component
{
    public $topMenu;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $this->topMenu = $this->menuService->getTopMenu();
        
        return view('web.components.menu-desktop');
    }
}
