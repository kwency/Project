<?php
function connected (){  
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return !empty($_SESSION['connected']);
}
?>