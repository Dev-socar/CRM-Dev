<section>
    <h2 class="text-center text-3xl font-semibold"><?php echo $titulo; ?></h2>
    <div class="flex justify-center items-center lg:justify-end mt-5">
        <a href="/dashboard/clientes" class="block w-full lg:inline lg:w-auto text-xl p-3 rounded-lg bg-blue-700 text-white text-center hover:bg-blue-800 cursor-pointer transition-colors">Cancelar</a>
    </div>

    <div class="mt-8">
        <p class="text-gray-500 text-center text-2xl">Realiza los cambios necesarios</p>
        <form id="clientes-editar" class="mt-3 w-full lg:w-1/3 mx-auto my-0 space-y-3 rounded-lg shadow-lg bg-white p-3">
            <input type="hidden" id="id" name="id" value="<?php echo $cliente->id ?? ''; ?>">
            <?php include_once __DIR__ . '/formulario.php'; ?>
            <input type="submit" value="Guardar Cambios" class="w-full text-xl p-3 rounded-lg bg-blue-700 text-white text-center mt-5 hover:bg-blue-800 cursor-pointer transition-colors">
        </form>
    </div>

</section>