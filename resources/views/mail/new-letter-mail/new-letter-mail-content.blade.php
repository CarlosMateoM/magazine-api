<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Región - Newsletter</title>
    <style>
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 20px;
            background-color: #ffffff;
        }
        .content {
            padding: 30px 20px;
            background-color: #ffffff;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            padding: 15px;
            background-color: #eeeeee;
            font-size: 12px;
            color: #666666;
        }
        .title {
            color: #333333;
            font-size: 24px;
            margin-bottom: 25px;
            border-bottom: 2px solid #ff0000;
            padding-bottom: 10px;
            display: inline-block;
        }
    </style>
</head>
<body>
<div class="email-container">
    <!-- Encabezado -->
    <div class="header">
        <h1 class="title">Últimas 5 noticias que no te puedes perder</h1>
    </div>

    <!-- Cuerpo principal -->
    <div class="content">
        <x-NewLetterComponents.NewLetterComponent></x-NewLetterComponents.NewLetterComponent>
        <x-NewLetterComponents.NewLetterComponent></x-NewLetterComponents.NewLetterComponent>
    </div>

    <!-- Pie de página -->
    <div class="footer">
        <p>© {{ date('Y') }} La Región - Todos los derechos reservados</p>
        <p>
            <a href="https://laregionescaribe.com/" target="_blank" style="color: #666666; text-decoration: none;">Ver en navegador</a> |
            <a href="#" style="color: #666666; text-decoration: none;">Desuscribirse</a> |
            <a href="#" style="color: #666666; text-decoration: none;">Política de privacidad</a>
        </p>
    </div>
</div>
</body>
</html>
