<?php
// Inicia a sessão
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php'); // Redireciona para o login se não estiver logado
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Início</title>
  <link rel="stylesheet" href="inicio.css">
</head>
<body>
  <header>
    <h1>Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</h1>
    <a href="logout.php" class="logout-btn">Sair</a>
  </header>
  <main>
    <p>Este é o sistema de controle de materiais.</p>
    <p>Você está logado como: <strong><?php echo htmlspecialchars($_SESSION['usuario']); ?></strong>.</p>
  </main>
</body>
</html>
