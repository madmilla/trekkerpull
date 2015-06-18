<?php
    require 'db.php';
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( null==$id ) {
        header("Location: index.php");
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM heat where heat_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
    }
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>
 
<body>
    <div class="container">

        <div class="span10 offset1">
            <div class="row">
                <h3>Overzicht: <?=$data['heat_naam']?></h3>
            </div>
        </div>
        <div class="row">
            <p>
            <a href="create_bestuurder.php" class="btn btn-success">Nieuwe bestuurder toevoegen aan heat</a> | <a href="overzicht_heat.php" class="btn btn-success">Overzicht Heat</a>
            </p> 

            <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Naam</th>
                <th>Run 1</th>
                <th>Run 2</th>
                <th>Run 3</th>
                <!--<th>Mobile Number</th>-->
                <th>Acties</th>
              </tr>
            </thead>
            <tbody>
              <?php
              //include 'db.php';
              $pdo = Database::connect();
              $sql = 'SELECT bestuurders.naam, heat_data.run_1, heat_data.run_2, heat_data.run_3, koppel_id
FROM heat_data
INNER JOIN heat
INNER JOIN bestuurders
ON heat_data.bestuurder_id=bestuurders.id AND heat_data.heat_id = heat.heat_id WHERE heat.heat_id = '.$id.' ORDER BY max(run_1)  DESC;';

              foreach ($pdo->query($sql) as $row) {
                echo '<tr>';
                echo '<td>'. $row['naam'] . '</td>';
                echo '<td>'. $row['run_1'] . '</td>';
                echo '<td>'. $row['run_2'] . '</td>';
                echo '<td>'. $row['run_3'] . '</td>';

                echo '<td><a class="btn" href="update_score.php?id='.$row['koppel_id'].'">bijwerken</a></td>';
                // echo '<td>'. $row['mobile'] . '</td>';
                echo '</tr>';
              }
              Database::disconnect();
              ?>
            </tbody>
            </table>
        </div>
    </div> <!-- /container -->
  </body>
</html>