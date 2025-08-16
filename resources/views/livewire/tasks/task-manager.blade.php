<div class="container mx-auto p-4">

    <header class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">Aplicación de Tareas</h1>
        <p class="text-gray-600 dark:text-gray-300">Organiza tus tareas de manera eficiente</p>
    </header>
  
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Sección de Listas / Panel de la izquierda -->
        <div class="bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md p-4 md:col-span-1 border border-gray-200 dark:border-gray-700">
            
            <!-- Título y botón Nueva Lista -->
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-700 dark:text-white">Mis Listas</h2>
                <flux:button wire:click='prepareCreateList' icon="plus" variant="primary">
                    Nueva
                </flux:button>
            </div>

            <!-- Formulario Nueva Lista -->
            <div wire:show='showCreateListForm' wire:transition class="mb-4 bg-gray-50 dark:bg-gray-700 p-3 rounded-md">
                <h3 class="text-md font-medium mb-2 dark:text-white">{{ $isEditingList ? 'Editar' : 'Nueva' }} Lista</h3>
                <input
                wire:model='newListName'
                type="text"
                placeholder="Nombre de la lista"
                class="w-full p-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md mb-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                <div class="mb-4">
                    <flux:error name='newListName' />
                </div>
                <div class="flex justify-end space-x-2">
                    <flux:button wire:click='cancelCreateList' icon="x-mark" size="xs" variant="ghost">
                        Cancelar
                    </flux:button>
                    <flux:button wire:click='saveList' icon="check" size="xs" variant="filled">
                        {{ $isEditingList ? 'Actualizar' : 'Guardar' }}
                    </flux:button>
                </div>
            </div>

            <!-- Listas -->
            <div class="space-y-2 max-h-96 overflow-y-auto">
                @foreach ($taskLists as $taskList)
                    <div wire:click='selectList({{ $taskList->id }})'
                         @class([
                            'p-3 rounded-md hover:bg-gray-50 cursor-pointer transition-colors flex justify-between items-center',
                            'bg-gray-50 hover:bg-gray-50' => $selectedList?->id === $taskList->id,
                         ]) 
                    >
                        <div class="flex-grow">
                            <p class="font-medium text-gray-700 dark:text-white">{{ $taskList->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">({{ $taskList->tasks->count() }} tareas)</p>
                        </div>
                        <div class="flex space-x-1">
                            <flux:button wire:click='editList({{ $taskList->id }})' icon="pencil" size="xs" variant="filled"></flux:button>
                            <flux:button wire:click='deleteList({{ $taskList->id }})' icon="trash" size="xs" variant="danger"></flux:button>
                        </div>
                    </div>
                @endforeach
                @if ($taskLists->isEmpty())
                    <div class="text-center py-4 text-gray-500 dark:text-gray-400">
                        No hay listas aún. ¡Crea una para comenzar!
                    </div>
                @endif
            </div>

        </div>
  
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
                                            <input 
                                            type="checkbox"
                                            class="mt-1 h-4 w-4 text-green-500 focus:ring-green-400 rounded">
                                            <div>
                                                <h4 class="font-medium text-gray-700 dark:text-white">{{ $task->title }}</h4>
                                                <p class="text-sm mt-1 text-gray-600 dark:text-gray-300">{{ $task->description }}</p>
                                            </div>
                                        </div>
                                        <div class="flex space-x-1">
                                            <flux:button wire:click='editTask({{ $task->id }})' icon="pencil" size="xs" variant="filled"></flux:button>
                                            <flux:button wire:click='deleteTask({{ $task->id }})' icon="trash" size="xs" variant="danger"></flux:button>
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

    </div>

</div>
