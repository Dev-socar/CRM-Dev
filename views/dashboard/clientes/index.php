<section>
    <h2 class="text-6xl font-semibold"><?php echo $titulo; ?></h2>
    <div class="flex justify-center items-center lg:justify-end">
        <a href="/dashboard/clientes/agregar" class="block lg:mt-0 w-full lg:inline lg:w-auto text-xl p-3 rounded-lg bg-blue-700 text-white text-center">Nuevo Cliente</a>
    </div>


    <?php if (!empty($clientes)) { ?>

        <h2 class="text-center text-3xl font-semibold text-gray-500 mt-5">Mis Clientes</h2>

        <div class="relative overflow-x-auto w-[90%] mx-auto mt-5 mb-0">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                <thead class="text-xs text-blue-600 uppercase bg-gray-50 ">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-center">
                            Nombre(s)
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Apellido(s)
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Telefono
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Direccion
                        </th>
                        <?php if (is_Admin()) { ?>
                            <th scope="col" class="px-6 py-3 text-center">
                                Responsable
                            </th>
                        <?php } ?>
                        <th scope="col" class="px-6 py-3 text-center">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $cliente) { ?>
                        <tr class="bg-white border-b">
                            <th scope="row" class="px-6 py-4 text-center font-medium text-gray-900 whitespace-nowrap">
                                <?php echo $cliente->nombre; ?>
                            </th>
                            <td class="px-6 py-4 text-center">
                                <?php echo $cliente->apellido; ?>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <?php echo $cliente->email; ?>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <?php echo $cliente->telefono; ?>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <?php echo $cliente->direccion; ?>
                            </td>
                            <?php if (is_Admin()) { ?>
                                <td class="px-6 py-4 text-center">
                                    <?php echo $cliente->empleado; ?>
                                </td>
                            <?php } ?>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-between items-center gap-2">
                                    <a href="/dashboard/clientes/editar?id=<?php echo $cliente->id; ?>" class="text-blue-600 ">Editar</a>

                                    <form class="clientes-eliminar">
                                        <input type="hidden" name="id" id="id" value="<?php echo $cliente->id; ?>">
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

        <h2 class="text-center text-3xl font-semibold text-gray-500">Aun No Tienes Clientes</h2>
    <?php } ?>

    <?php echo $paginacion; ?>

</section>