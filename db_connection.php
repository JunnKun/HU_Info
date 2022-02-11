<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db_name = "game_db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $db_name);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    echo "Connected successfully";

/*$sql = "INSERT INTO utenti (username, password) VALUES ('fausto', '321');";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }*/

  $sql = "SELECT * FROM game;";

/*if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }*/

  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      echo "id: " . $row["id"]. " - Name: " . $row["game_name"]. "<br>";
    }
  } else {
    echo "0 results";
  }
  $conn->close();
?>