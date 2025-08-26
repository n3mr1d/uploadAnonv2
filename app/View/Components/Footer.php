<?php

namespace App\View\Components;

use App\Models\Files;
use App\Models\Pastebin;
use App\Models\Visitor;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Footer extends Component
{
    public $files;

    public $total;

    public $viewer;

    public $pastebin;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->files = Files::count();
        $this->pastebin = Pastebin::count();
        $this->viewer = Visitor::count();
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
