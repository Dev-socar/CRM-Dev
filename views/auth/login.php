<main class="bg-white w-11/12 lg:w-1/2 p-5 mt-20 rounded-lg mx-auto shadow-lg">
    <h1 class="text-3xl text-center font-semibold">CRM-Dev <span class="text-blue-500 font-bold">Login</span></h1>
    <p class="text-gray-500 text-center mt-3">Llena el siguiente Formulario para Iniciar Sesion</p>
    <form action="/login" id="form-login" method="post" class="mt-5 lg:w-1/2 mx-auto my-0 space-y-5">
        <div class=" space-y-2">
            <label for="email">Email</label>
            <input type="email" id="email" autocomplete="off" name="email" placeholder="Ingresa tu email" class="rounded-md bg-slate-50 w-full p-3">
        </div>
        <div class=" space-y-2">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Ingresa tu Password" class="rounded-md bg-slate-50 w-full p-3">
        </div>
        <input type="submit" value="Iniciar Sesion" class="w-full lg:w-auto p-2 rounded-lg bg-blue-700 hover:bg-blue-900 transition-colors cursor-pointer text-center text-white">
    </form>
</main>