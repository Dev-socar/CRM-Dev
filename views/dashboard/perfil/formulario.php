<div class="space-y-2">
    <label for="nombre" class="block text-xl font-semibold">Nombre(s)</label>
    <input type="text" id="nombre" name="nombre" placeholder="Ingresa el Nombre" class="w-full p-2 rounded-md text-xl bg-gray-50" autocomplete="off" value="<?php echo $empleado->nombre  ??  ''; ?>">
</div>

<div class="space-y-2">
    <label for="email" class="block text-xl font-semibold">Correo Electronico</label>
    <input type="email" id="email" name="email" autocomplete="off" placeholder="Ingresa el Correo Electronico" class="w-full p-2 rounded-md text-xl bg-gray-50 <?php echo !is_Admin() ? 'bg-gray-200 cursor-not-allowed' : ''; ?>" <?php echo !is_Admin() ? 'disabled' : ''; ?> value="<?php echo $empleado->email  ??  ''; ?>">
</div>

<div class="space-y-2">
    <label for="telefono" class="block text-xl font-semibold">Telefono</label>
    <input type="tel" id="telefono" name="telefono" placeholder="Ingresa el Numero Telefonico" class="w-full p-2 rounded-md text-xl bg-gray-50" autocomplete="off" value="<?php echo $empleado->telefono  ??  ''; ?>">
</div>
<div class="space-y-2">
    <label for="password" class="block text-xl font-semibold">Cambiar Password</label>
    <input type="password" id="password" name="password" placeholder="<?php echo !is_Admin() ? 'Solo El Admin Puede Cambiar Passwords' : 'Ingresa el Nuevo Password'; ?>" class="w-full p-2 rounded-md text-xl bg-gray-50 <?php echo !is_Admin() ? 'bg-gray-200 cursor-not-allowed' : ''; ?>" <?php echo !is_Admin() ? 'disabled' : ''; ?>>
</div>