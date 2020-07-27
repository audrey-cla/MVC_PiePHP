<?php

echo '<form accept-charset="UTF-8" action="" autocomplete="off" method="POST">';
foreach ($scope as $key => $value) {

    foreach ($value as $key => $data) {

        preg_match('/^id.*$/', $key, $matches);
        if (!is_numeric($key) && !(in_array($key, $matches))) {
            echo "<label for='$key'>$key</label><input name='$key' value='$data' type='text'/> <br />\n";
        }
    }
}
echo '<button type="submit" value="Submit">Valider les changements</button></form>';
