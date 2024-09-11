document.addEventListener("DOMContentLoaded", function () {
    const currentUrl = window.location.pathname; // Captura o caminho da URL atual (sem domínio)

    const $itemsMenu = document.querySelectorAll("#side_items li a");

    $itemsMenu.forEach(item => {
        // Captura o caminho do href de cada link
        const linkPath = new URL(item.href).pathname;

        // Verifica se o caminho da URL atual corresponde exatamente ao caminho do link
        if (currentUrl === linkPath) {
            item.parentElement.classList.add('active');
        } else {
            item.parentElement.classList.remove('active');
        }
    });
});
