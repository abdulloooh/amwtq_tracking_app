<?php
session_start();
function kill($data)
{
    die(var_dump($data));
}

function validateName($name)
{
    if (empty($name)) {
        return "Name empty";
    }
    if (!preg_match("/^[+0-9]*$/", $name)) {
        return "Invalid number provided";
    }
    if (strlen($name) > 50) {
        return "Normal name shouldn't be greater than 50 characters";
    } else {
        return $name;
    }

}

$url = "data.json";
$data = file_get_contents($url);
$data = json_decode($data, true);
// kill($data);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['register']) && $_POST['register'] == "register") {
        $name = $_POST['name'];

        if ($name !== validateName($name)) {
            $validate = validateName($name);
        }

        $check = "";
        if (empty($validate)) {
            if ($data[$name]) {
                $_SESSION['check'] = "Already registered";
            }
        } else {
            $_SESSION['check'] = $validate;
        }

        if (!isset($_SESSION['check'])) {
            $data[$name]["juz"] = [];
            $data[$name]["challenge"] = [];
            $data = json_encode($data);
            file_put_contents("data.json", $data);
            $_SESSION['check'] = "Registered";
        }
    } else if (isset($_POST['record']) && $_POST['record'] == "record") {
        // kill($_POST);
        $name = $_POST['name'];
        $juzyu = $_POST['juz'];
        $ch = $_POST['challenge'];
        if (!$data[$name]) {
            $_SESSION['check'] = "User does not exist, please register to cont.";
        } else {

            //deal with Juz
            $juzyu = explode(",", $juzyu);

            $juzyuProcessing = [];

            foreach ($juzyu as $j) {
                if ($j === "" || $j === " " || strlen(trim($j)) > 2) {} else {array_push($juzyuProcessing, trim($j));}
            }
            $juzyu = $juzyuProcessing;

            $data[$name]["juz"] = array_unique(array_merge($data[$name]["juz"], $juzyu));
            $juzDuplicate = $data[$name]["juz"];
            sort($juzDuplicate);
            $data[$name]["juz"] = $juzDuplicate;

            //deal with challenge
            $ch = explode(",", $ch);

            $chProcessing = [];

            foreach ($ch as $c) {
                if ($c === "" || $c === " " || strlen(trim($c)) > 2) {} else {array_push($chProcessing, trim($c));}
            }
            $ch = $chProcessing;

            $data[$name]["challenge"] = array_unique(array_merge($data[$name]["challenge"], $ch));
            $chDuplicate = $data[$name]["challenge"];
            sort($chDuplicate);
            $data[$name]["challenge"] = $chDuplicate;

            $data = json_encode($data);
            file_put_contents("data.json", $data);
            $_SESSION['check'] = "Recorded, Baarakallahu fiik";

        }
    }

}
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
  <header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
      <a class="navbar-brand" href="#" style="cursor: default;">AMWTQ Record Sheet</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
        aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="#" onclick="registeR(event);">Register
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" onclick="recorD(event);">Record</a>
          </li>

        </ul>
      </div>
    </nav>
  </header>

  <main role=" main" class="flex-shrink-0">
    <div class="container"> <br> <br>
      <h4 class="mt-5">AMWTQ recording sheet</h4> <br>
      <section class="lead">

        <div id="register" style="display: none;">
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
              <label for="name">Whatsapp Number</label>
              <input type="number" class="form-control" id="name" name="name"
                placeholder="eg 2348012345678 or 08012345678" required />
              <small id="emailHelp" class="form-text text-muted">Note: whatever format used for registration
                will only
                be recognized for your accoutn henceforth</small>
            </div>

            <button type="submit" name="register" value="register" class="btn btn-secondary">Submit</button>

          </form>
        </div>

        <div id="record"><small>Kindly register first <a style="color:grey" href="#" onclick="registeR(event);">here</a>
            if you
            have
            not</small> <br>

          <br> <br>
          <?php
if (isset($_SESSION['check'])) {
    echo "<div class='alert alert-dark alert-dismissible fade show' role='alert'>
    <em><small>{$_SESSION['check']}</small></em>
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>&times;</span>
    </button>
  </div>";
}
unset($_SESSION['check']);
?>
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
              <label for="name">Whatsapp Number</label>
              <input type="tel" class="form-control" id="name" name="name" required />
              <small id="emailHelp" class="form-text text-muted">format as used durring registration</small>

            </div>
            <div class="form-group">
              <label for="juz">Juz completed</label>
              <input type="text" class="form-control" id="juz" name="juz" placeholder="e.g. 5 or 3,4,5" />
              <small id="emailHelp" class="form-text text-muted">Enter Juz number completed eg 3 and If more
                than one,
                seperate with comma eg 2,3,4</small>
            </div>

            <div class="form-group">
              <label for="challenge">Challenge day completed</label>
              <input type="text" class="form-control" id="challenge" name="challenge"
                placeholder="e.g. 5 for day 5 or 2 for day 2" />
              <small id="emailHelp" class="form-text text-muted">Enter challenge number completed eg 3 and If more
                than one,
                seperate with comma eg 2,3,4</small>
            </div>

            <button type="submit" name="record" value="record" class="btn btn-secondary">Submit</button>


          </form>
        </div>

        <div id="report" style="display: none;">

          <?php foreach ($data as $key => $values): ?>
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
  <!-- <div class="footer" style="margin-top:20px">
    <span class="text-muted my-5 py-5 ">Built with &#9829; by <a style="color:grey;"
        href="https://github.com/abdulloooh/amwtq_tracking_app" target="_blank"
        rel="noopener noreferrer">Abdullah</a></span>
  </div> -->
  <!-- <footer class="footer">
    <div class="container">
      <span class="text-muted my-5 py-5 ">Built with &#9829; by <a style="color:grey;"
          href="https://github.com/abdulloooh/amwtq_tracking_app" target="_blank"
          rel="noopener noreferrer">Abdullah</a></span>
    </div>
  </footer> -->
  <script src=" script.js">
  </script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>