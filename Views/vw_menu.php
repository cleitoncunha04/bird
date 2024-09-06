<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="/assets/images/bird-logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
          integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <script src="/assets/js/menu.js" defer></script>
    <title>BIRD</title>
</head>
<body>

<nav id="sidebar">
    <div class="sidebar_content">
        <div id="user">
            <img src="/assets/images/bird-logo.png" alt="Avatar" id="user_avatar">

            <p id="user__infos">
                    <span class="item-description">
                        Cleiton Cunha
                    </span>

                    <span class="item-description">
                        Lorem Ipsum
                    </span>
            </p>
        </div>

        <ul id="side_items">
            <li class="side-item">
                <a href="#">
                    <i class="fa-solid fa-magnifying-glass"></i>

                    <span class="item-description">
                        Pesquisar
                    </span>
                </a>
            </li>

            <li class="side-item active">
                <a href="#">
                    <i class="fa-solid fa-house"></i>

                    <span class="item-description">
                        Início
                    </span>
                </a>
            </li>

            <li class="side-item">
                <a href="#">
                    <i class="fa-solid fa-book"></i>

                    <span class="item-description">
                        Temas
                    </span>
                </a>
            </li>

            <li class="side-item">
                <a href="#">
                    <i class="fa-solid fa-user"></i>

                    <span class="item-description">
                        Sua conta
                    </span>
                </a>
            </li>
        </ul>

        <button id="open_btn">
            <i class="fa-solid fa-chevron-right" id="open_btn_icon"></i>
        </button>
    </div>

    <div id="logout">
        <button id="logout_btn">
            <i class="fa-solid fa-right-from-bracket"></i>

            <span class="item-description">
                Logout
            </span>
        </button>
    </div>
</nav>

<?= $this->section('content') ?>

</body>
</html>
