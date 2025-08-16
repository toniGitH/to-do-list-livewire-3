<?php

namespace App\Livewire\Tasks;

use App\Models\TaskList;
use App\Models\Task;
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

    public bool $isEditingList = false;
    public bool $isEditingTask = false;

    public ?TaskList $editingList;
    public ?TaskList $selectedList;
    public ?Task $editingTask;

    public function render(): View
    {
        return view('livewire.tasks.task-manager', [
            'taskLists' => Auth::user()->lists
        ]);
    }

    public function prepareCreateList(): void
    {
        $this->showCreateListForm = true;
        $this->isEditingList = false;
        $this->newListName = "";
    }

    public function saveList(): void
    {
        $this->validate([
            'newListName' => $this->isEditingList
                ? 'required|min:3|max:100|unique:task_lists,name,' . $this->editingList->id
                : 'required|min:3|max:100|unique:task_lists,name'
        ]);

        if ($this->isEditingList) {
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
        $this->isEditingList = true;
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

    public function editTask(Task $task): void
    {
        $this->editingTask = $task;
        $this->showCreateTaskForm = true;
        $this->isEditingTask = true;
        $this->newTaskName = $task->title;
        $this->newTaskDescription = $task->description;
    }

    protected function messages(): array
    {
        return [
            'newListName.unique' => 'This list name has already been taken'
        ];
    }
}
