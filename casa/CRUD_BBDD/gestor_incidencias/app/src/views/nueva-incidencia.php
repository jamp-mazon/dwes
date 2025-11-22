<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nueva incidencia</title>
    <link rel="stylesheet" href="nueva_incidencia.css">
</head>

<body>

    <header class="topbar">
        <div class="brand">
            <div class="logo"></div>
            <h1>Gestor de Incidencias</h1>
        </div>

        <div class="userbox">
            <div class="user-name">Ana López</div>
            <div class="user-email">ana@incidencias.test</div>
            <div class="user-role">USER</div>
        </div>
    </header>

    <main class="container">

        <section class="card">
            <div class="card-header">
                <h2>Nueva incidencia</h2>
                <p class="muted">
                    Rellena el formulario para registrar una incidencia.
                    Por defecto se guarda como pendiente.
                </p>
            </div>

            <form class="form" action="../controllers/procesar-incidencia.php" method="post">

                <div class="field">
                    <label for="titulo">Título de la incidencia</label>
                    <input
                        type="text"
                        id="titulo"
                        name="titulo"
                        placeholder="Ej: No puedo iniciar sesión"
                        required
                        maxlength="150" />
                    <small class="help">Máximo 150 caracteres.</small>
                </div>

                <div class="field">
                    <label for="descripcion">Descripción</label>
                    <textarea
                        id="descripcion"
                        name="descripcion"
                        placeholder="Describe el problema con detalle..."
                        required
                        rows="6"></textarea>
                    <small class="help">Incluye pasos para reproducir el error si aplica.</small>
                </div>
                <button type="submit">ENVIAR</button>
            </form>
        </section>

    </main>

</body>

</html>