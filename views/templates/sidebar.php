<nav class="flex flex-col gap-5 h-full">
    <div>
        <h2 class="p-3 text-white text-2xl text-center lg:text-left font-semibold lg:text-lg xl:text-xl">Bienvenido: <span class="font-bold"><?php echo $_SESSION['nombre'] ?></span></h2>
    </div>
    <div class="flex flex-col justify-between h-full">
        <ul class="flex flex-col gap-2">
            <li><a class="text-white block text-lg p-3 rounded-lg hover:bg-blue-500 <?php echo pagina_actual('/panel') ? 'bg-blue-500' : ''; ?>" href="/dashboard/panel">Dashboard</a></li>
            <?php if (is_Admin()) { ?>
                <li><a class="text-white block text-lg p-3 rounded-lg hover:bg-blue-500 <?php echo pagina_actual('/empleados') ? 'bg-blue-500' : ''; ?>" href="/dashboard/empleados">Empleados</a></li>
            <?php } ?>
            <li><a class="text-white block text-lg p-3 rounded-lg hover:bg-blue-500 <?php echo pagina_actual('/agenda') ? 'bg-blue-500' : ''; ?>" href="/dashboard/agenda">Agenda</a></li>
            <li><a class="text-white block text-lg p-3 rounded-lg hover:bg-blue-500 <?php echo pagina_actual('/clientes') ? 'bg-blue-500' : ''; ?>" href="/dashboard/clientes">Clientes</a></li>
        </ul>
        <ul>
            <li><a class="text-white block text-lg p-3 rounded-lg hover:bg-blue-500 <?php echo pagina_actual('/ajustes') ? 'bg-blue-500' : ''; ?>" href="/dashboard/ajustes">Ajustes</a></li>
            <li><a class="text-white block text-lg p-3 rounded-lg hover:bg-blue-500 <?php echo pagina_actual('/logout') ? 'bg-blue-500' : ''; ?>" href="/logout">Cerrar Sesion</a></li>
        </ul>
    </div>
</nav>