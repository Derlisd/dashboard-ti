<!DOCTYPE html>
<html>
<head>
    <title>{{ env('APP_NAME') }} Token de Verificación</title>
</head>
<body>
    <p>Estimado usuario,</p>

    <p>Aquí está su token de verificación: <strong>{{ $token }}</strong></p>

    <p>Utilice este token para completar el proceso de autenticación.</p>

</body>
</html>
