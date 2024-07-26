<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM-Dev | <?php echo $titulo; ?></title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js" integrity="sha256-ZztCtsADLKbUFK/X6nOYnJr0eelmV2X3dhLDB/JK6fM=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="/css/app.css">
</head>

<body class="bg-slate-100 lg:min-h-screen">
    <main class="lg:grid lg:grid-cols-6 items-start w-full lg:h-screen">
        <aside class="lg:col-start-1 lg:col-end-2 bg-blue-700 p-3 lg:h-full">
            <?php
            include_once __DIR__ . '/templates/sidebar.php';
            ?>
        </aside>
        <section class="lg:col-start-2 lg:col-end-7 p-5 lg:h-full lg:overflow-y-auto">
            <?php echo $contenido ?>
        </section>
    </main>

    <script type="module" src="/js/app.js"></script>
</body>

</html>