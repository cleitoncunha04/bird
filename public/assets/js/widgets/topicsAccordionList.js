class Accordion {
    constructor(accordionListQuestions) {
        this.accordionListQuestionsSelector = accordionListQuestions;
        this.activeItemClass = "active";
    }

    // Atualiza a lista de elementos após o conteúdo dinâmico ser carregado
    updateAccordionListQuestions() {
        this.accordionListQuestions = document.querySelectorAll(this.accordionListQuestionsSelector);
    }

    toggleAccordion(question) {
        question.classList.toggle(this.activeItemClass);
        question.nextElementSibling.classList.toggle(this.activeItemClass);
    }

    addAccordionEvent() {
        this.accordionListQuestions.forEach((question) => {
            question.addEventListener('click', () => this.toggleAccordion(question));
        });
    }

    init() {
        // Reatualiza os elementos toda vez que o init é chamado
        this.updateAccordionListQuestions();

        if (this.accordionListQuestions.length) {
            this.addAccordionEvent();
        }

        return this;
    }
}

// Exportando a instância da classe Accordion
export const accordion = new Accordion('.topics__list-title');
