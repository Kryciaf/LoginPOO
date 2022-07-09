<?php
require_once ('class/config.php');
require_once ('autoload.php');

if (isset($_POST['email']) && isset($_POST['senha']) && !empty($_POST['email']) && !empty($_POST['senha'])){
    $email = limpaPost($_POST['email']);
    $senha = limpaPost($_POST['senha']);

    $login = new Login();
    $login->auth($email, $senha);
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/estilo.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <title>Login</title>
</head>
<body>
    <form method="POST">
        <h1>Login</h1>

        <?php if (isset($_GET['result']) && ($_GET['result']=="ok")){ ?>
            <div class="sucesso animate__animated animate__rubberBand">
                Cadastrado com sucesso! <br> Faça seu login :)
            </div>
        <?php }?>

        <?php if (isset($_GET['result']) && ($_GET['result']=="fail")){ ?>
            <div class="erro-geral animate__animated animate__rubberBand">
                Usuário ou senha incorretos
            </div>
        <?php }?>


        <div class="input-group">
            <img class="input-icon" src="img/user.png">
            <input type="email" name="email" placeholder="Digite seu email" required>
        </div>
        
        <div class="input-group">
            <img class="input-icon" src="img/lock.png">
            <input type="password" name="senha" placeholder="Digite sua senha" required>
        </div>
       
        <button class="btn-blue" type="submit">Fazer Login</button>
        <a href="cadastrar.php">Ainda não tenho cadastro</a>
    </form>

    <script>
        setTimeout(() => {
            $('.sucesso').hide();
        }, 3000);
    </script>
<script src="js/jquery-3.6.0.js"></script>
</body>
</html>