<?php
     
  require 'db.php';

  if ( !empty($_POST)) {
    // keep track validation errors
    $naamError = null;

    // keep track post values
    $naam = $_POST['naam'];

    // validate input
    $valid = true;
    if (empty($naam)) {
      $naamError = 'Geef aub een naam op.';
      $valid = false;
    }

    // insert data
    if ($valid) {
      $pdo = Database::connect();
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "INSERT INTO heat (heat_naam) values(?)";
      $q = $pdo->prepare($sql);
      $q->execute(array($naam));
      Database::disconnect();
      header("Location: index.php");
    }
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
        <h3>Voeg heat toe</h3>
      </div>

      <form class="form-horizontal" action="create_heat.php" method="post">
        <div class="control-group <?php echo !empty($naamError)?'error':'';?>">
          <label class="control-label">naam</label>
          <div class="controls">
            <input name="naam" type="text"  placeholder="Naam bestuurder" value="<?php echo !empty($naam)?$naam:'';?>">
            <?php if (!empty($naamError)): ?>
              <span class="help-inline"><?php echo $naamError;?></span>
            <?php endif; ?>
          </div>
        </div>
        <div class="form-actions">
          <button type="submit" class="btn btn-success">Voeg toe</button>
          <a class="btn" href="overzicht_heat.php">Back</a>
        </div>
      </form>
    </div>
           
    </div> <!-- /container -->
  </body>
</html>