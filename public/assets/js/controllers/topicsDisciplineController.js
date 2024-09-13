import {topicApi} from "../api/topicApiConnection.js";
import {buildCard} from "../components/cardTopic.js";
import {selectModal} from "../events/modalEvents.js";

const $containerTopics = document.querySelector('.container');
const $containerTitle = document.querySelector('.container__title');

export async function listTopicsDiscipline(disciplineId) {
    try {
        // Obtém os dados da conexão
        const topicsData = await topicApi.getTopicsOfDiscipline(disciplineId);

        const discipline = topicsData[disciplineId];

        $containerTitle.textContent = discipline.discipline_name;

        const topics = discipline.topics;

        // Itera sobre os tópicos e constrói os cards
        topics.forEach((topic) => {
            const $section = buildCard(topic); // Passa cada tópico para buildCard
            $containerTopics.appendChild($section); // Adiciona o card no container
        });
    } catch (error) {
        const $h2 = document.createElement("h2");
        $h2.textContent = `Error on loading topics: ${error.message}`;
        $containerTopics.appendChild($h2);
    }
}


