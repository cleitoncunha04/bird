import { disciplineApiConnection } from "../api/disciplineApiConnection.js";
import { redimensionMenuIcon } from "../utilis/resizeMenuIcon.js";
import { menuHamburguerEvents } from "../events/menuHamburguerEvents.js";
import { buildCard } from "../components/cardDiscipline.js";

const $ulDisciplines = document.querySelector('.disciplines__list');

export async function listDisciplines() {
    try {
        const disciplines = await disciplineApiConnection.getData();

        disciplines.forEach((discipline) => {
            const $li = buildCard(discipline);

            console.log($li);

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