
<?php
foreach ($scope as $key => $value) {
    $titre = $value['titre'];
    $id_film = $value['id_film'];
    echo "<a href='/MVC_PiePHP/film/show/$id_film'>$titre</a><br>";
}

echo "@foreach(user as user)";?>