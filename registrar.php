<?php
require "include/config.php";
$mensagem = ""; // Variável para armazenar mensagens

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados do formulário
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verifica se o e-mail já está registrado
    $verificaEmail = $conexao->prepare("SELECT id FROM usuario WHERE email = ?");
    $verificaEmail->bind_param("s", $email);
    $verificaEmail->execute();
    $resultado = $verificaEmail->get_result();

    if ($resultado->num_rows === 0) {
        // Hash da senha
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $parametro = $conexao->prepare("INSERT INTO usuario (email, senha) VALUES (?, ?)");
        $parametro->bind_param("ss", $email, $senhaHash);
        if ($parametro->execute()) {
            $mensagem = "Conta criada com sucesso! Você pode fazer login agora.";
        } else {
            $mensagem = "Erro ao registrar o usuário.";
        }
    } else {
        $mensagem = "E-mail já registrado.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
    <h1>Registrar Nova Conta</h1>
    <br>
    <form method="post">
        <label for="email">E-mail:</label>
        <input type="email" name="email" required placeholder="E-mail">
        
        <label for="senha">Senha:</label>
        <input type="password" name="senha" required placeholder="Senha">
        
        <button type="submit">Registrar</button>
    </form>
    <br>
    <?php if ($mensagem): ?>
        <p><?php echo $mensagem; ?></p>
    <?php endif; ?>
    <p><a href="login.php" class="linkum">Já tem uma conta? Faça login</a></p>
</body>
</html>
