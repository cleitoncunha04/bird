import {topicApi} from "../api/topicApiConnection.js";
import {buildCard} from "../components/cardTopic.js";

const $containerTopics = document.querySelector(".container");

export async function listTopics() {
    try {
        const topicsData = await topicApi.getTopics();

        topicsData.forEach((topic) => {
            const $section = buildCard(topic);

            $containerTopics.appendChild($section)
        });
    } catch (error) {
        const $h2 = document.createElement("h2");

        $h2.textContent = `Error on loading topics: ${error}`;

        $containerTopics.appendChild($h2);
    }
}