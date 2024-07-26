<section>
    <h2 class="text-5xl font-semibold"><?php echo $titulo; ?></h2>
    <div class="grid  gap-5 mt-5">
        <div class="p-2 rounded-lg shadow-md bg-white">
            <h3 class="text-3xl text-gray-500 text-center mt-3">Ultimos Clientes</h3>
            <?php if (!empty($clientes)) { ?>
                <div class="relative overflow-x-auto w-[90%] mx-auto mt-3 mb-0">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                        <thead class="text-xs text-blue-600 uppercase bg-gray-50 ">
                            <tr>
                                <th scope="col" class="px-1 py-3 text-center">
                                    Nombre(s)
                                </th>
                                <th scope="col" class="px-1 py-3 text-center">
                                    Apellido(s)
                                </th>
                                <th scope="col" class="px-1 py-3 text-center">
                                    Email
                                </th>
                                <th scope="col" class="px-1 py-3 text-center">
                                    Telefono
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clientes as $cliente) { ?>
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-3 py-4 text-center font-medium text-gray-900 whitespace-nowrap">
                                        <?php echo $cliente->nombre; ?>
                                    </th>
                                    <td class="px-3 py-4 text-center">
                                        <?php echo $cliente->apellido; ?>
                                    </td>
                                    <td class="px-3 py-4 text-center">
                                        <?php echo $cliente->email; ?>
                                    </td>
                                    <td class="px-3 py-4 text-center">
                                        <?php echo $cliente->telefono; ?>
                                    </td>


                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>

                <h2 class="text-center text-3xl font-semibold text-gray-500 mt-3">Aun No Tienes Clientes</h2>
            <?php } ?>
        </div>

        <div class="p-2 rounded-lg shadow-lg bg-white">
            <h3 class="text-3xl text-gray-500 text-center mt-3">Proximos Eventos</h3>
            <?php if (!empty($eventos)) { ?>
                <div class="relative overflow-x-auto w-[90%] mx-auto mt-3 mb-0">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                        <thead class="text-xs text-blue-600 uppercase bg-gray-50 ">
                            <tr>
                                <th scope="col" class="px-1 py-3 text-center">
                                    Titulo
                                </th>
                                <th scope="col" class="px-1 py-3 text-center">
                                    Fecha Inicio
                                </th>
                                <th scope="col" class="px-1 py-3 text-center">
                                    Fecha Final
                                </th>


                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($eventos as $evento) { ?>
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-3 py-4 text-center font-medium text-gray-900 whitespace-nowrap">
                                        <?php echo $evento->title; ?>
                                    </th>
                                    <td class="px-3 py-4 text-center">
                                        <?php echo formatearFecha($evento->start); ?>
                                    </td>
                                    <td class="px-3 py-4 text-center">
                                        <?php echo formatearFecha($evento->end); ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>

                <h2 class="text-center text-3xl font-semibold text-gray-500 mt-3">No Tienes Eventos Agendados</h2>
            <?php } ?>
        </div>
        <?php if (!empty($empleados)) { ?>
            <div class="p-2 rounded-lg shadow-lg bg-white">
                <h3 class="text-3xl text-gray-500 text-center mt-3">Ultimos Empleados</h3>
                <div class="relative overflow-x-auto w-[90%] mx-auto mt-3">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                        <thead class="text-xs text-blue-600 uppercase bg-gray-50 ">
                            <tr>
                                <th scope="col" class="px-1 py-3 text-center">
                                    Nombre(s)
                                </th>
                                <th scope="col" class="px-1 py-3 text-center">
                                    Email
                                </th>
                                <th scope="col" class="px-1 py-3 text-center">
                                    Estado
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($empleados as $empleado) { ?>
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-3 py-4 text-center font-medium text-gray-900 whitespace-nowrap">
                                        <?php echo $empleado->nombre; ?>
                                    </th>
                                    <td class="px-3 py-4 text-center">
                                        <?php echo $empleado->email; ?>
                                    </td>
                                    <td class="px-3 py-4 text-center">
                                        <div class="flex justify-center items-center gap-1">
                                            <div class="w-4 h-4 rounded-full <?php echo $empleado->estado ? 'bg-green-500' : 'bg-gray-500'; ?> "></div>
                                            <p class="w-auto"><?php echo $empleado->estado ? 'Activo' : 'Desconectado'; ?></p>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        <?php } ?>
    </div>

</section>