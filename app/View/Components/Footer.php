<?php

namespace App\View\Components;

use Closure;
use App\Models\Files;
use App\Models\Pastebin;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Footer extends Component
{
    public $files;
    public $total;
    public $pastebin;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->files = Files::count();
        $this->pastebin = Pastebin::count();
        $this->total = $this->total + $this->pastebin;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.footer');
    }
}
