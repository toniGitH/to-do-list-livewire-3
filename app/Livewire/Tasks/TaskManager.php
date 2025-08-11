<?php

namespace App\Livewire\Tasks;

use App\Models\TaskList;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TaskManager extends Component
{
    public $showCreateListForm = false;

    public $newListName = "";

    public function render()
    {
        return view('livewire.tasks.task-manager', [
            'taskLists' => TaskList::all()
        ]);
    }

    public function createList()
    {
        $this->validate([
            'newListName' => 'required|min:3|max:100|unique:task_lists,name'
        ]);

        TaskList::create([
            'name' => $this->newListName,
            'user_id' => Auth::user()->id
        ]);

        $this->reset();
    }

    public function cancelCreate()
    {
        $this->showCreateListForm = false;
        $this->newListName = '';
        $this->resetValidation();
    }
}
