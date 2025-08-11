<?php

namespace App\Livewire\Tasks;

use App\Models\TaskList;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TaskManager extends Component
{
    public $showCreateListForm = false;

    public $newListName = "";

    public $isEditing = false;

    public $editingList;

    public function render()
    {
        return view('livewire.tasks.task-manager', [
            'taskLists' => TaskList::all()
        ]);
    }

    public function prepareCreateList()
    {
        $this->showCreateListForm = true;
        $this->isEditing = false;
        $this->newListName = "";
    }

    public function saveList()
    {
        $this->validate([
            'newListName' => 'required|min:3|max:100|unique:task_lists,name'
        ]);

        if ($this->isEditing) {
            $this->editingList->update([
                'name' => $this->newListName
            ]);
        } else{
            TaskList::create([
                'name' => $this->newListName,
                'user_id' => Auth::user()->id
            ]);
        }
        
        $this->reset();
    }

    public function cancelCreate()
    {
        $this->showCreateListForm = false;
        $this->newListName = '';
        $this->resetValidation();
    }

    public function editList(TaskList $taskList)
    {
        $this->showCreateListForm = true;
        $this->isEditing = true;
        $this->newListName = $taskList->name;
        $this->editingList = $taskList;
    }

    public function deleteList(TaskList $taskList)
    {
        $taskList->delete();
    }
}
