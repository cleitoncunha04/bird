<?php

$this->layout('vw_menu');

/**
 * @var ?Discipline $discipline
 */
?>

<link rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>

<link rel="stylesheet" href="/assets/css/modal.css">
<link rel="stylesheet" href="/assets/css/disciplines.css">

<main>
    <ul class="disciplines__list">
    </ul>

    <button class="open-modal" data-modal="modal-1">
        <i class="fa-solid fa-plus"></i>
    </button>

    <dialog id="modal-1">
        <form
                action="/save-discipline"
                method="post"
                enctype="multipart/form-data"
        >
            <input type="hidden" name="id" value="<?= isset($discipline) && $discipline?->id ? $discipline->id : ''; ?>">

            <div class="modal-header">
                <h1 class="modal-title">
                    <?= isset($discipline) && $discipline?->id ? 'Editar disciplina:' : 'Criar disciplina:' ?>
                </h1>
                <button
                        class="close-modal"
                        data-modal="modal-1"
                        type="button"
                >
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="input-group">
                    <span class="material-symbols-outlined">
                        folder_special
                    </span>

                    <input
                            type="text"
                            id="name"
                            name="name"
                            placeholder="Informe o nome da disciplina"
                            value="<?= isset($discipline) && $discipline?->name ? $discipline->name : ""; ?>"
                            required
                    >
                </div>

                <div class="input-group" data-file="true">
                    <label for="image">
                        Imagem de capa

                        <span class="material-symbols-outlined">
                            download
                        </span>
                    </label>

                    <input
                            type="file"
                            id="image"
                            name="image"
                            accept="image/*"
                    >
                </div>

                <button id="create_discipline-button">
                    Salvar
                </button>
            </div>
        </form>
    </dialog>
</main>

<script src="/assets/js/main.js" type="module"></script>
