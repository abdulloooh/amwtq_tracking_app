<?php
session_start();
$url = "data.json";
$data = file_get_contents($url);
$_SESSION['data'] = json_decode($data, true);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AMWTQ</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
  <link rel="stylesheet" href="style.css" />
</head>

<body class="d-flex flex-column h-100">


  <main role="main" class="flex-shrink-0">
    <div class="container">
      <h4 class="mt-5">AMWTQ record sheet</h4> <br>
      <section class="lead">


        <div id="report">

          <?php foreach ($_SESSION['data'] as $key => $values): ?>
          <table class="table table-sm ">
            <small><strong><?=$key;?></strong></small>
            <tr>
              <td><small>Jizyus</small></td>
              <?php foreach ($values["juz"] as $value): ?>
              <td><?=$value;?></td>
              <?php endforeach;?>
            </tr>

            <tr>
              <td><small>Challenges</small></td>
              <?php foreach ($values["challenge"] as $value): ?>
              <td><?=$value;?></td>
              <?php endforeach;?>
            </tr>
          </table>
          <?php endforeach;?>

        </div>

      </section>
    </div>
  </main>
  <div class="footer">
    <span class="text-muted my-5 py-5 ">Built with &#9829; by <a style="color:grey;"
        href="https://github.com/abdulloooh/amwtq_tracking_app" target="_blank"
        rel="noopener noreferrer">Abdullah</a></span>
  </div>
  <script src=" script.js">
  </script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>