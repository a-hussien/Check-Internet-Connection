

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no">
    <title>Test Internet Speed</title>
    <style media="screen">
      .mobilesOnly {
        visibility:hidden;
      }
    </style>
  </head>
  <body>
    <div class="well" >
        <?php
    

        include_once 'NetTest.php';

            $netTest = new NetTest();
            $netTest->setSensitivity(isset($_GET['sensitivity']) ? $_GET['sensitivity'] : 50);
            echo "Connection Status : " . $netTest->getSpeedName();
        ?>
    </div>
    <div class="test">
    <a class="mobilesOnly" href="tel:00201221462385">Call +20-122-146-23-85</a>
    </div>
  </body>
</html>
