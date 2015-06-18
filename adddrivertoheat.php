<?php
    require 'db.php';
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( null==$id ) {

        header("Location: index.php");

    }
    if ( !empty($_POST)) {
        // keep track validation errors
        $nameError = null;
        
        printf($_POST['bestuurder']);
        // keep track post values

         
        // validate input
        //$valid = true;
        
         
        // update data
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if(empty($_POST['bestuurder'])){
            header("Location: read_heat.php?id=".$id);
        }
        $sql = "INSERT INTO heat_data (heat_id,bestuurder_id) values(?,(SELECT id FROM bestuurders WHERE naam = ?))";
       //$sql = " heat (heat_naam) values(?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($id,$_POST['bestuurder']));
        Database::disconnect();
        //echo $run_1;
        header("Location: read_heat.php?id=".$id); // TODO: terug linken naar precieze overzicht
    
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
                <h3>Voeg bestuurder toe aan heat</h3>
            </div>
        </div>

        <div class="form-horizontal" >
            <div class="control-group"></div> <!-- TODO: kijken waarom dit verkeerd inspringt. -->
            <form class="form-horizontal" action="adddrivertoheat.php?id=<?php echo $id?>" method="post">
            <div class="control-group">
                <label class="control-label">bestuurder</label>
                <div class="controls">
                    <label class="checkbox">
                    <?php
                        $pdo = Database::connect();
                        $sql = 'SELECT naam FROM bestuurders WHERE id NOT IN (SELECT bestuurder_id FROM heat_data where heat_id = '.$id.') ORDER BY naam DESC';
                        if ($pdo->query($sql)->rowCount() == 0) {
                            echo "Er zijn geen bestuurders resterend";
                        }else{
                        ?>
                    <select name="bestuurder">
                        
                        foreach ($pdo->query($sql) as $row) {
                            echo '<option value="'.$row['naam'].'">'.$row['naam'].'</option>';
                        }
                        ?>
                    </select>
                        <?php } ?>
                    </label>
                </div>
            </div>

            <div class="form-actions">
            <?php if ($pdo->query($sql)->rowCount() != 0) { ?>
            <button type="submit" class="btn btn-success">Voeg toe</button>
            <?php } ?>
            <a class="btn" href="index.php">terug</a>
            </div>
            </form>
        </div>
        
    </div> <!-- /container -->
  </body>
</html>