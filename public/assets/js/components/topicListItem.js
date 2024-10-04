const buildTopicsLi = (topic) => {
    const $li = document.createElement('li');

    $li.classList.add('list_item');

    $li.innerHTML = `<span class="list_item-name">${topic.name}</span>

                <a class="list_item-add-topic" href='http://localhost:8080/save-existent-topic?id=${topic.id}'>
                    <span class="material-symbols-outlined">
                        add
                    </span>
                </a>`;

    return $li;
};

export default buildTopicsLi;