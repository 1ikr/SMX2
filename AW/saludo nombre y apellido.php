<!DOCTYPE html>
<html>
    <!-- capçalera-->

    <head>
        <meta charset="UTF-8">
        <title>Títol de la plana</title>
    </head>
    <!-- cos-->

    <body>

        <?php
     $nom = isset($_GET["nom"]) ? $_GET["nom"] : "";
     $llinatge = isset($_GET["llinatge"]) ? $_GET["llinatge"] : "";

     if (($nom !="" ) and ($llinatge != "")) {
        $tengo_datos = true;
     } else {
        $tengo_datos = false;
     }
    ?>

        <form action="exget.php" method="get">
            Nom*: <input type="text" name="nom" value="<?php echo $nom; ?>" required><br>
            Llinatge*: <input type="text" name="llinatge" required value="<?php echo $llinatge; ?>"><br>
            <input type="submit" value="Saludar">
        </form>
        <?php
     if($tengo_datos==true) {
        echo "Hola $nom $llinatge <br>";
          } else {
            echo "Introdueix nom i llinatges<br>";
          }     
     ?>
    </body>

</html>
