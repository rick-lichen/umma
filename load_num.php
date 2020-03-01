<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $success = $_POST['CollectSuccess'];
        $umbrella_num = $_POST['CurrentInput'];
        $phone_num = $_POST['UserIdentifier'];
        if (!isset($umbrella_num)){
            $phone_num = 300;
        }
        $location = $_POST['CollectName'];
        if ($success){
            $mysqli = new mysqli('localhost', 'umma', 'umma2020', 'umma');
            if ($mysqli->connect_errno) {
                printf("Connect failed: %s\n", $mysqli->connect_error);
                exit();
            }
            $exists = $mysqli->prepare("SELECT returned, id FROM umbrellas WHERE phone_num = ? && umbrella_num = ? ORDER BY time DESC LIMIT 1"); //Selects the latest use case
            if (!$exists){
                echo ($mysqli->error);
                exit();
            }
            $exists->bind_param('si',$phone_num,$umbrella_num);
            $exists->execute();
            $exists->bind_result($status, $id);
            $exists->fetch();
            $exists->close();
            if (isset($status) && $status == 0){       //If umbrella exists and isnt' returned yet
                $stmt = $mysqli->prepare("UPDATE umbrellas SET returned = true WHERE id = ?");
                $stmt->bind_param('i', $id);
                $stmt->execute();
                $stmt->close();
                $return = $mysqli->prepare("INSERT INTO returned (phone_num, umbrella_num, id, location) VALUES (?,?,?,?)");
                $return->bind_param('siis', $phone_num, $umbrella_num, $id, $location);
                $return->execute();
                $return->close();
            } else{     //If umbrella wasn't rented out yet, or if umbrella was previously returned 
                $new = $mysqli->prepare("INSERT INTO umbrellas (phone_num, umbrella_num, location) VALUES (?,?,?)");
                $new->bind_param('sis', $phone_num, $umbrella_num, $location);
                $new->execute();
                $new->close();
            }
        }
    ?>
    
