const buildTopicsLi = (topic) => {
    const $li = document.createElement('li');

    $li.classList.add('list_item');

    $li.innerHTML = `
            <li class="list_item">
                <span class="list_item-name">${topic.name}</span>

                <button class="list_item-add-topic">
                    <span class="material-symbols-outlined">
                        add
                    </span>
                </button>
            </li>`;

    return $li;
};

export default buildTopicsLi;