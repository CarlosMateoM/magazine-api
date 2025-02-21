<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Region - Restablecer contraseña</title>
</head>
<body>
<div style="max-width: 600px; font-family: Arial, sans-serif; margin: 0 auto; background-color: #f5f5f5; padding: 20px;">
    <div style="background-color: #ffffff; padding: 20px; text-align: center; border-radius: 4px;">
        <img src="https://revistaregion.blob.core.windows.net/media/eslogan.png"
             alt="La Region logo"
             style="display: block; margin: 0 auto; max-width: 200px;">
    </div>

    <div style="background-color: #ffffff; padding: 20px; margin-top: 20px; border-radius: 4px;">
        <p style="color: #ff0000; font-weight: bold;">Hola {{$username}}!</p>
        <p style="color: #000000; text-align: justify; margin: 0 0 15px 0;">
            Te confirmamos que tu contraseña ha sido restablecida correctamente. Ahora puedes iniciar sesión con el correo
            <span style="color: red">{{$email}}</span> con tu nueva contraseña.
        </p>

        <p style="color: #000000; text-align: justify; margin: 0 0 15px 0;">
            Si no realizaste esta acción, por favor cambia tu contraseña inmediatamente y comunícate con nuestro equipo de soporte.
        </p>

        <p style="color: #000000; text-align: justify; margin: 0 0 15px 0;">
            Saludos,<br>
            El equipo de <strong>LaRegion.com</strong>
        </p>

        <div style="text-align: center; margin-top: 10px">
            <a href="{{config('app.frontend_url').'/'}}"
               style="
               color: #ffffff;
               text-decoration: underline;
               background-color: #ff0000;
               padding: 12px 24px;
               border-radius: 4px;
               display: inline-block;
               margin: 0 0 15px 0;
               font-weight: bold;
           ">
                Iniciar sesión
            </a>
        </div>
        <!-- Botón principal -->


    </div>
    <div style="background-color: #eeeeee; text-align: center; font-size: 12px; padding: 18px">
        <p>© {{ date('Y') }} La Región - Todos los derechos reservados</p>
        <p>
            <a href="https://laregionescaribe.com/" target="_blank" style="color: #666666; text-decoration: none;">Ver en navegador</a> |
            <a href="#" style="color: #666666; text-decoration: none;">Política de privacidad</a>
        </p>
    </div>
</div>
</body>
</html>
