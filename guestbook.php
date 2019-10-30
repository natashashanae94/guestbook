<?php
/*Natasha Johnson
  CTP 130-840
  Lab 4*/


?>
<!DOCTYPE html>
<html>
  <head>
    <title>Guest Book</title>
  </head>
  <body>
    <?php
     $nameError = "";
     $emailError = "";
     $emailValidate = "";
      if($_SERVER['REQUEST_METHOD'] == 'POST') {
        validateForm();
      } else {
        showForm($nameError, $emailError, $emailValidate, $name, $email);
      }

      function validateForm() {
        $name = $_POST['name'];
        $email = $_POST['email'];

        if(empty($name)){
          $name = NULL;
          $nameError = "<p>* Please print your name.</p>";
        }

        if(empty($email)){
          $email = NULL;
          $emailError = "<p>* Please print your email.</p>";
        }

        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $emailValidate = "";
        } else {
          $emailValidate = ("* Not a valid email address.");
          $email = NULL;
        }

        if($name && $email) {
          writeToFile($name, $email);
        } else {
          showForm($nameError, $emailError, $emailValidate, $name, $email);
        }

      }

function showForm($nameError, $emailError, $emailValidate, $name, $email) {
print <<< FORM
  <form method="post" action="">
    <table>
      <tr>
        <th><h1>Guest Book</h1></th>
      </tr>
      <tr>
        <td><a href="#">Sort Names</a></td>
      </tr>
      <tr>
        <td><a href="#">Delete Duplicate Entries</a></td>
      </tr>
      <tr>
        <td>
          <p>Sign the Guest Book:</p>
        </td>
      </tr>
      <tr>
        <td><label for="name">Your Name: </label><input type="text" name="name" value="$name"></td>
        <td>$nameError</td>
      </tr>
      <tr>
        <td><label for="name">Your Email: </label><input type="text" name="email" value="$email"></td>
        <td>$emailError</td>
        <td>$emailValidate</td>
      </tr>
      <tr>
        <td><input type="reset" name="reset-btn" value="Clear form" onclick="this.form.reset();"> <input type="submit" name="submit" value="Sign the Guest Book"></td>
      </tr>
    </table>
  </form>
FORM;
}

function writeToFile($name, $email) {
  echo "<p>Name: $name</p>";
  echo "<p>Email: $email</p>";

  /*WRITE TO FILE*/
  $file = "guestbook.txt";
  $data = array($name, $email);
  file_put_contents($file, implode(' ', $data)."\n",FILE_APPEND | LOCK_EX);

}
?>
  </body>
</html>
