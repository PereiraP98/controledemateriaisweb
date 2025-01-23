<?php
// login.php
session_start();

// Se já estiver logado e tentar acessar login, redireciona para a página principal
if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
    header("Location: index.php");
    exit;
}

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Pega os valores digitados
    $usuarioForm = $_POST['usuario'] ?? '';
    $senhaForm   = $_POST['senha'] ?? '';

    // Conecta ao banco
    require_once 'conexao.php';

    try {
        // Consulta simples para buscar um usuário com o nome informado
        $sql = "SELECT * FROM usuarios WHERE usuario = :usuario LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':usuario', $usuarioForm);
        $stmt->execute();

        // Verifica se encontrou algum usuário
        if ($stmt->rowCount() > 0) {
            $usuarioBD = $stmt->fetch(PDO::FETCH_ASSOC);

            // Confere a senha (neste exemplo, sem hash, apenas comparando diretamente)
            if ($usuarioBD['senha'] === $senhaForm) {
                // Login bem-sucedido
                $_SESSION['logado'] = true;
                $_SESSION['usuario'] = $usuarioBD['usuario'];

                // Redireciona para index
                header("Location: index.php");
                exit;
            } else {
                $erro = "Senha incorreta!";
            }
        } else {
            $erro = "Usuário não encontrado!";
        }
    } catch (PDOException $e) {
        $erro = "Erro de banco de dados: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="login.css">
</head>
<body>
  <div class="login-wrapper">
    <div class="login-box">
      <div class="login-header">
        <span class="user-icon">👤</span>
      </div>
      <h2>Login</h2>

      <?php if (!empty($erro)): ?>
        <p style="color: red;"><?= $erro ?></p>
      <?php endif; ?>

      <!-- Envia para a própria página (login.php) com method POST -->
      <form action="" method="POST">
        <div class="input-group">
          <span class="icon">🙍🏻‍♂️</span>
          <input type="text" name="usuario" id="usuario" placeholder="Usuário" required>
        </div>
        <div class="input-group">
          <span class="icon">🔒</span>
          <input type="password" name="senha" id="senha" placeholder="Senha" required>
        </div>
        <button type="submit" class="btn">Entrar</button>
      </form>
    </div>
  </div>
</body>
</html>
