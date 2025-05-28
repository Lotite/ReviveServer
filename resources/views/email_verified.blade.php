<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verificado - Revive</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #121827;
            color: #ffffff;
            margin: 0;
            padding: 16px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #1f2937;
            padding: 32px;
            border-radius: 12px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            text-align: center;
            width: 100%;
            max-width: 400px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .success-icon {
            width: 64px;
            height: 64px;
            background-color: #22c55e;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px auto;
            font-size: 24px;
            color: white;
        }

        .success-icon::before {
            content: "✓";
            font-weight: bold;
        }

        h1 {
            color: #ffffff;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 16px;
            line-height: 1.2;
        }

        p {
            color: #9ca3af;
            margin-bottom: 32px;
            font-size: 16px;
            line-height: 1.5;
        }

        .btn {
            display: inline-block;
            background-color: #22d3ee;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 16px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        .btn:hover {
            background-color: #0891b2;
            transform: translateY(-1px);
            box-shadow: 0 10px 25px rgba(34, 211, 238, 0.3);
        }

        .btn:active {
            transform: translateY(0);
        }

        .secondary-link {
            display: block;
            margin-top: 16px;
            color: #9ca3af;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .secondary-link:hover {
            color: #22d3ee;
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .container {
                padding: 24px;
                margin: 16px;
            }

            h1 {
                font-size: 20px;
            }

            p {
                font-size: 14px;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .container {
            animation: fadeInUp 0.5s ease-out;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .success-icon {
            animation: pulse 2s infinite;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="success-icon"></div>
        <h1>¡Correo electrónico verificado!</h1>
        <p>Tu cuenta ha sido verificada exitosamente. Ahora puedes acceder a todas las funciones de Revive.</p>
        <a href="http://127.0.0.1:5173//login" class="btn">Iniciar Sesión</a>
        <a href="http://127.0.0.1:5173/" class="secondary-link">Volver al inicio</a>
    </div>
</body>

</html>