<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link
            rel="shortcut icon"
            href="/assets/images/bird-logo.ico"
            type="image/x-icon"
    />
    <link
            rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
    />
    <link rel="stylesheet" href="/assets/css/login.css"/>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    <!--<script src="/assets/js/animations/stripes&Hero.js" defer></script>-->
    <!--<script src="./assets/js/alertDialog.js" defer></script>-->
    <script src="/assets/js/eye-password.js" defer></script>
    <title>Login</title>
</head>
<body>
<!--<div class="overlay">
    <div class="bar"></div>
    <div class="bar"></div>
    <div class="bar"></div>
    <div class="bar"></div>
    <div class="bar"></div>
    <div class="bar"></div>
    <div class="bar"></div>
    <div class="bar"></div>
    <div class="bar"></div>
    <div class="bar"></div>
</div>
-->
<main>
    <div class="loginLogo">
        <div class="loginLogo__alinhamento">
            <img
                    class="logo"
                    src="/assets/images/bird-logo.png"
                    alt="Logo do Bird"
            />
            <div class="loginLogo__alinhamento__texto">
                <h2 class="tablet">Não possui uma conta?</h2>
                <h2 class="desktop">Criar conta</h2>
                <p>Tenha acesso a Base Institucional de Recursos Didáticos</p>
                <a href="/singup">Registre-se</a>
            </div>
        </div>
    </div>

    <form action="#" id="formLogin">
        <h1 class="mobile-tablet">Login</h1>
        <h1 class="desktop">Já possui uma conta?</h1>

        <div class="formLogin__textField">
            <span class="material-symbols-outlined">mail</span>

            <input
                    type="email"
                    name="email"
                    placeholder="Informe seu e-mail..."
                    id="idEmail"
                    class="formLogin__textField__input"
            />
        </div>

        <div class="formLogin__textField">
            <span class="material-symbols-outlined">lock</span>

            <input
                    type="password"
                    name="senha"
                    placeholder="Informe sua senha..."
                    id="idSenha"
                    class="formLogin__textField__input"
                    data-password="true"
            />

            <span class="material-symbols-outlined eye-password">visibility</span>
        </div>

        <div class="formLogin__links"><a href="#">Recuperar conta...</a></div>

        <input type="submit" value="Entrar" id="btEntrar"/>

        <div class="formLogin__links mobile">
            <p>Não possui uma conta? <a href="/singup">Crie aqui...</a></p>
        </div>
    </form>
</main>
</body>
</html>
