const $modalTitle = document.querySelector('.modal-title');
const $nameInput = document.getElementById('name');
const $idInput = document.querySelector('input[name="id"]');

function clearFormFields() {
    $nameInput.value = '';
    $idInput.value = '';
}

export function selectModal(button) {
    const modalId = button.getAttribute('data-modal');
    return document.getElementById(modalId);
}

export function addEvtListener(){
    const $openButtons = document.querySelectorAll('.modal-bt');

    $openButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const $modal = selectModal(button);

            if (button.hasAttribute('data-name')) {
                $modalTitle.textContent = "Editar:";

                $idInput.value = button.getAttribute('data-id');

                $nameInput.value = button.getAttribute('data-name');
            } else {
                $modalTitle.textContent = "Criar:";

                clearFormFields();

                if ($modal.getAttribute('id') === 'modal-files') {
                    $modal.querySelector('#topic-id').value = button.getAttribute('data-id');
                }
            }

            $modal.showModal();
        });
    });
}




const $closeButtons = document.querySelectorAll('.close-modal');

$closeButtons.forEach((button) => {
    button.addEventListener('click', () => {
        const $modal = selectModal(button);
        $modal.close();
    });
});
