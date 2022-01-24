
<?php
$connect = mysqli_connect("localhost", "root", "mysql", "testing");
if(isset($_POST["submit"]))
{
 if($_FILES['file']['name'])
 {
  $filename = explode(".", $_FILES['file']['name']);
  if($filename[1] == 'csv')
  {
   $handle = fopen($_FILES['file']['tmp_name'], "r");
   while($data = fgetcsv($handle))
   {
    $item1 = mysqli_real_escape_string($connect, $data[0]);
                $item2 = mysqli_real_escape_string($connect, $data[1]);
                $query = "INSERT into excel(excel_name, excel_email) values('$item1','$item2')";
                mysqli_query($connect, $query);
   }
   fclose($handle);
   echo "<script>alert('Import done');</script>";
  }
 }
}
?>
<!DOCTYPE html>
<html>
 <head>
  <title>Webslesson Tutorial</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
 </head>
 <body>
  <h3 align="center">How to Import Data from CSV File to Mysql using PHP</h3><br />
  <form method="post" enctype="multipart/form-data">
   <div align="center">
    <label>Select CSV File:</label>
    <input type="file" name="file" />
    <br />
    <input type="submit" name="submit" value="Import" class="btn btn-info" />
   </div>
  </form>
 </body>
</html>



$errors = [];
$connect = new mysqli("localhost","root","mysql","temelmetehan_cinar");
if ($connect->connect_error)
{
  die("Connection failed: " . $connect->connect_error);
}
else
{
    echo '<br>connect success !!</br>';
}


if(!file_exists($filename) || !is_readable($filename))
{
  return FALSE;
}

$handle = fopen($books_fn, "r");
while($data = fgetcsv($handle))
  {
  $item1 = mysqli_real_escape_string($connect, $data[0]);
  $item2 = mysqli_real_escape_string($connect, $data[1]);
  $query = "INSERT into BOOKs(book_id,book_name) values('$item1','$item2')";
  mysqli_query($connect, $query);
}
fclose($handle);
echo "<script>alert('Import done');</script>";
