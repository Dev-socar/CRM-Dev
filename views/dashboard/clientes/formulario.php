<div class="space-y-2">
    <label for="nombre" class="block text-xl font-semibold">Nombre(s)</label>
    <input type="text" id="nombre" name="nombre" placeholder="Ingresa el Nombre" class="w-full p-2 rounded-md text-xl bg-gray-50" autocomplete="off" value="<?php echo $cliente->nombre  ??  ''; ?>">
</div>
<div class="space-y-2">
    <label for="apellido" class="block text-xl font-semibold">Apellido(s)</label>
    <input type="text" id="apellido" name="apellido" placeholder="Ingresa el Apellido" class="w-full p-2 rounded-md text-xl bg-gray-50" autocomplete="off" value="<?php echo $cliente->apellido ??  ''; ?>">
</div>
<div class="space-y-2">
    <label for="email" class="block text-xl font-semibold">Correo Electronico</label>
    <input type="email" id="email" name="email" placeholder="Ingresa el Correo Electronico" class="w-full p-2 rounded-md text-xl bg-gray-50" autocomplete="off" value="<?php echo $cliente->email ??  ''; ?>">
</div>
<div class="space-y-2">
    <label for="telefono" class="block text-xl font-semibold">Telefono</label>
    <input type="tel" id="telefono" name="telefono" placeholder="Ingresa el Numero Telefonico" class="w-full p-2 rounded-md text-xl bg-gray-50" autocomplete="off" value="<?php echo $cliente->telefono ??  '';  ?>">
</div>
<div class="space-y-2">
    <label for="direccion" class="block text-xl font-semibold">Direccion</label>
    <input type="text" id="direccion" name="direccion" placeholder="Ingresa la Direccion" class="w-full p-2 rounded-md text-xl bg-gray-50" autocomplete="off" value="<?php echo $cliente->direccion ??  ''; ?>">
</div>