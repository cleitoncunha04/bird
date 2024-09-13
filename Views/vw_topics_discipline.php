<?php
$this->layout('vw_menu');

$_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
?>

<link rel="stylesheet" href="/assets/css/modal.css">
<link rel="stylesheet" href="/assets/css/topics.css">

<main class="container">
    <h1 class="container__title"></h1>

    <button class="open-modal" data-modal="modal-1">
        <i class="fa-solid fa-plus"></i>
    </button>

    <dialog id="modal-1">
        <form
                action="/save-topic"
                method="post"
                enctype="multipart/form-data"
        >
            <input type="hidden" name="id" value="">

            <div class="modal-header">
                <h1 class="modal-title">
                    Adicionar Tópico
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
                        book_5
                    </span>

                    <input
                            type="text"
                            id="name"
                            name="name"
                            placeholder="Informe o nome da disciplina"
                            value=""
                            required
                    >
                </div>

                <button id="create_discipline-button" style="background: #154324; color: white">
                    Salvar
                </button>
            </div>
        </form>
    </dialog>
</main>

<script src="/assets/js/mainTopicDiscipline.js" type="module"></script>
