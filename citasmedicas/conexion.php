<?php
function conectarse() {
    $link = new mysqli("localhost", "root", "", "essaludbd1");

    if ($link->connect_errno) {
        echo '<script>
            (function() {
                var retry = confirm("Error de conexión. Intente nuevamente más tarde. ¿Desea reintentar?");
                if (retry) {
                    window.location.reload();
                } else {
                    window.location.href = "index.php";
                }
            })();
        </script>';
        exit();
    }

    return $link;
}
?>
