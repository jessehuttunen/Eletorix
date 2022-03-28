<?php
    require "header.php";
?>

<main>
<?php
    if (isset($_SESSION['userId'])) {
        echo '<p>Olet kirjautuneena</p>';
    }
    else {
        echo '<p>Olet kirjautuneena ulos</p>';
    }
?>    
</main>


<?php
    require "footer.php";
?>
