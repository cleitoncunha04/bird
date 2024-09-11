function addAndRemoveClasses(icon, classNameToAdd) {
    const sizeClassesName = ['fa-xs', 'fa-lg', 'fa-xl'];

    icon.classList.forEach(className => {
        sizeClassesName.forEach(classNameToRemove => {
            if (className.includes(classNameToRemove)) {
                icon.classList.remove(className);
            }
        });
    });

    icon.classList.add(classNameToAdd);
}

export function redimensionMenuIcon() {
    const $menuIcon = document.querySelectorAll('.menu-icon');
    let widthScreen = window.innerWidth;

    if (widthScreen < 641) {
        $menuIcon.forEach(icon => addAndRemoveClasses(icon, "fa-xs"));
    } else if (widthScreen < 1008) {
        $menuIcon.forEach(icon => addAndRemoveClasses(icon, "fa-lg"));
    } else {
        $menuIcon.forEach(icon => addAndRemoveClasses(icon, "fa-xl"));
    }
}

