const $dialog = document.createElement("dialog");

$dialog.setAttribute("id", "modal-1");

$dialog.innerHTML = `
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
`;