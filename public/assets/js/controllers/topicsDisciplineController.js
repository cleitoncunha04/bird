import {topicApi} from "../api/topicApiConnection.js";
import {buildCard} from "../components/cardTopic.js";
import {selectModal} from "../events/modalEvents.js";

const $containerTopics = document.querySelector('.container');
const $containerTitle = document.querySelector('.container__title');

export async function listTopicsDiscipline(disciplineId) {
    try {
        const topicsData = await topicApi.getTopicsOfDiscipline(disciplineId);

        const discipline = topicsData[disciplineId];

        $containerTitle.textContent = discipline.discipline_name;

        const topics = discipline.topics;

        topics.forEach((topic) => {
            const $section = buildCard(topic);
            $containerTopics.appendChild($section);
        });
    } catch (error) {
        const $h2 = document.createElement("h2");
        $h2.textContent = `Não há temas anexados a esta disciplina`;
        $containerTopics.appendChild($h2);
    }
}


