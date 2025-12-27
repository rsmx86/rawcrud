<!DOCTYPE html>
<html>
<head>
    <title>LOGIN RAW</title>
</head>
<body>
    <h1>FAROESTE SYSTEM - LOGIN</h1>
    <hr>
    <form action="<?php echo base_url('login/autenticar'); ?>" method="POST">
        <label>E-mail:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Senha:</label><br>
        <input type="password" name="senha" required><br><br>

        <button type="submit">ENTRAR</button>
    </form>
</body>
</html>