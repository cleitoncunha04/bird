const btLogin = document.querySelector("#btEntrar");

btLogin.addEventListener('click', function(){
  Swal.fire({
    title: "Tudo certo...",
    text: "Login realizado com sucesso!!!",
    icon: "success",
    showConfirmButton: false,
    timer: 1000,
  });
});
