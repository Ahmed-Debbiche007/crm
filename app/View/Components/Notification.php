<?php

namespace App\View\Components;

namespace App\View\Components;

use App\Models\Echeances;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Notification extends Component
{
    public $echeances;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->echeances = Echeances::where(function ($query) {
            $query->where('date', '<=', now()->addDays(1))
                ->orWhere('date', '<=', now());
        })->where('payed', '=', 0)->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.notifications');
    }

}