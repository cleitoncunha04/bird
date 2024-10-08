import {selectModal} from "./modalEvents.js";
import {topicApi} from "../api/topicApiConnection.js";
import buildTopicsLi from "../components/topicListItem.js";

const $ulAllTopics = document.querySelector('.topics-body_list');

const listTopicsLi = async () =>  {
    try {
        const topicsData = await topicApi.getTopics();

        topicsData.forEach((topic) => {
            const $li = buildTopicsLi(topic);

            $ulAllTopics.appendChild($li);
        });
    } catch (error) {
        const $h2 = document.createElement("h2");

        $h2.textContent = `Error on loading topics: ${error}`;

        $ulAllTopics.appendChild($h2);
    }
};

const $openAllTopicsBts = document.querySelectorAll('.open-modal-all-topics');

$openAllTopicsBts.forEach((button)  =>  {
    button.addEventListener('click', async ()  => {
        const topicsData = await topicApi.getTopics();

        if (topicsData.length === 0) {
            button.setAttribute('data-modal', 'modal-1');
            button.classList.add('modal-bt');
        }

        const $modal = selectModal(button);

        $modal.classList.remove('hidden');

        $modal.showModal();
    });
});

const $closeModalBts = document.querySelectorAll('.topics-header_close-modal');

$closeModalBts.forEach((button) => {
    button.addEventListener('click', () => {
        const $modal = selectModal(button);

        $modal.classList.toggle('hidden');

        $modal.close();
    });
});

export default listTopicsLi;