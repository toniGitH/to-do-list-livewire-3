<div class="container mx-auto p-4">

    <header class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">Aplicación de Tareas</h1>
        <p class="text-gray-600 dark:text-gray-300">Organiza tus tareas de manera eficiente</p>
    </header>
  
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Sección de Listas / Panel de la izquierda -->
        <livewire:tasks.tasks-lists />
  
        <!-- Sección de Tareas / Panel de la derecha -->
        <livewire:tasks.tasks-panel />

    </div>

</div>
