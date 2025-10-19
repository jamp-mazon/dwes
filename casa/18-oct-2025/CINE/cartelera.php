<?php

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cartelera</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #111;
            color: white;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            padding: 20px;
            color: #f5c518;
        }

        .cartelera {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 30px;
            padding: 30px;
        }

        .pelicula {
            background-color: #222;
            border-radius: 10px;
            overflow: hidden;
            width: 250px;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
            text-align: center;
            transition: transform 0.2s ease;
        }

        .pelicula:hover {
            transform: scale(1.05);
        }

        .pelicula img {
            width: 100%;
            height: 370px;
            object-fit: cover;
        }

        .pelicula h3 {
            margin: 10px 0;
            font-size: 18px;
        }

        .pelicula p {
            font-size: 14px;
            color: #ccc;
            padding: 0 10px;
        }

        .pelicula button {
            background-color: #f5c518;
            border: none;
            color: #000;
            padding: 10px 20px;
            margin: 15px 0 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .pelicula button:hover {
            background-color: #ffda33;
        }
    </style>
</head>
<body>
    <h1>🎬 Cartelera</h1>

    <div class="cartelera">
        <div class="pelicula">
            <img src="https://www.aceprensa.com/wp-content/uploads/2010/08/27205-0.jpg" alt="Inception">
            <h3>Inception</h3>
            <p>Un ladrón que roba secretos a través de los sueños es contratado para implantar una idea en la mente de un magnate.</p>
            <a href="butacas.php">
                <button type="submit">Acceder</button>
            </a>
        </div>

        <div class="pelicula">
            <img src="https://play-lh.googleusercontent.com/D5FtnFBPO_FitBIqjCffRZrhZf84Xm3mVoqQDUD2ZGq-Z4LftUotgRj4WquMQhDs1nL46NQxu7Rr2ahbFrWM=w240-h480-rw" alt="Interstellar">
            <h3>Interstellar</h3>
            <p>Un grupo de astronautas viaja a través de un agujero de gusano para encontrar un nuevo hogar para la humanidad.</p>
            <a href="butacas.php">
                <button type="submit">Acceder</button>
            </a>
        </div>

        <div class="pelicula">
            <img src="https://m.media-amazon.com/images/I/71niXI3lxlL._AC_SL1000_.jpg" alt="The Dark Knight">
            <h3>El Caballero Oscuro</h3>
            <p>Batman enfrenta su mayor desafío cuando el Joker desata el caos en Ciudad Gótica.</p>
            <a href="butacas.php">
                <button type="submit">Acceder</button>
            </a>
        </div>
    </div>
</body>
</html>
