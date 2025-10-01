<?php
session_start();
require 'include/config.php';

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém o e-mail e a senha do usuário
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Prepara a consulta para buscar o usuário pelo e-mail
    $parametro = $conexao->prepare("SELECT * FROM usuario WHERE email = ?");
    $parametro->bind_param("s", $email);
    $parametro->execute();

    // Obtém o resultado da consulta
    $resultado = $parametro->get_result();

    if ($resultado->num_rows === 1) {
        // Recupera os dados do usuário
        $user = $resultado->fetch_assoc();
        // Verifica se a senha está correta
        if (password_verify($senha, $user['senha'])) {
            // Inicia a sessão e redireciona o usuário
            $_SESSION['user_id'] = $user['id'];
            header("Location: index.html"); // Redireciona para index.html
            exit();
        } else {
            // Mensagem de erro se a senha estiver incorreta
            $error = "Senha incorreta";
            echo $error;
        }
    } else {
        // Mensagem de erro se o usuário não existir
        $error = "Usuário não existe";
        echo $error;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Login</title>
    <link rel="stylesheet" href="css/login.css">
    <!-- Adicione seu CSS adicional aqui -->
</head>
<body>
    <div class="heading">
        <div class="logo"><a href="index.html"><img src="imagens/logo da loja.png" alt="LJ Store" height="50"></a></div>

        <div class="pesquisa">
            <input type="search" placeholder="O que você está procurando?">
            <div class="search">
                <button type="submit"><img src="icones/search.png" alt="search"></button>
            </div>
        </div>

        <div class="login"><a href="login.php"><img src="icones/login.png" alt="login"></a></div>

        <div class="compras"><a href="compras.html"><img src="icones/compra.png"></a></div>
    </div>

    <nav class="menu">
        <ul>
            <li><a href="index.html">Início</a></li>
            <li><a href="acessórios.html">Acessórios</a></li>
            <li><a href="brinquedos.html">Brinquedos</a></li>
            <li><a href="cozinha.html">Cozinha</a></li>
            <li><a href="decoração.html">Decoração</a></li>
            <li><a href="eletricos.html">Eletrônicos</a></li>
            <li><a href="maquiagem.html">Maquiagem</a></li>
        </ul>
    </nav>

    <main>
        <h1>Acessar o Sistema</h1>
        <br>
        <form method="post">
            <label for="email">E-mail:</label>
            <input type="email" name="email" required placeholder="E-mail (admin@admin.com)">
            
            <label for="senha">Senha:</label>
            <input type="password" name="senha" required placeholder="Senha (admin)">
            
            <button type="submit">Entrar no site</button>
        </form>
        <br>
        <p><a href="registrar.php" class="linkum">Não tem uma conta? Registre-se</a></p>
    </main>
</body>
</html>