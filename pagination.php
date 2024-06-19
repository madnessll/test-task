<?php
$page_url = "{$page_url}page=";
$total_pages = ceil($total_rows / $records_per_page);

echo "<ul class='pagination'>";

// Кнопка для первой страницы
if ($page > 1) {
    echo "<li><a href='{$page_url}1' title='Первая страница'>Первая</a></li>";
}

// Счётчик страниц
$range = 2;
$initial_num = $page - $range;
$condition_limit_num = ($page + $range) + 1;

for ($x = $initial_num; $x < $condition_limit_num; $x++) {
    if (($x > 0) && ($x <= $total_pages)) {
        if ($x == $page) {
            echo "<li class='active'><a href='#'>{$x}</a></li>";
        } else {
            echo "<li><a href='{$page_url}{$x}'>{$x}</a></li>";
        }
    }
}

// Кнопка для последней страницы
if ($page < $total_pages) {
    echo "<li><a href='{$page_url}{$total_pages}' title='Последняя страница'>Последняя</a></li>";
}

echo "</ul>";
?>

<style>
.pagination {
    display: flex;
    list-style: none;
    padding: 0;
}

.pagination li {
    margin: 0 5px;
}

.pagination li a {
    display: block;
    padding: 10px 15px;
    background: black;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background 0.3s ease;
}

.pagination li a:hover {
    background: white;
    border: 1px solid black;
    color: black;
}

.pagination li.active a {
    background: white;
    border: 1px solid black;
    color: black;
}
</style>
