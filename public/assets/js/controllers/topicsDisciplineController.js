import {topicApi} from "../api/topicApiConnection.js";
import {buildCard} from "../components/cardTopic.js";
import {addEvtListener} from "../events/modalEvents.js";
import listTopicsLi from "../events/modalAllTopicsEvent.js";

const $containerTopics = document.querySelector('.container');
const $containerTitle = document.querySelector('.container__title');

export async function listTopicsDiscipline(disciplineId) {
    try {
        await listTopicsLi();
        
        const topicsData = await topicApi.getTopicsOfDiscipline(disciplineId);

        const discipline = topicsData[disciplineId];

        $containerTitle.textContent = discipline.discipline_name;

        const topics = discipline.topics;

        topics.forEach((topic) => {
            const $section = buildCard(topic);
            $containerTopics.appendChild($section);
        });


        addEvtListener();
    } catch (error) {
        const $h2 = document.createElement("h2");
        $h2.textContent = `Não há temas anexados a esta disciplina`;
        $containerTopics.appendChild($h2);
    }
}


