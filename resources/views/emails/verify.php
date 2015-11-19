<html>
    <body>
        <h1>Verify email</h1>
        <?= url('api/v1/verify?token' + $user->token) ?>
    </body>
</html>