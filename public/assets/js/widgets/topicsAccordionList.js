class Accordion {
    constructor(accordionListQuestions) {
        this.accordionListQuestions = document.querySelectorAll(accordionListQuestions);

        this.activeItemClass = "active";
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
        if (this.accordionListQuestions.length) {
            this.addAccordionEvent();
        }

        return this;
    }
}

const accordion = new Accordion('.topics__list-title');

accordion.init();

