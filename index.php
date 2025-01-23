<?php
session_start();

// Se não estiver logado, redireciona
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.php");
    exit;
}

$usuarioLogado = $_SESSION['usuario'];
require_once 'conexao.php';

// ... (sua lógica de permissões) ...

// Definimos iniciais e descrição (caso queira manter)
$iniciais  = 'JD';
$descricao = '[descrição opcional]';

/* Exemplo de switch (caso use):
switch ($usuarioLogado) {
    case 'admin':
       $iniciais = 'ADM';
       $descricao = 'ADMIN💫 😎';
       break;
    ...
    default:
       $iniciais = strtoupper(substr($usuarioLogado, 0, 2));
       $descricao = "🙍🏻‍♂️ $usuarioLogado";
       break;
}
*/
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Controle de Materiais</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <!-- Botão "hamburger" para abrir/fechar menu em mobile -->
  <button id="mobile-menu-toggle" class="mobile-menu-toggle">☰</button>

  <div id="sidebar" class="sidebar">
    <div class="user-info">
      <div class="user-avatar"><?php echo $iniciais; ?></div>
      <div class="user-details">
        <p class="user-name"><?php echo $usuarioLogado; ?></p>
        <p class="user-role"><?php echo $descricao; ?></p>
      </div>
    </div>

    <nav id="menu">
      <ul>
        <!-- Itens de menu conforme permissões -->
        <!-- Exemplo:
        <?php if ($perm['inicio']): ?>
          <li class="menu-item" data-page="inicio.html">
            <span class="icon">🏠</span><span class="text">Início</span>
          </li>
        <?php endif; ?>
        ... -->
      </ul>
    </nav>
    <div class="menu-footer">
      <ul>
        <li class="menu-item" data-page="ajuda.html">
          <span class="icon">❓</span><span class="text">Ajuda</span>
        </li>
        <li class="menu-item" data-page="configuracoes.html">
          <span class="icon">⚙️</span><span class="text">Configurações</span>
        </li>
        <li class="menu-item" data-page="logout.php">
          <span class="icon">↩️</span><span class="text">Sair</span>
        </li>
      </ul>
    </div>
  </div>

  <main id="content">
    <!-- Conteúdo carregado dinamicamente -->
  </main>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const menuItems = document.querySelectorAll(".menu-item");
      const content = document.getElementById("content");

      // Botão "hamburger" para mobile
      const mobileToggle = document.getElementById("mobile-menu-toggle");
      const sidebar = document.getElementById("sidebar");

      // Ao clicar no "hamburger", adiciona/remove a classe .open para abrir/fechar o menu
      mobileToggle.addEventListener("click", () => {
        sidebar.classList.toggle("open");
      });

      // Função para carregar página via fetch
      const loadPage = (page) => {
        fetch(page)
          .then((response) => {
            if (!response.ok) throw new Error("Erro ao carregar a página.");
            return response.text();
          })
          .then((html) => {
            content.innerHTML = html;
            if (page === "cadastro.php") {
              attachCadastroFormHandler();
            }
          })
          .catch(() => {
            content.innerHTML = "<p>Erro ao carregar a página.</p>";
          });
      };

      function attachCadastroFormHandler() {
        const formCadastro = document.getElementById("formCadastro");
        if (!formCadastro) return;
        formCadastro.addEventListener("submit", (event) => {
          event.preventDefault();
          const formData = new FormData(formCadastro);

          fetch("cadastro.php", {
            method: "POST",
            body: formData
          })
          .then((resp) => resp.text())
          .then((updatedHtml) => {
            content.innerHTML = updatedHtml;
            attachCadastroFormHandler();
          })
          .catch((err) => {
            console.error("Erro no cadastro:", err);
          });
        });
      }

      // Clique nos itens do menu (carregamento single-page)
      menuItems.forEach((item) => {
        item.addEventListener("click", () => {
          menuItems.forEach((i) => i.classList.remove("active"));
          item.classList.add("active");

          const page = item.getAttribute("data-page");
          if (page === "logout.php") {
            window.location.href = page;
            return;
          }
          if (page) {
            loadPage(page);
            localStorage.setItem("selectedPage", page);

            // Fecha o menu se estivermos em mobile
            sidebar.classList.remove("open");
          }
        });
      });

      // Carrega página pré-selecionada
      const selectedPage = localStorage.getItem("selectedPage") || "";
      if (selectedPage) {
        const activeItem = document.querySelector(`[data-page="${selectedPage}"]`);
        if (activeItem) {
          activeItem.classList.add("active");
          loadPage(selectedPage);
        }
      }
    });
  </script>
</body>
</html>