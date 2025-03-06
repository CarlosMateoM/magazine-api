<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>La Region - Bienvenido</title>
    <style>
        .email-container{
            max-width: 600px;
            font-family: Arial, sans-serif;
            margin: 0 auto;
            background-color: #f5f5f5;
            padding: 20px;
        }

        .header{
            text-align: center;
            padding: 20px;
        }

        .content{
            background-color: #ffffff;
            padding: 20px;
        }

        .footer{
            background-color: #eeeeee;
            text-align: center;
            font-size: 12px;
            padding: 15px;
        }

        #logo{
            width: 50%;
            height: 30%;
        }

        #p-text{
            text-align: justify;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <img id="logo" src="https://revistaregion.blob.core.windows.net/media/67a7e635cb910.webp" alt="La Region logo">
        </div>
        <div class="content">
            <p style="color: #ff0000; font-weight: bold"> {{$subscriber}} bienvenido/a a la familia de La Región! </p>
            <p id="p-text">Nos alegra enormemente que hayas decidido formar parte de nuestra comunidad de lectores. A partir de ahora, recibirás en tu bandeja de entrada las noticias más relevantes de tu región, reportajes exclusivos y contenido seleccionado especialmente para ti. Gracias por confiar en nosotros como tu fuente de información local. ¡Juntos mantendremos vivo el pulso de nuestra comunidad!</p>
        </div>
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
