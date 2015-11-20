<html>
    <body>
        <h1>You have been invited</h1>

        Hi <?= $invited->name ?>,
        Click this to accept the invite <?= url('api/v1/verify?token=' . $invited->token) ?>

        From <?= $user->name ?>
    </body>
</html>