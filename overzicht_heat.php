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
      <h3>Overzicht heats</h3>
    </div>
    <div class="row">
      <p>
        <a href="create_heat.php" class="btn btn-success">Nieuwe heat toevoegen</a> | <a href="index.php" class="btn btn-success">Overzicht bestuurders</a>
      </p>
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>Klasse naam</th>
            <th>Acties</th>
          </tr>
        </thead>
        <tbody>
          <?php
          include 'db.php';
          $pdo = Database::connect();
          $sql = 'SELECT * FROM heat ORDER BY heat_id DESC';
          foreach ($pdo->query($sql) as $row) {
            echo '<tr>';
            echo '<td>'. $row['heat_naam'] . '</td>';
            echo '<td><a class="btn" href="read_heat.php?id='.$row['heat_id'].'">standen</a></td>';
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