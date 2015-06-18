<?php
    require 'db.php';
 
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( null==$id ) {
        header("Location: index.php");
    }
     print_r($_POST);
    if ( !empty($_POST)) {
        // keep track validation errors
        $nameError = null;
        $emailError = null;
        $mobileError = null;
         
        // keep track post values
        $run_1 = $_POST['run_1'];
        $run_2 = $_POST['run_2'];
        $run_3 = $_POST['run_3'];
         
        // validate input
        //$valid = true;
        
         
        // update data
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE heat_data set run_1 = ?, run_2 = ?, run_3 =? WHERE koppel_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($run_1,$run_2,$run_3,$id));
        Database::disconnect();
        //echo $run_1;
        header("Location: overzicht_heat.php"); // TODO: terug linken naar precieze overzicht
    
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT heat_data.run_1, heat_data.run_2, heat_data.run_3, bestuurders.naam, heat.heat_naam FROM heat_data 
        INNER JOIN heat
        INNER JOIN bestuurders
        ON heat_data.bestuurder_id=bestuurders.id AND heat_data.heat_id = heat.heat_id
        where koppel_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $run_1 = $data['run_1'];
        $run_2 = $data['run_2'];
        $run_3 = $data['run_3'];
        $heat_naam = $data['heat_naam'];
        $naam = $data['naam'];
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
                      <h3>Update score van: <?=$heat_naam?><br/>Van bestuurder:<?=$naam?></h3>
                    </div>
             
                    <form class="form-horizontal" action="update_score.php?id=<?php echo $id?>" method="post">
                      <div class="control-group">
                        <label class="control-label">Run 1</label>
                        <div class="controls">
                            <input name="run_1" type="text"  placeholder="" value="<?=$run_1?>">
                        </div>
                      </div>
                      <div class="control-group">
                        <label class="control-label">Run 2</label>
                        <div class="controls">
                            <input name="run_2" type="text"  placeholder="" value="<?=$run_2?>">
                        </div>
                      </div>
                      <div class="control-group">
                        <label class="control-label">Run 3</label>
                        <div class="controls">
                            <input name="run_3" type="text"  placeholder="" value="<?=$run_3?>">
                        </div>
                      </div>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Update</button>
                          <a class="btn" href="index.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>