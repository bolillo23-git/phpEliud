<?php
if (mail("lazdeypaml@gmail.com", "PRUEBA MAIL", "Este es un test desde el servidor")) {
    echo "mail OK";
} else {
    echo "mail ERROR";
}
?>
