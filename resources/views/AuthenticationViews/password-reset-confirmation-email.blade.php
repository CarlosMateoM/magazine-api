<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>La Region - Confirmación de Restablecimiento de Contraseña</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f5f5f5;">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td>
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="max-width: 600px; margin: 0 auto;">
                <tr>
                    <td style="padding: 24px;">
                        <!-- Header con logo -->
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #ffffff; border-radius: 8px;">
                            <tr>
                                <td style="padding: 24px; text-align: center;">
                                    <img src="https://revistaregion.blob.core.windows.net/media/eslogan.png"
                                         alt="La Region logo"
                                         style="display: block; margin: 0 auto; max-width: 180px;">
                                </td>
                            </tr>
                        </table>

                        <!-- Contenido principal -->
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #ffffff; margin-top: 24px; border-radius: 8px;">
                            <tr>
                                <td style="padding: 32px;">
                                    <h1 style="color: #ff0000; font-family: Arial, sans-serif; font-weight: bold; font-size: 20px; margin: 0 0 24px 0;">Hola {{$username}}!</h1>

                                    <p style="color: #333333; font-family: Arial, sans-serif; line-height: 1.6; margin: 0 0 20px 0; font-size: 16px;">
                                        Te confirmamos que tu contraseña ha sido restablecida correctamente. Ahora puedes iniciar sesión con el correo
                                        <span style="color: #ff0000; font-weight: bold;">{{$email}}</span> con tu nueva contraseña.
                                    </p>

                                    <p style="color: #333333; font-family: Arial, sans-serif; line-height: 1.6; margin: 0 0 20px 0; font-size: 16px;">
                                        Si no realizaste esta acción, por favor cambia tu contraseña inmediatamente y comunícate con nuestro equipo de soporte.
                                    </p>

                                    <p style="color: #333333; font-family: Arial, sans-serif; line-height: 1.6; margin: 0 0 32px 0; font-size: 16px;">
                                        Saludos,<br>
                                        El equipo de <strong style="color: #333333;">LaRegion.com</strong>
                                    </p>

                                    <!-- Botón -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 0;">
                                        <tr>
                                            <td align="center">
                                                <table border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td align="center" bgcolor="#ff0000" style="border-radius: 6px;">
                                                            <a href="{{config('app.frontend_url').'/')}}"
                                                               target="_blank"
                                                               style="font-family: Arial, sans-serif; font-size: 15px; color: #ffffff; text-decoration: none; padding: 14px 28px; border-radius: 6px; display: inline-block; font-weight: bold;">
                                                                Iniciar sesión
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <!-- Footer -->
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #eeeeee; margin-top: 24px; border-radius: 8px;">
                            <tr>
                                <td style="padding: 24px; text-align: center;">
                                    <p style="color: #666666; font-family: Arial, sans-serif; font-size: 12px; margin: 0 0 12px 0;">
                                        © {{ date('Y') }} La Región - Todos los derechos reservados
                                    </p>
                                    <p style="margin: 0; font-family: Arial, sans-serif; font-size: 12px;">
                                        <a href="https://laregionescaribe.com/" target="_blank" style="color: #666666; text-decoration: none; margin-right: 16px;">Ver en navegador</a>
                                        <a href="#" style="color: #666666; text-decoration: none;">Política de privacidad</a>
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
