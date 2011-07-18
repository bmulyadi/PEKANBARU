<?  
  ini_set('display_errors', 1);
    $server = '192.200.200.12:1433\MSSQLSERVER';
    //$server = '192.200.200.12:8291\MSSQLSERVER';
    $link = mssql_connect($server, 'sa', 'pde-pst-bks-08');

    if (!$link) {
    die('<br/><br/>Something went wrong while connecting to MSSQL');
    }
    else {
    $selected = mssql_select_db("jerbee", $link)
    or die("Couldn’t open database databasename");
    echo "connected to databasename<br/>";

    //$result = mssql_query(“select name from table”);

    //while($row = mssql_fetch_array($result))
    //echo $row["name"] . “<br/>”;
    }
	?>