import { connectionApi } from "../api/connectionApi.js";
import { redimensionMenuIcon } from "../utilis/resizeMenuIcon.js";
import { menuHamburguerEvents } from "../events/menuHamburguerEvents.js";
import { buildCard } from "../components/cardDiscipline.js";

const $ulDisciplines = document.querySelector('.disciplines__list');

export async function listDisciplines() {
    try {
        const disciplines = await connectionApi.getData();

        disciplines.forEach((discipline) => {
            const $li = buildCard(discipline);
            $ulDisciplines.appendChild($li);
        });

        menuHamburguerEvents.addMenuToggleEvent();
        menuHamburguerEvents.addEditEventListeners();
        redimensionMenuIcon();
        window.addEventListener('resize', redimensionMenuIcon);
    } catch (error) {
        $ulDisciplines.innerHTML = error.message;
    }
}