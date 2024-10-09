const buildFile = (file) => {
    const $li = document.createElement('li');

    $li.classList.add('content-item');

    $li.innerHTML = `
        <a class="content-item__option" href="/remove-file?id=${file.id}">
            <span class="material-symbols-outlined">close</span>
        </a>
        <a href="${file.file_name}" download>
            ${file.name}
        </a>
    `;
    return $li;
};

export default buildFile;