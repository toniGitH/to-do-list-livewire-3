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
                    <flux:button wire:confirm='¿Estás seguro de que quieres eliminar esta lista?' wire:click='deleteList({{ $taskList->id }})' icon="trash" size="xs" variant="danger"></flux:button>
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
