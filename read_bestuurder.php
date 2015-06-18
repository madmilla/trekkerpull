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
        $sql = "SELECT * FROM bestuurders where id = ?";
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
                <h3>Toon bestuurder data</h3>
            </div>
        </div>

        <div class="form-horizontal" >
            <div class="control-group"></div> <!-- TODO: kijken waarom dit verkeerd inspringt. -->
         	<div class="control-group">
                <label class="control-label">Naam</label>
                <div class="controls">
                    <label class="checkbox">
                        <?php echo $data['naam'];?>
                    </label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Startnummer</label>
                <div class="controls">
                    <label class="checkbox">
                    	<?php echo $data['startnummer'];?>
                    </label>
                </div>
            </div>
            <div class="form-actions">
            <a class="btn" href="index.php">terug</a>
            </div>
        </div>
        
    </div> <!-- /container -->
  </body>
</html>