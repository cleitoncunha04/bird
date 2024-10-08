//TODO call files of the topic
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
                        <li class="content-item">
                            <a
                                    href="https://www.youtube.com/watch?v=u5hge87rCCQ"
                                    target="_blank">
                                Conheça a propriedade <strong>readonly</strong> do PHP
                            </a>
                        </li>

                        <li class="content-item">
                            <a
                                    href="https://www.youtube.com/watch?v=u5hge87rCCQ"
                                    target="_blank">
                                Conheça a propriedade <strong>readonly</strong> do PHP
                            </a>
                        </li>

                        <li class="content-item">
                            <a
                                    href="https://www.youtube.com/watch?v=u5hge87rCCQ"
                                    target="_blank">
                                Conheça a propriedade <strong>readonly</strong> do PHP
                            </a>
                        </li>
                    </ul>
                </div>
            </dd>
        </dl>
    `;

    return $section;
}