<?php

namespace App\Livewire\Tasks;

use App\Models\TaskList;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TaskLists extends Component
{
    public string $newListName = "";
    public bool $showCreateListForm = false;
    public bool $isEditingList = false;
    public ?TaskList $editingList = null;
    public ?TaskList $selectedList = null;

    public function render(): View
    {
        return view('livewire.tasks.task-lists', [
            'taskLists' => Auth::user()->lists
        ]);
    }

    public function prepareCreateList(): void
    {
        $this->showCreateListForm = true;
        $this->isEditingList = false;
        $this->newListName = "";
        $this->resetValidation();
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
        
        $this->resetListForm();
    }

    public function cancelCreateList(): void
    {
        $this->resetListForm();
    }

    public function editList(TaskList $taskList): void
    {
        $this->showCreateListForm = true;
        $this->isEditingList = true;
        $this->newListName = $taskList->name;
        $this->editingList = $taskList;
        $this->resetValidation();
    }

    public function deleteList(TaskList $taskList): void
    {
        if ($this->selectedList?->id === $taskList->id) {
            $this->selectedList = null;
            $this->dispatch('list-deselected');
        }

        $taskList->delete();
    }

    public function selectList(TaskList $taskList): void
    {
        $this->selectedList = $taskList;
        $this->dispatch('list-selected', listId: $taskList->id);
    }

    private function resetListForm(): void
    {
        $this->reset('newListName', 'showCreateListForm', 'isEditingList', 'editingList');
        $this->resetValidation();
    }

    protected function messages(): array
    {
        return [
            'newListName.unique' => 'This list name has already been taken'
        ];
    }
}
