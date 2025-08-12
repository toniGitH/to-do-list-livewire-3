<?php

namespace App\Livewire\Tasks;

use App\Models\TaskList;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TaskManager extends Component
{
    public bool $showCreateListForm = false;

    public string $newListName = "";

    public bool $isEditing = false;

    public ?TaskList $editingList;

    public function render(): View
    {
        return view('livewire.tasks.task-manager', [
            'taskLists' => TaskList::all()
        ]);
    }

    public function prepareCreateList(): void
    {
        $this->showCreateListForm = true;
        $this->isEditing = false;
        $this->newListName = "";
    }

    public function saveList(): void
    {
        $this->validate([
            'newListName' => $this->isEditing 
                ? 'required|min:3|max:100|unique:task_lists,name,' . $this->editingList->id
                : 'required|min:3|max:100|unique:task_lists,name'
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

    public function cancelCreate(): void
    {
        $this->showCreateListForm = false;
        $this->newListName = '';
        $this->resetValidation();
    }

    public function editList(TaskList $taskList): void
    {
        $this->showCreateListForm = true;
        $this->isEditing = true;
        $this->newListName = $taskList->name;
        $this->editingList = $taskList;
    }

    public function deleteList(TaskList $taskList): void
    {
        $taskList->delete();
    }

}
