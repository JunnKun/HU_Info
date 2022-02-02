<?php
  require './response.php';

  if(isset($_REQUEST["submit"])){
    $consonants = array('B','C','D','F','G','H','J','K','L','M','N','P','Q','R','S','T','V','W','X','Y','Z');
    
    function ifConsonants($myChar){
      global $consonants;
      if(in_array($myChar, $consonants)){return true;}
      else{
      return false;
      }
    }

    function getConsonants($myString){
      $returnString = "";
      for($i = 0; $i < strlen($myString); $i++){
          if(ifConsonants($myString[$i])){
              $returnString = $returnString . $myString[$i];
          }
      }
      return $returnString;
    }

    function control_email_existing($email, $json_data){
      for($i = 0; $i < count($json_data); $i++){
          if($json_data[$i]['email'] == $email){
              return true;
          }
      }
      return false;
    }

    function register($url, $name, $surname, $email, $password){
      if(file_exists($url)){
        $json_data = file_get_contents($url);
        $json_data_decode = json_decode($json_data, true);
        if(!control_email_existing($email, $json_data_decode)){
          $add_data = array(
            'email'     => $email,
            'name'     => $name,
            'surname'     => $surname,
            'password'  => password_hash($password, PASSWORD_ARGON2ID)
          );
          $json_data_decode[] = $add_data;
          $json_data_encode = json_encode($json_data_decode);
          if(file_put_contents($url, $json_data_encode)){
            return true;
          }
        }else{
          echo "Utente giá registrato";
          return false;
        }
      }else{
        echo "File non esistente";
        return false;
      }
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
      if(isset($_REQUEST["submit"])){
        if($_REQUEST["submit"] == "register"){
          if(isset($_REQUEST["name"], $_REQUEST["surname"], $_REQUEST["email"], $_REQUEST["password"])){
            $name = htmlspecialchars(strtoupper($_REQUEST["name"]), ENT_QUOTES);
            $surname = htmlspecialchars(strtoupper($_REQUEST["surname"]), ENT_QUOTES);
            $email = htmlspecialchars(strtoupper($_REQUEST["email"]), ENT_QUOTES);
            $password = $_REQUEST["password"];
            // $email_domain = explode('@', $email);
            $json = json_encode(
                array(
                    'Nome' => getConsonants($name),
                    'Cognome' => getConsonants($surname),
                    // 'Domain' => getDomain($email)
                    // 'Domain' => $email_domain[1]
                    'Domain' => substr($email, strpos($email, "@")+1)
                )
            );
            register("./src/user.json", $name, $surname, $email, $password);
            var_dump(json_decode($json, true, 4));
          }
        }else{
          $test = new Response(true, "asd", 202, "json");
          echo json_encode($test);
        }
      }
    }else{
        http_response_code(200);
    }

    function getDomain($myString){
        $domain;
        for($i = 0; $i < strlen($myString); $i++){
            if($myString[$i] == '@'){
                $domain = substr($myString, $i+1);
            }
        }
        return $domain;
    }
  }else{
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
    <h1>Registrazione!</h1>

    <form action = "<?php echo $_SERVER['PHP_SELF'];?>" method = "POST">
        <input type="text" name="name" id="name" placeholder="name" required>
        <input type="text" name="surname" id="surname" placeholder="surname" required>
        <input type="text" name="email" id="email" placeholder="email" required>
        <input type="password" name="password" id="password" placeholder="password" required>
        <input type="submit" name = "submit" value="register">
    </form>

    <h1>Login!</h1>

    <form action = "<?php echo $_SERVER['PHP_SELF'];?>" method = "POST">
        <input type="text" name="email" id="email" placeholder="email" required>
        <input type="password" name="password" id="password" placeholder="password" required>
        <input type="submit" name = "submit" value="login">
    </form>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
      /*function checkEmail(form)
      {
        // validation fails if the input is blank
        if(form.email.value == "") {
          alert("Error: Input is empty!");
          form.email.focus();
          return false;
        }

        // regular expression to match only alphanumeric characters and spaces
        var re = /^[\w ]+$/;

        // validation fails if the input doesn't match our regular expression
        if(!re.test(form.email.value)) {
          alert("Error: Input contains invalid characters!");
          form.email.focus();
          return false;
        }

        // validation was successful
        return true;
      }*/
    </script>
  </body>
</html>

<?php
  
  }
?>