<html lang="en" style="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>database</title>
    <link rel="stylesheet" type="text/css" href="results_style.css"/>
</head>
<body>
<h2>Umbrellas Available:</h2>
    <?php 
    $mysqli = new mysqli('localhost', 'umma', 'umma2020', 'umma');
    if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }
    $sql3 = $mysqli->prepare("SELECT count(*) FROM umbrellas where returned = false && umbrella_num <= 16 && umbrella_num>0"); //Counts number of umbrellas rented out
    $sql3->execute();
    $sql3->bind_result($umbrellas_rented);
    while ($sql3->fetch()){
        echo ("<h2>".(16-$umbrellas_rented)."</h2>");
    }
    $sql3->close();
    ?>
    <h1> Umma Log</h1>
    <?php
        
        $sql = "SELECT `id`,`time`,`umbrella_num`,`phone_num`, `location`, `returned` FROM `umbrellas` WHERE umbrella_num <= 16 && umbrella_num > 0 ORDER BY `time`";
        $results = mysqli_query($mysqli,$sql);
        echo "<table>"; //begin table tag...
        //you can add thead tag here if you want your table to have column headers
            ?> 
            <thead>
                <tr>
                <th>ID</th>
                <th>Time</th>
                <th>Umbrella Number</th>
                <th>Phone Number</th>
                <th>Location Taken</th>
                <th>Returned</th>
                </tr>
            </thead>
            <?php
        while($rowitem = mysqli_fetch_array($results)) {
            echo "<tr>";
            echo "<td>" . $rowitem['id'] . "</td>";
            echo "<td>" . $rowitem['time'] . "</td>";
            echo "<td>" . $rowitem['umbrella_num'] . "</td>";
            echo "<td>" . $rowitem['phone_num'] . "</td>";
            echo "<td>" . $rowitem['location'] . "</td>";
            if ($rowitem['returned'] == 0){
                echo "<td> False </td>";
            } else{
                echo "<td> True </td>";
            }
            echo "</tr>";
        }
        echo "</table>";
        ?>
        <br> <br> <h1> Returned Entries</h1>
    <?php
        $sql2 = "SELECT `id`,`time`,`umbrella_num`,`phone_num`, `location` FROM `returned` WHERE umbrella_num <= 16 && umbrella_num > 0 ORDER BY `time`";
        $results2 = mysqli_query($mysqli,$sql2);
        echo "<table>"; //begin table tag...
        //you can add thead tag here if you want your table to have column headers
            ?> 
            <thead>
                <tr>
                <th>ID</th>
                <th>Time</th>
                <th>Umbrella Number</th>
                <th>Phone Number</th>
                <th>Location Returned</th>
                </tr>
            </thead>
            <?php
        while($rowitem2 = mysqli_fetch_array($results2)) {
            echo "<tr>";
            echo "<td>" . $rowitem2['id'] . "</td>";
            echo "<td>" . $rowitem2['time'] . "</td>";
            echo "<td>" . $rowitem2['umbrella_num'] . "</td>";
            echo "<td>" . $rowitem2['phone_num'] . "</td>";
            echo "<td>" . $rowitem2['location'] . "</td>";
            echo "</tr>";
        }
    ?>
    </body>
</html>    
