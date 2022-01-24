<!DOCTYPE html>
<html lang="tr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>348-Database Management Term Project</title>
  </head>
  <body>
    <?php


      $db_name = "temelmetehan_cinar";
      $connect = new mysqli("localhost","root","mysql");



      if ($connect->connect_error)
      {
        die("Connection failed: " . $connect->connect_error);
      }
      $sql = "CREATE DATABASE IF NOT EXISTS $db_name";
      if ($connect->query($sql) === TRUE)
      {
        echo "Database created successfully\n<br><br>";
      }
      else
      {
        echo "Error creating database: " . $connect->error ."<br>";
      }


      mysqli_select_db($connect, $db_name);
      $errors = [];
      if ($connect->connect_error)
      {
        die("Connection failed: " . $connect->connect_error);
      }

      $sql1 = "CREATE TABLE DISTRICTs
      (
          district_id INT(6) NOT NULL AUTO_INCREMENT,
          district_name VARCHAR(30) NOT NULL,
          PRIMARY KEY (district_id)
      )";

      $sql2 = "CREATE TABLE CITYs
      (
          city_id INT(6) NOT NULL AUTO_INCREMENT,
          city_name VARCHAR(30) NOT NULL,
          district_id INT(6) NOT NULL,
          PRIMARY KEY(city_id),
          FOREIGN KEY (district_id) references DISTRICTs(district_id)
      )";

      $sql3 = "CREATE TABLE BRANCHes
      (
          branch_id INT(10) NOT NULL AUTO_INCREMENT,
          city_id INT(10) NOT NULL,
          branch_name VARCHAR(30) NOT NULL,
          book_amount INT(10) NOT NULL,
          PRIMARY KEY (branch_id),
          FOREIGN KEY (city_id) references CITYs(city_id)
      )";


      $sql4 = "CREATE TABLE BOOKs
      (
          book_id INT(6) NOT NULL AUTO_INCREMENT,
          book_name VARCHAR(120) NOT NULL,
          PRIMARY KEY (book_id)

      )";

      $sql5 = "CREATE TABLE SALESMANs
      (
          salesman_id INT(6) NOT NULL AUTO_INCREMENT,
          salesman_name VARCHAR(100) NOT NULL,
          salesman_surname VARCHAR(100) NOT NULL,
          branch_id INT(6) NOT NULL,
          PRIMARY KEY (salesman_id),
          FOREIGN KEY (branch_id) references BRANCHes(branch_id)

      )";


      $sql6 = "CREATE TABLE CUSTOMERs
      (
          customer_id INT(6) NOT NULL AUTO_INCREMENT,
          customer_name VARCHAR(30) NOT NULL,
          customer_surname VARCHAR(30) NOT NULL,
          salesman_id INT(6) NOT NULL ,
          PRIMARY KEY (customer_id),
          FOREIGN KEY (salesman_id) references SALESMANs(salesman_id)
      )";





      $sql7 = "CREATE TABLE SALEs
      (
          sale_id INT(6) NOT NULL AUTO_INCREMENT,
          salesman_id INT(6) NOT NULL,
          customer_id INT(6) NOT NULL,
          book_id INT(6) NOT NULL,
          PRIMARY KEY (sale_id),
          FOREIGN KEY(salesman_id) references SALESMANs(salesman_id),
        	FOREIGN KEY(customer_id) references CUSTOMERs(customer_id),
        	FOREIGN KEY(book_id) references BOOKs(book_id)
      )";

      $tables = [$sql1, $sql2,$sql3,$sql4,$sql5,$sql6,$sql7];


      foreach($tables as $k => $sql)
      {
        $query = @$connect->query($sql);
        if(!$query)
           $errors[] = "Table $k : Creation failed ($connect->error) <br>";
        else
           $errors[] = "Table $k : Creation done<br>";
      }
      foreach($errors as $msg)
      {
         echo "$msg <br>";
      }

      $handle = NULL;

      // DISTRICT CSV ----------------------------------------------------------

      $filename = "csvs/district.csv";

      if(!file_exists($filename) || !is_readable($filename))
        return FALSE;


      if (($handle = fopen($filename, 'r')) !== FALSE)
      {
        $row = fgetcsv($handle);
        while (($row = fgetcsv($handle, 1000, ',')) !== FALSE)
        {
            $sql_query = "INSERT INTO DISTRICTs(district_name) VALUES('$row[1]')";
            mysqli_query($connect, $sql_query);
        }


        echo 'Filled "DISTRICT" table.<br>';
      }
      fclose($handle);
      $handle = NULL;

      // DISTRICT CSV ----------------------------------------------------------

      // BOOKS CSV -------------------------------------------------------------
      $filename = "csvs/books.csv";

      if(!file_exists($filename) || !is_readable($filename))
        return FALSE;


      if (($handle = fopen($filename, 'r')) !== FALSE)
      {
        $row = fgetcsv($handle);
        while (($row = fgetcsv($handle, 1000, ',')) !== FALSE)
        {
            $sql_query = "INSERT INTO BOOKs(book_name) VALUES('$row[1]')";
            mysqli_query($connect, $sql_query);
        }
        echo 'Filled "BOOKS" table.<br>';


      }
      fclose($handle);
      $handle = NULL;

      // BOOKS CSV -------------------------------------------------------------

      // CITY CSV ----------------------------------------------------------

      $filename = "csvs/city.csv";

      if(!file_exists($filename) || !is_readable($filename))
        return FALSE;


      if (($handle = fopen($filename, 'r')) !== FALSE)
      {
        $row = fgetcsv($handle);
        while (($row = fgetcsv($handle, 1000, ',')) !== FALSE)
        {
            $sql_query = "INSERT INTO CITYs(city_name,district_id) VALUES('$row[1]','$row[2]')";
            mysqli_query($connect, $sql_query);
        }


        echo 'Filled "CITYs" table.<br>';
      }
      fclose($handle);
      $handle = NULL;

      // CITY CSV --------------------------------------------------------------

      // BRANCHES CSV ----------------------------------------------------------



      $filename = "csvs/branches.csv";

      if(!file_exists($filename) || !is_readable($filename))
        return FALSE;


      if (($handle = fopen($filename, 'r')) !== FALSE)
      {
        $row = fgetcsv($handle);
        while (($row = fgetcsv($handle, 1000, ',')) !== FALSE)
        {
            $sql_query = "INSERT INTO BRANCHes(city_id,branch_name,book_amount) VALUES('$row[1]','$row[2]','$row[3]')";
            mysqli_query($connect, $sql_query);
        }


        echo 'Filled "BRANCHES" table.<br>';
      }
      fclose($handle);
      $handle = NULL;

      // BRANCHES CSV ----------------------------------------------------------

      // SALESMAN CSV ----------------------------------------------------------
      $filename = "csvs/salesmans.csv";

      if(!file_exists($filename) || !is_readable($filename))
        return FALSE;


      if (($handle = fopen($filename, 'r')) !== FALSE)
      {
        $row = fgetcsv($handle);
        while (($row = fgetcsv($handle, 1000, ',')) !== FALSE)
        {
            $sql_query = "INSERT INTO SALESMANs(salesman_name,salesman_surname,branch_id) VALUES('$row[1]','$row[2]','$row[3]')";
            mysqli_query($connect, $sql_query);
        }
        echo 'Filled "SALESMAN" table.<br>';
      }


      fclose($handle);
      $handle = NULL;

      // SALESMAN CSV ----------------------------------------------------------



      // CUSTOMER CSV ----------------------------------------------------------


      $filename = "csvs/customer.csv";

      if(!file_exists($filename) || !is_readable($filename))
        return FALSE;


      if (($handle = fopen($filename, 'r')) !== FALSE)
      {
        $row = fgetcsv($handle);
        while (($row = fgetcsv($handle, 1000, ',')) !== FALSE)
        {
            $sql_query = "INSERT INTO CUSTOMERs(customer_name,customer_surname,salesman_id) VALUES('$row[1]','$row[2]','$row[3]')";
            mysqli_query($connect, $sql_query);
        }




        echo 'Filled "CUSTOMER" table.<br>';
      }

      fclose($handle);
      $handle = NULL;

      // CUSTOMER CSV ----------------------------------------------------------


      // SALES CSV ----------------------------------------------------------

      $filename = "csvs/sales.csv";

      if(!file_exists($filename) || !is_readable($filename))
        return FALSE;


      if (($handle = fopen($filename, 'r')) !== FALSE)
      {
        $row = fgetcsv($handle);
        while (($row = fgetcsv($handle, 1000, ',')) !== FALSE)
        {
            $sql_query = "INSERT INTO SALEs(salesman_id,customer_id,book_id) VALUES('$row[1]','$row[2]','$row[3]')";
            mysqli_query($connect, $sql_query);
        }


        echo 'Filled "SALES" table.<br>';
      }
      fclose($handle);

      // SALES CSV ----------------------------------------------------------


      $connect->close();




     ?>






  </body>
</html>
