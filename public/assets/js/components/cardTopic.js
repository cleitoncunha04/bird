//TODO call files of the topic
export function buildCard(topic) {
    const $section = document.createElement("section");

    $section.classList.add("topics");

    $section.innerHTML = `
        <dl class="topics__list">
            <dt class="topics__list-title">${topic.name}</dt>

            <dd class="topics__list-content">
                <div>
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