<!-- Sección de Tareas / Panel de la derecha -->
<div class="bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md p-4 md:col-span-2 border border-gray-200 dark:border-gray-700">
    @if ($selectedList)
        <div>
            <!-- Título y botón Nueva Tarea -->
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-700 dark:text-white">Tareas de la Lista: {{ $selectedList->name }}</h2>
                <flux:button wire:click='prepareCreateTask' icon="plus" variant="primary">
                    Nueva Tarea
                </flux:button>
            </div>

            <!-- Formulario Nueva Tarea -->
            <div wire:show='showCreateTaskForm' wire:transition class="mb-4 bg-gray-50 dark:bg-gray-700 p-3 rounded-md">
                <h3 class="text-md font-medium mb-2 dark:text-white">{{ $isEditingTask ? 'Editar' : 'Nueva' }} Tarea</h3>
                <flux:input type="text" placeholder="Nombre de la tarea" wire:model='newTaskName' />
                <div class="mb-4">
                    <flux:error name='newTaskName' />
                </div>
                <flux:textarea rows="2" placeholder="Descripción (opcional)" wire:model='newTaskDescription' class="mt-3" />
                <div class="mb-4">
                    <flux:error name='newTaskDescription' />
                </div>
                <div class="flex justify-end space-x-2 mt-5">
                    <flux:button wire:click='cancelCreateTask' icon="x-mark" size="xs" variant="ghost">
                        Cancelar
                    </flux:button>
                    <flux:button wire:click='saveTask' icon="check" size="xs" variant="filled">
                        {{ $isEditingTask ? 'Actualizar' : 'Guardar' }}
                    </flux:button>
                </div>
            </div>

            <!-- Tareas -->
            <div class="space-y-3 max-h-96 overflow-y-auto">
                @if ($selectedList->tasks->isEmpty())
                    <div class="text-center py-4 text-gray-500 dark:text-gray-400">
                        No hay tareas en esta lista. ¡Agrega una para comenzar!
                    </div>
                @else
                    @foreach ($selectedList->tasks as $task)
                        <div class="p-3 border border-gray-200 dark:border-gray-600 rounded-md">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start space-x-3 flex-grow">
                                    <flux:checkbox wire:click='toggleTaskDone({{ $task->id }})' :checked='$task->done_at' />
                                    <div>    
                                        <h4 
                                            @class([
                                                'font-medium text-gray-700 dark:text-white',
                                                'line-through' => $task->done_at
                                            ])>{{ $task->title }}
                                        </h4>
                                        <p
                                            @class([
                                                'text-sm mt-1 text-gray-600 dark:text-gray-300',
                                                'line-through' => $task->done_at
                                            ])>{{ $task->description }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex space-x-1">
                                    <flux:button wire:click='editTask({{ $task->id }})' icon="pencil" size="xs" variant="filled"></flux:button>
                                    <flux:button wire:confirm='¿Estás seguro de que quieres eliminar esta tarea?' wire:click='deleteTask({{ $task->id }})' icon="trash" size="xs" variant="danger"></flux:button>
                                </div>
                            </div>
                        </div>   
                    @endforeach

                @endif
            </div>
        </div>
    @else
        <div class="text-center py-12 text-gray-500 dark:text-gray-400">
            <flux:icon.list-bullet class="size-20 mx-auto" />
            <p>Selecciona una lista para ver sus tareas</p>
        </div>
    @endif
</div>