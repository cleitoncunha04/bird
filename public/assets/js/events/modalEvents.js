const $disciplineNameInput = document.getElementById('name');
const $disciplineIdInput = document.querySelector('input[name="id"]');

function clearFormFields() {
    $disciplineNameInput.value = '';
    $disciplineIdInput.value = '';
}

export function selectModal(button) {
    const modalId = button.getAttribute('data-modal');

    return document.getElementById(modalId);
}

const $openButtons = document.querySelectorAll('.open-modal');

$openButtons.forEach((button) => {
    button.addEventListener('click', () => {
        const $modal = selectModal(button);

        const isCreateAction = !button.closest('.edit-option');
        if (isCreateAction) {
            clearFormFields();  // Limpa os campos sempre ao adicionar nova disciplina
        }

        $modal.showModal();
    });
});

const $closeButtons = document.querySelectorAll('.close-modal');

$closeButtons.forEach((button) => {
    button.addEventListener('click', () => {
        const $modal = selectModal(button);

        $modal.close();
    });
});
