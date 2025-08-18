<?php

namespace App\Livewire\Tasks;

use Livewire\Component;
use Illuminate\View\View;

class TaskManager extends Component
{
    public function render(): View
    {
        return view('livewire.tasks.task-manager');
    }
}