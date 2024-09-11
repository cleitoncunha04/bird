let isOpen = false;

document.getElementById("open_btn").addEventListener("click", function() {
    document.getElementById("sidebar").classList.toggle("open-sidebar");

    isOpen = !isOpen;

    if (isOpen) {
        document.getElementById("user").style.justifyContent = "flex-start";
    } else {
        document.getElementById("user").style.justifyContent = "center";
    }
});