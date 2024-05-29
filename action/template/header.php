<header class="header">
    <nav id="nav_header">
        <img id="header_img" src="template/images/logo.png">
        <a class="nav_link" href="/">Главная</a>
        <a class="nav_link" href="/create_post.php">Создать объявление</a>
        <?php 
            if ($_SESSION['user']['role'] == 2) {
                echo "<a class='nav_link' href='/admin.php'>Админ панель</a>";
            }
        ?>
        <a class="nav_link" href="profile.php">Профиль</a>
    </nav>
</header>
<div id="search_main">
    <form action="search.php" method="get">
        <input name="search_text" placeholder="Введите запрос (@ для пользователя)" type="text">
        <label>Тип кузова</label>
        <select name="type_carcase">
            <option value="Любой">Любой</option>
            <option value="Седан">Седан</option>
            <option value="Купе">Купе</option>
            <option value="Пикап">Пикап</option>
            <option value="Джип">Джип</option>
        </select>
        <label>Сортировка</label>
        <select name="type_sort">
            <option value="По цене">По цене</option>
            <option value="По дате">По дате</option>
        </select>
        <button>Найти</button>
    </form>
</div>
