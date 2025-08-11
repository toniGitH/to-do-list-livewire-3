<?php

namespace App\Livewire\Tasks;

use App\Models\TaskList;
use Livewire\Component;

class TaskManager extends Component
{
    public $showCreateListForm = false;
    
    public function render()
    {
        return view('livewire.tasks.task-manager', [
            'taskLists' => TaskList::all()
        ]);
    }
}
