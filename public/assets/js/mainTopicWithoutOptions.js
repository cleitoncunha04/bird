import { listTopics } from "./controllers/topicController.js";
import { accordion } from "./widgets/topicsAccordionList.js";

document.addEventListener('DOMContentLoaded', async () => {
    try {
        await listTopics(false);

        accordion.init();
    } catch (error) {
        console.error("Error initializing topics or accordion:", error);
    }
})