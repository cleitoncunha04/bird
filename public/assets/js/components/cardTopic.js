//TODO call files of the topic
import buildFile from "./cardFile.js";

export function buildCard(topic) {
    const $section = document.createElement("section");

    $section.classList.add("topics");

    $section.innerHTML = `
        <dl class="topics__list">
            <dt class="topics__list-title">${topic.name}</dt>

            <dd class="topics__list-content">
                <div>
                    <ul class="topics__list-content__options">
                        <li class="options-item">
                            <button
                                id="add-file" 
                                class="options-item__bt edit-option modal-bt" 
                                data-modal="modal-files" data-id="${topic.id}"> 
                                
                                <span class="material-symbols-outlined">add</span>
                            </button>
                        </li>
                    
                        <li class="options-item">
                            <button class="options-item__bt edit-option modal-bt" 
                                    data-modal="modal-1" 
                                    data-id="${topic.id}" 
                                    data-name="${topic.name}"
                                    data-tooltip="Editar tópico"> 
                                    
                                <span class="material-symbols-outlined">edit</span>
                            </button>
                        </li>
                        
                        <li class="options-item">
                            <a class="options-item__bt" href="http://localhost:8080/remove-topic?id=${topic.id}">
                                <span class="material-symbols-outlined">delete</span>
                            </a>
                        </li>
                    </ul>
                    
                    <ul class="topics__list-content__items">
                        
                    </ul>
                </div>
            </dd>
        </dl>
    `;

    const $ulFiles = $section.querySelector('.topics__list-content__items');

    topic.files.forEach((file) => {
        $ulFiles.appendChild(buildFile(file));
    });

    return $section;
}