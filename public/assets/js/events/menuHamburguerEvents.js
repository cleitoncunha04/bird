import { selectModal } from "./modalEvents.js";

const $disciplineNameInput = document.getElementById('name');
const $disciplineIdInput = document.querySelector('input[name="id"]');

function addMenuToggleEvent() {
    const $menuBt = document.querySelectorAll('.button__menu');
    $menuBt.forEach((button) => {
        button.addEventListener('click', () => {
            button.classList.toggle('active');
        });
    });
}

function addEditEventListeners() {
    const editButtons = document.querySelectorAll('.edit-option');
    editButtons.forEach((editButton) => {
        editButton.addEventListener('click', (event) => {
            event.preventDefault();
            const disciplineId = editButton.getAttribute('data-id');
            const disciplineName = editButton.getAttribute('data-name');

            $disciplineIdInput.value = disciplineId;
            $disciplineNameInput.value = disciplineName;

            const $modalButton = document.querySelector('.open-modal');

            const $modal = selectModal($modalButton);

            $modal.showModal();
        });
    });
}

export const menuHamburguerEvents = {
  addMenuToggleEvent,
  addEditEventListeners,
};