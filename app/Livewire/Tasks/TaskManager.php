<?php

namespace App\Livewire\Tasks;

use App\Models\TaskList;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TaskManager extends Component
{
    public string $newListName = "";
    public string $newTaskName = "";
    public string $newTaskDescription = "";

    public bool $showCreateListForm = false;
    public bool $showCreateTaskForm = false;

    public bool $isEditing = false;

    public ?TaskList $editingList;
    public ?TaskList $selectedList;

    public function render(): View
    {
        return view('livewire.tasks.task-manager', [
            'taskLists' => Auth::user()->lists
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

    public function cancelCreateList(): void
    {
        $this->showCreateListForm = false;
        $this->newListName = '';
        $this->resetValidation();
    }

    public function cancelCreateTask(): void
    {
        $this->showCreateTaskForm = false;
        $this->newTaskName = '';
        $this->newTaskDescription = '';
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

    public function selectList(TaskList $taskList): void
    {
        $this->selectedList = $taskList;
    }

    public function saveTask(): void
    {
        $this->validate([
            'newTaskName' => 'required|min:3|max:255',
            'newTaskDescription' => "nullable|max:255"
        ]);

        $this->selectedList->tasks()->create([
            'title' => $this->newTaskName,
            'description' => $this->newTaskDescription
        ]);

        $this->reset('newTaskName', 'newTaskDescription', 'showCreateTaskForm');
    }

    protected function messages(): array
    {
        return [
            'newListName.unique' => 'This list name has already been taken'
        ];
    }
}
