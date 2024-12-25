import {topicApi} from "../api/topicApiConnection.js";
import {buildCard} from "../components/cardTopic.js";

const $containerTopics = document.querySelector(".container");

export async function listTopics(isOption = true) {
    try {
        const topicsData = await topicApi.getTopics();

        console.log(topicsData);

        topicsData.forEach((topic) => {
            const $section = buildCard(topic, isOption);

            $containerTopics.appendChild($section)
        });
    } catch (error) {
        const $h2 = document.createElement("h2");

        $h2.textContent = `Error on loading topics: ${error}`;

        $containerTopics.appendChild($h2);
    }
}
