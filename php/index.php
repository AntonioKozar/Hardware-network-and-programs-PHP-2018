<?php
include('model.php');
include('controler.php');
$HTMLHeaderInformation = new HTMLHeaderInformation;
$HTMLBodyInformation = new HTMLBodyInformation;
if(isset($_POST['Location'])){$HTMLBodyInformation->location = $_POST['Location'];}else{$HTMLBodyInformation->location = 1;}
if(isset($_POST['Details'])){$HTMLBodyInformation->details = $_POST['Details'];}else{$HTMLBodyInformation->details = 1;}
$HTMLBodyInformation = ConstructorHome($HTMLBodyInformation->location, $HTMLBodyInformation->details);

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?php print($HTMLHeaderInformation->description);?>">
    <meta name="author" content="<?php print($HTMLHeaderInformation->author);?>">
    <link rel="icon" href="<?php print($HTMLHeaderInformation->favicon);?>">

    <title><?php print($HTMLHeaderInformation->title);?></title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">


    <!-- Custom styles for this template -->
    <link href="../res/sticky-footer-navbar.css" rel="stylesheet">
  </head>

  <body>

    <header>
      <!-- Fixed navbar -->
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="index.php"><?php print($HTMLHeaderInformation->title);?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <?php print($HTMLBodyInformation->headernav);?>
      </nav>
    </header>

    <!-- Begin page content -->
    <main role="main" class="container">
      <h1 class="mt-5"><?php print($HTMLBodyInformation->location);?></h1>
      <table class="table table-hover">
        <thead>
          <?php print($HTMLBodyInformation->tableheader);?>
        </thead>
        <tbody>
        <?php print_r($HTMLBodyInformation->tablebody);?>
        </tbody>
      </table>  
    </main>

    <!-- Begin footer content -->
    <footer class="footer">
      <div class="container">
      <?php print($HTMLBodyInformation->footernav);?>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../assets/js/vendor/popper.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
  </body>
</html>
