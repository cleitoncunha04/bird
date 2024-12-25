import { selectModal } from "./modalEvents.js";
import { topicApi } from "../api/topicApiConnection.js";
import buildTopicsLi from "../components/topicListItem.js";

const $ulAllTopics = document.querySelector('.topics-body_list');

const listTopicsLi = async () => {
    try {
        const topicsData = await topicApi.getTopics();

        // Criação do campo de busca
        const $liSearch = document.createElement("li");
        $liSearch.classList.add('list_item_search');

        $liSearch.innerHTML = `
        <div class="list_item_search__textField">
            <span class="material-symbols-outlined">search</span>

            <input
                    type="text"
                    name="search"
                    placeholder="Pesquise o tema aqui..."
                    id="idSearch"
                    class="list_item_search__textField__input"
            />
        </div>`;

        $ulAllTopics.appendChild($liSearch);

        const $inputSearch = $liSearch.querySelector('#idSearch');

        // Função para atualizar os tópicos filtrados
        const updateTopicsList = (searchValue) => {
            // Limpa todos os itens (menos o campo de busca)
            const $topicItems = Array.from($ulAllTopics.querySelectorAll('li'));
            $topicItems.forEach(item => {
                if (!item.classList.contains('list_item_search')) {
                    item.remove();
                }
            });

            // Filtra os tópicos e recria os itens
            const filteredTopics = topicsData.filter(topic =>
                topic.name.toLowerCase().includes(searchValue)
            );

            filteredTopics.forEach((topic) => {
                const $li = buildTopicsLi(topic);
                $ulAllTopics.appendChild($li);
            });
        };

        // Adiciona o evento 'input' para filtrar em tempo real
        $inputSearch.addEventListener('input', (event) => {
            const searchValue = event.target.value.toLowerCase();
            updateTopicsList(searchValue);
        });

        // Adiciona todos os tópicos inicialmente
        topicsData.forEach((topic) => {
            const $li = buildTopicsLi(topic);
            $ulAllTopics.appendChild($li);
        });
    } catch (error) {
        const $h2 = document.createElement("h2");
        $h2.textContent = `Erro ao carregar os temas: ${error}`;
        $ulAllTopics.appendChild($h2);
    }
};

// Eventos de modais
const $openAllTopicsBts = document.querySelectorAll('.open-modal-all-topics');
$openAllTopicsBts.forEach((button) => {
    button.addEventListener('click', async () => {
        const topicsData = await topicApi.getTopics();
        if (topicsData.length === 0) {
            button.setAttribute('data-modal', 'modal-1');
            button.classList.add('modal-bt');
        }
        const $modal = selectModal(button);
        $modal.classList.remove('hidden');
        $modal.showModal();
    });
});

const $closeModalBts = document.querySelectorAll('.topics-header_close-modal');
$closeModalBts.forEach((button) => {
    button.addEventListener('click', () => {
        const $modal = selectModal(button);
        $modal.classList.toggle('hidden');
        $modal.close();
    });
});

export default listTopicsLi;
