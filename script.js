document.addEventListener("DOMContentLoaded", () => {
  const menuItems = document.querySelectorAll(".menu-item"); // Seleciona todos os itens do menu
  const content = document.getElementById("content"); // Área onde o conteúdo será carregado

  // Função para carregar a página associada ao menu
  const loadPage = (page) => {
    fetch(page)
      .then((response) => {
        if (!response.ok) throw new Error("Erro ao carregar a página.");
        return response.text();
      })
      .then((html) => {
        content.innerHTML = html; // Atualiza o conteúdo da página
      })
      .catch(() => {
        content.innerHTML = "<p>Erro ao carregar a página.</p>";
      });
  };

  // Adiciona evento de clique para cada item do menu
  menuItems.forEach((item) => {
    item.addEventListener("click", () => {
      // Remove o atributo data-selected de todos os itens
      menuItems.forEach((i) => i.removeAttribute("data-selected"));

      // Define o atributo data-selected no item clicado
      item.setAttribute("data-selected", "true");

      // Carrega a página correspondente
      const page = item.getAttribute("data-page");
      if (page) loadPage(page);

      // Salva a página selecionada no localStorage
      localStorage.setItem("selectedPage", page);
    });
  });

  // Define o item ativo e carrega a página inicial ou a última selecionada
  const selectedPage = localStorage.getItem("selectedPage") || "inicio.html";
  const activeItem = document.querySelector(`[data-page="${selectedPage}"]`);

  if (activeItem) {
    activeItem.setAttribute("data-selected", "true"); // Define como ativo
    loadPage(selectedPage); // Carrega a página correspondente
  }
});
