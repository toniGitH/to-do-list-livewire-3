<div align="center">
    <a href="https://livewire.laravel.com" target="_blank"><img src="https://laravel-livewire.com/img/logo.svg" width="400" height="100" alt="Livewire Logo"></a>
    <a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" height="100" alt="Laravel Logo"></a>
</div>

---
<br>

<div align="center">

[![PHP 8.x](https://img.shields.io/badge/php%208.x-%23777BB4?style=plastic&logo=php&logoColor=black)](https://www.php.net/) [![Laravel 12](https://img.shields.io/badge/Laravel%2012-%20%23FF2D20?style=plastic&logo=laravel&logoColor=white)](https://laravel.com/) [![Blade templates](https://img.shields.io/badge/Blade%20templates%20-%20%23FF2D20?style=plastic&logo=laravel&logoColor=white)](https://laravel.com/docs/blade) [![Livewire 3](https://img.shields.io/badge/Livewire%203%20-%234E56A6?style=plastic&logo=livewire&logoColor=white)](https://livewire.laravel.com/) [![Tailwind CSS 4.x](https://img.shields.io/badge/Tailwind%20CSS%204.x-%2306B6D4?style=plastic&logo=tailwind%20css&logoColor=white)](https://tailwindcss.com/) [![Vite 6.x](https://img.shields.io/badge/Vite%206.x-%23646CFF?style=plastic&logo=vite&logoColor=yellow)](https://vitejs.dev/) [![HTML 5](https://img.shields.io/badge/HTML%205-white?style=plastic&logo=html5)](https://developer.mozilla.org/es/docs/Web/HTML) [![SQLite](https://img.shields.io/badge/SQLite-%230e80cc?style=plastic&logo=sqlite)](https://www.sqlite.org/) [![Composer](https://img.shields.io/badge/Composer%20-%20%23885630?style=plastic&logo=composer&logoColor=white)](https://getcomposer.org/)

</div>

<div align="center">

<div align="center">

[![GitHub repo size](https://img.shields.io/github/repo-size/toniGitH/BookReviews?style=plastic&logo=github)](https://github.com/toniGitH/BookReviews) [![GitHub code size](https://img.shields.io/github/languages/code-size/toniGitH/BookReviews?style=plastic&logo=github)](https://github.com/toniGitH/BookReviews) [![GitHub file count](https://img.shields.io/github/directory-file-count/toniGitH/BookReviews?style=plastic)](https://github.com/toniGitH/BookReviews) [![GitHub watchers](https://img.shields.io/github/watchers/toniGitH/BookReviews?style=plastic&logo=github)](https://github.com/toniGitH/BookReviews) [![GitHub forks](https://img.shields.io/github/forks/toniGitH/BookReviews?style=plastic&logo=github)](https://github.com/toniGitH/BookReviews)

</div>

</div>

<div align="center">

[![GitHub followers](https://img.shields.io/github/followers/toniGitH?style=plastic&logo=GitHub&logoColor=black&labelColor=white&color=red)](https://github.com/toniGitH?tab=followers)

</div>



<br/>

# 📝 Aplicación de lista de tareas: To Do List


## 🧩 Estructura de la aplicación. V.2 (3 componentes Livewire 3)

En esta rama se ha refactorizado el componente único y principal que había (TaskManager), y se ha separado la lógica en tres componentes separados.

1. **Componente contenedor**, que sólo gestiona la vista en la que se llamará a los otros dos componentes:

    → TaskManager.php → Componente de clase.

    → task-manager.blade.php → Componente de vista.

2. **Componente que gestiona las Listas**:

    → TasksLists.php → Componente de clase

    → tasks-lists.blade.php → Componente de vista.

3. **Componente que gestiona las Tareas**:

    → TasksPanel.php → Componente de clase

    → tasks-panel.blade.php → Componente de vista.

La comunicación entre los componentes 2 y 3 componentes se realiza mediante **eventos** "disparados" desde el componente **TasksLists**.


Ambos componentes son llamados dentro de la vista llamada task-manager.blade.php, que está dentro de tasks.blade.php y que a su vez está dentro del layout:

`resources/views/layouts/app.blade.php`

