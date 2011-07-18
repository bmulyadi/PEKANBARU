<?php
  // $db = new COM("ADODB.Connection");
 //  $dsn = "Provider=SQLOLEDB.1;Data Source=10.10.108.4;Initial catalog=latihan;User ID=sa;Password=puskomupi;Persist Security Info = True";
 // $dsn = "Driver={SQL Server};Server=localhost;Database=UPIDATA;Trusted_Connection=Yes";
 // $dsn = "Driver={SQL Server};Server=192.200.200.12;Database=siak;Trusted_Connection=Yes";
 // $db->Open($dsn);
  $tabulardata_color0 = "#8e8e8e";
  $tabulardata_color1 = "#EFCEB0";
  $tabulardata_color2 = "#FFF3E9";
?> 

<? //deklarasi variabel server, username dan password 
//$link = mssql_connect("192.200.200.12,8291", "sa", "pde-pst-bks-08") or die("unable to connect to msql server: " . mssql_error());
//mssql_select_db("jerbee", $link) or die("unable to select database 'db': " . msql_error());
//$result = mssql_query(our "query", $link);
//$result = mssql_query("query", $link);
?> 

<?php
$myServer = "192.200.200.12";
$myUser = "sa";
$myPass = "pde-pst-bks-08";
$myDB = "jerbee";

//create an instance of the  ADO connection object
$conn = new COM ("ADODB.Connection")
  or die("Cannot start ADO");

//define connection string, specify database driver
$connStr = "PROVIDER=SQLOLEDB;SERVER=".$myServer.";UID=".$myUser.";PWD=".$myPass.";DATABASE=".$myDB;
  $conn->open($connStr); //Open the connection to the database


/*connection to the database
$dbhandle = mssql_connect($myServer, $myUser, $myPass)
  or die("Couldn't connect to SQL Server on $myServer");

select a database to work with
$selected = mssql_select_db($myDB, $dbhandle)
  or die("Couldn't open database $myDB"); 
  */
$query = "SELECT * FROM Gol_Tarif";

//execute the SQL statement and return records
$rs = $conn->execute($query);

$num_columns = $rs->Fields->Count();
echo $num_columns . "<br>"; 

for ($i=0; $i < $num_columns; $i++) {
    $fld[$i] = $rs->Fields($i);
}

echo "<table>";

while (!$rs->EOF)  //carry on looping through while there are records
{
    echo "<tr>";
    for ($i=0; $i < $num_columns; $i++) {
        echo "<td>" . $fld[$i]->value . "</td>";
    }
    echo "</tr>";
    $rs->MoveNext(); //move on to the next record
}


echo "</table>";

//close the connection and recordset objects freeing up resources 
$rs->Close();
$conn->Close();

$rs = null;
$conn = null;
 ?>