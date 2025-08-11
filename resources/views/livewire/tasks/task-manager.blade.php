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
                <h3 class="text-md font-medium mb-2 dark:text-white">{{ $isEditing ? 'Editar' : 'Nueva' }} Lista</h3>
                <input
                wire:model='newListName'
                type="text"
                placeholder="Nombre de la lista"
                class="w-full p-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md mb-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                <div class="mb-4">
                    <flux:error name='newListName' />
                </div>
                <div class="flex justify-end space-x-2">
                    <flux:button wire:click='cancelCreate' icon="x-mark" size="xs" variant="ghost">
                        Cancelar
                    </flux:button>
                    <flux:button wire:click='saveList' icon="check" size="xs" variant="filled">
                        {{ $isEditing ? 'Actualizar' : 'Guardar' }}
                    </flux:button>
                </div>
            </div>

            <!-- Listas -->
            <div class="space-y-2 max-h-96 overflow-y-auto">
                @foreach ($taskLists as $taskList)
                    <div class="p-3 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer transition-colors flex justify-between items-center">
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
           
            <div>

                <!-- Título y botón Nueva Tarea -->
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-700 dark:text-white">Tareas de la Lista</h2>
                    <flux:button icon="plus" variant="primary">Nueva Tarea</flux:button>
                </div>

                <!-- Formulario Nueva Tarea -->
                <div class="mb-4 bg-gray-50 dark:bg-gray-700 p-3 rounded-md">
                    <h3 class="text-md font-medium mb-2 dark:text-white">Nueva Tarea</h3>
                    <input 
                        type="text"
                        placeholder="Nombre de la tarea"
                        class="w-full p-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md mb-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <textarea 
                        placeholder="Descripción (opcional)"
                        class="w-full p-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md mb-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                        rows="2"></textarea>
                    <div class="flex justify-end space-x-2">
                        <flux:button icon="x-mark" size="xs" variant="ghost">Cancelar</flux:button>
                        <flux:button icon="check" size="xs" variant="filled">Guardar</flux:button>
                    </div>
                </div>

                <!-- Tareas -->
                <div class="space-y-3 max-h-96 overflow-y-auto">
                    <div class="p-3 border border-gray-200 dark:border-gray-600 rounded-md">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start space-x-3 flex-grow">
                                <input 
                                type="checkbox"
                                class="mt-1 h-4 w-4 text-green-500 focus:ring-green-400 rounded">
                                <div>
                                    <h4 class="font-medium text-gray-700 dark:text-white">Ejemplo de tarea</h4>
                                    <p class="text-sm mt-1 text-gray-600 dark:text-gray-300">Descripción de ejemplo</p>
                                </div>
                            </div>
                            <div class="flex space-x-1">
                                <flux:button icon="pencil" size="xs" variant="filled"></flux:button>
                                <flux:button icon="trash" size="xs" variant="danger"></flux:button>
                            </div>
                        </div>
                    </div>
                    <div class="text-center py-4 text-gray-500 dark:text-gray-400">
                        No hay tareas en esta lista. ¡Agrega una para comenzar!
                    </div>
                </div>

            </div>
    
            <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                <flux:icon.list-bullet class="size-20 mx-auto" />
                <p>Selecciona una lista para ver sus tareas</p>
            </div>
            
        </div>

    </div>

</div>
