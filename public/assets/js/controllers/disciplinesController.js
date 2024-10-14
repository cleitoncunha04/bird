import { disciplineApiConnection } from "../api/disciplineApiConnection.js";
import { redimensionMenuIcon } from "../utilis/resizeMenuIcon.js";
import { menuHamburguerEvents } from "../events/menuHamburguerEvents.js";
import { buildCard } from "../components/cardDiscipline.js";
import {addEvtListener} from "../events/modalEvents.js";

const $ulDisciplines = document.querySelector('.disciplines__list');

export async function listDisciplines() {
    try {
        const disciplines = await disciplineApiConnection.getData();

        disciplines.forEach((discipline) => {
            const $li = buildCard(discipline);

            $ulDisciplines.appendChild($li);
        });

        menuHamburguerEvents.addMenuToggleEvent();

        menuHamburguerEvents.addEditEventListeners();

        redimensionMenuIcon();

        addEvtListener();

        window.addEventListener('resize', redimensionMenuIcon);
    } catch (error) {
        $ulDisciplines.innerHTML = error.message;
    }
}