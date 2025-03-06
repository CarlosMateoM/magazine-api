<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>La Region - Restablecer contraseña</title>
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

                                    <p style="color: #333333; font-family: Arial, sans-serif; line-height: 1.6; margin: 0 0 24px 0; font-size: 16px;">
                                        Recibimos una solicitud para restablecer tu contraseña. Para cambiarla, haz clic aquí:
                                    </p>

                                    <!-- Botón -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 32px 0;">
                                        <tr>
                                            <td align="center">
                                                <table border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td align="center" bgcolor="#ff0000" style="border-radius: 6px;">
                                                            <a href="{{$url}}"
                                                               target="_blank"
                                                               style="font-family: Arial, sans-serif; font-size: 15px; color: #ffffff; text-decoration: none; padding: 14px 28px; border-radius: 6px; display: inline-block; font-weight: bold;">
                                                                Restablecer contraseña
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>

                                    <!-- URL alternativa -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 24px 0;">
                                        <tr>
                                            <td style="background-color: #f8f8f8; padding: 16px; border-radius: 6px;">
                                                <p style="font-family: Arial, sans-serif; font-size: 13px; color: #666666; margin: 0 0 8px 0; line-height: 1.5;">
                                                    Si el botón no funciona, copia y pega esta URL:
                                                </p>
                                                <p style="font-family: Arial, sans-serif; font-size: 13px; color: #666666; margin: 0; line-height: 1.5; word-break: break-all;">
                                                    {{$url}}
                                                </p>
                                            </td>
                                        </tr>
                                    </table>

                                    <p style="font-family: Arial, sans-serif; font-size: 13px; color: #8e8e8e; margin: 24px 0 0 0;">
                                        Tiempo para restablecimiento: 60 min
                                    </p>
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
