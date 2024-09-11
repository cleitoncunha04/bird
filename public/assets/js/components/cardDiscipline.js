function createMenuOptions(discipline) {
    return `
        <ul class="menu-list">
            <li class="menu-list__title">Opções</li>
            <li class="menu-list__item edit-option" data-id="${discipline.id}" data-name="${discipline.name}">
                <span>Editar&nbsp;&nbsp;</span>
                <i class="fa-solid fa-pen-to-square"></i>
            </li>
            <a href="http://localhost:8080/remove-discipline?id=${discipline.id}">
                <li class="menu-list__item">
                    <span>Excluir</span>
                    <i class="fa-solid fa-trash"></i>
                </li>
            </a>
        </ul>`;
}

export function buildCard(discipline) {
    const $liDisciplines = document.createElement("li");
    $liDisciplines.classList.add("disciplines__li");

    $liDisciplines.innerHTML = `
            
            <div class="discipline__li-banner">
                <a href="http://localhost:8080/topics?=discipline_id=${discipline.id}" target="_blank">
                <img src="${discipline.banner_image}" alt="Banner da disciplina: ${discipline.name}">
                </a>
            </div>
            <div class="discipline__li-infos">
                <h2 class="discipline-infos__title">${discipline.name}</h2>
                
                <button name="menu-hamburguer" class="button__menu">
                    <i class="fa-solid fa-ellipsis-vertical menu-icon"></i>
                </button>
                
                ${createMenuOptions(discipline)}
            </div>`;
    return $liDisciplines;
}