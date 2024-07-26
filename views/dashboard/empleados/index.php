<section>
    <h2 class="text-5xl font-semibold"><?php echo $titulo; ?></h2>
    <div class="flex justify-center items-center lg:justify-end mt-5">
        <a href="/dashboard/empleados/agregar" class="block mt-5 lg:mt-0 w-full lg:inline lg:w-auto text-xl p-3 rounded-lg bg-blue-700 text-white text-center">Nuevo Empleado</a>
    </div>
    <?php if (!empty($empleados)) { ?>
        <h2 class="text-center text-3xl font-semibold text-gray-500 mt-10">Mis Empleados</h2>

        <div class="relative overflow-x-auto w-[90%] mx-auto mt-10 mb-0">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                <thead class="text-xs text-blue-600 uppercase bg-gray-50 ">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-center">
                            Nombre(s)
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Telefono
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Estado
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($empleados as $empleado) { ?>
                        <tr class="bg-white border-b">
                            <th scope="row" class="px-6 py-4 text-center font-medium text-gray-900 whitespace-nowrap">
                                <?php echo $empleado->nombre; ?>
                            </th>
                            <td class="px-6 py-4 text-center">
                                <?php echo $empleado->email; ?>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <?php echo $empleado->telefono; ?>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center items-center gap-1">
                                    <div class="w-4 h-4 rounded-full <?php echo $empleado->estado ? 'bg-green-500' : 'bg-gray-500'; ?> "></div>
                                    <p class="w-auto"><?php echo $empleado->estado ? 'Activo' : 'Desconectado'; ?></p>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="/dashboard/empleados/editar?id=<?php echo $empleado->id ?>" class="text-blue-600 ">Editar</a>
                                    <form class="usuario-eliminar">
                                        <input type="hidden" name="id" id="id" value="<?php echo $empleado->id; ?>">
                                        <input type="submit" class="text-red-600 cursor-pointer" value="Eliminar">
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>

    <?php } else { ?>

        <h2 class="text-center text-3xl font-semibold text-gray-500">Aun No hay Empleados</h2>
    <?php } ?>

    <?php echo $paginacion; ?>

</section>