const $spanEye = document.querySelectorAll("span.eye-password");
const $inputPassword = document.querySelectorAll('[data-password="true"]');

let isVisible = false;

$spanEye.forEach((eye, index) => {
    eye.addEventListener("click", () => {
        isVisible = !isVisible;

        if (isVisible) {
            eye.innerText = "visibility";
            $inputPassword[index].setAttribute("type", "text");
        } else {
            eye.innerText = "visibility_off";
            $inputPassword[index].setAttribute("type", "password");
        }
    });
});
