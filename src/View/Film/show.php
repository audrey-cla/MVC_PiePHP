<?php

foreach($scope as $film){
    echo "{{$film->titre}}  @elseif()";


    echo "<div><h3>$film->titre</h3>"
        . "<span>$film->genre - $film->date_debut_affiche</span>"
        . "<p>$film->resum</p>"
        . "</div>";
}
