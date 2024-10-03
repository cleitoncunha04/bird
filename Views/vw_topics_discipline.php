<?php
$this->layout('vw_menu');

$_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
?>

<link rel="stylesheet" href="/assets/css/styles.css">
<link rel="stylesheet" href="/assets/css/modal.css">
<link rel="stylesheet" href="/assets/css/topics.css">
<link rel="stylesheet" href="/assets/css/modal-all_topics.css">

<main class="container">
    <h1 class="container__title"></h1>

    <?php if (isset($_SESSION['error_message'])) : ?>

        <h2 class="formulario__mensagem-erro">
            <?php echo $_SESSION['error_message'];

            unset($_SESSION['error_message']) ?>
        </h2>

    <?php endif; ?>

    <button class="open-modal-all-topics" data-modal="modal-all_topics">
        <i class="fa-solid fa-plus"></i>
    </button>

    <dialog id="modal-all_topics" class="hidden">
        <form action="" method="post">
            <div class="modal-all_topics-header">
                <h1 class="topics-header_tittle">Selecione o tema:</h1>
                <button class="topics-header_close-modal" type="button" data-modal="modal-all_topics">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <div class="modal-all_topics-body">
                <ul class="topics-body_list">
                </ul>
            </div>
        </form>

        <button class="modal-all_topics-button__new-topic" data-modal="modal-1">Novo tema</button>
    </dialog>

    <dialog id="modal-1">
        <form
                action="/save-topic"
                method="post"
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
<script src="/assets/js/events/modalAllTopicsEvent.js" type="module"></script>
