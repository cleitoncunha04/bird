import {listTopicsDiscipline} from "./controllers/topicsDisciplineController.js";
import {accordion} from "./widgets/topicsAccordionList.js";
import listTopicsLi from "./events/modalAllTopicsEvent.js";

let params = new URLSearchParams(document.location.search);
let disciplineId = params.get("discipline_id");

document.addEventListener("DOMContentLoaded", async () => {
    try {
        await listTopicsDiscipline(disciplineId);

        accordion.init();

        await listTopicsLi();
    } catch (error) {
        console.error("Error initializing topics or accordion:", error);
    }
});
