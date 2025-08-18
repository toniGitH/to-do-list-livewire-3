<?php

namespace App\Livewire\Tasks;

use App\Models\TaskList;
use App\Models\Task;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\View\View;

class TasksPanel extends Component
{
    public string $newTaskName = "";
    public string $newTaskDescription = "";
    public bool $showCreateTaskForm = false;
    public bool $isEditingTask = false;
    public ?TaskList $selectedList = null;
    public ?Task $editingTask = null;

    public function render(): View
    {
        return view('livewire.tasks.tasks-panel');
    }

    #[On('list-selected')] // Método que se ejecuta al lanzarse este evento en TasksLists
    public function handleListSelected($listId): void
    {
        $this->selectedList = TaskList::find($listId);
        $this->showCreateTaskForm = false;
        $this->resetTaskForm();
    }

    #[On('list-deselected')] // Método que se ejecuta al lanzarse este evento en TasksLists
    public function handleListDeselected(): void
    {
        $this->selectedList = null;
        $this->showCreateTaskForm = false;
        $this->resetTaskForm();
    }

    public function prepareCreateTask(): void
    {
        $this->showCreateTaskForm = true;
        $this->isEditingTask = false;
        $this->newTaskName = "";
        $this->newTaskDescription = "";
        $this->resetValidation();
    }

    public function saveTask(): void
    {
        $this->validate([
            'newTaskName' => 'required|min:3|max:255',
            'newTaskDescription' => "nullable|max:255"
        ]);

        if ($this->isEditingTask) {
            $this->editingTask->update([
                'title' => $this->newTaskName,
                'description' => $this->newTaskDescription
            ]);
        } else {
            $this->selectedList->tasks()->create([
                'title' => $this->newTaskName,
                'description' => $this->newTaskDescription
            ]);
        }

        $this->resetTaskForm();

        $this->selectedList = $this->selectedList->fresh();
    }

    public function cancelCreateTask(): void
    {
        $this->resetTaskForm();
    }

    public function editTask(Task $task): void
    {
        $this->editingTask = $task;
        $this->showCreateTaskForm = true;
        $this->isEditingTask = true;
        $this->newTaskName = $task->title;
        $this->newTaskDescription = $task->description ?? '';
        $this->resetValidation();
    }

    public function deleteTask(Task $task): void
    {
        $task->delete();

        $this->selectedList = $this->selectedList->fresh();
    }

    public function toggleTaskDone(Task $task): void
    {
        $task->update([
            'done_at' => $task->done_at ? null : now()
        ]);

        $this->selectedList = $this->selectedList->fresh();
    }

    private function resetTaskForm(): void
    {
        $this->reset('newTaskName', 'newTaskDescription', 'showCreateTaskForm', 'isEditingTask', 'editingTask');
        
        $this->resetValidation();
    }

}
