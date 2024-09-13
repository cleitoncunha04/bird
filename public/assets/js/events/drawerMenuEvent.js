document.addEventListener("DOMContentLoaded", function () {
    const currentUrl = window.location.pathname; // pega URL (sem o domínio)

    const $itemsMenu = document.querySelectorAll("#side_items li a");

    $itemsMenu.forEach(item => {
        // Captura o caminho do href de cada link
        const linkPath = new URL(item.href).pathname;

        if (currentUrl === linkPath || (currentUrl.includes("/topics-discipline") && linkPath === "/topics")) {
            item.parentElement.classList.add('active');
        } else {
            item.parentElement.classList.remove('active');
        }
    });
});
