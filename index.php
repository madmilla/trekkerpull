<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link   href="css/bootstrap.min.css" rel="stylesheet">
  <script src="js/bootstrap.min.js"></script>
</head>

  <body>
  <div class="container">
    <div class="row">
      <h3>Overzicht bestuurders</h3>
    </div>
    <div class="row">
      <p>
        <a href="create_bestuurder.php" class="btn btn-success">Nieuwe bestuurder toevoegen</a> | <a href="overzicht_heat.php" class="btn btn-success">Overzicht Heat</a>
      </p> 

      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>Startnummer</th>
            <th>Naam bestuurder</th>
            <!--<th>Mobile Number</th>-->
            <th>Acties</th>
          </tr>
        </thead>
        <tbody>
          <?php
          include 'db.php';
          $pdo = Database::connect();
          $sql = 'SELECT * FROM bestuurders ORDER BY id DESC';
          foreach ($pdo->query($sql) as $row) {
            echo '<tr>';
            echo '<td>'. $row['startnummer'] . '</td>';
            echo '<td>'. $row['naam'] . '</td>';
            echo '<td><a class="btn" href="read_bestuurder.php?id='.$row['id'].'">Afstanden</a></td>';
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