<?php

$con = new mysqli("localhost", 'root', null, 'DB');
$error = false;
$msg = false;
$search = false;

$id = '';
$name = '';
$cgpa = '';

function getData()
{
    $data = [];
    $data[0] = $_POST['id'];
    $data[1] = $_POST['name'];
    $data[2] = $_POST['cgpa'];

    return $data;
}

if ($con->connect_error) {
    $error = true;
    echo "hello";
} else {

    if (isset($_POST['add'])) {
        $data = getData();
        $insert_Query = "INSERT INTO student VALUES ('$data[0]','$data[1]','$data[2]')";

        $insert_Result = mysqli_query($con, $insert_Query);

        if ($insert_Result) {
            if (mysqli_affected_rows($con) > 0) {
                $msg = 'Data Inserted!';
            } else {
                $msg = 'Data Not inserted!';
            }
        }
    }


    if (isset($_POST['delete'])) {
        $data = getData();
        $insert_Query = "DELETE FROM student WHERE id=$data[0]";

        $insert_Result = mysqli_query($con, $insert_Query);

        if ($insert_Result) {
            if (mysqli_affected_rows($con) > 0) {
                $msg = 'Data Deleted!';
            } else {
                $msg = 'Data Not Deleted!';
            }
        }
    }

    if (isset($_POST['update'])) {
        $data = getData();
        $insert_Query = "UPDATE `student` SET `name`='$data[1]',`cgpa`='$data[2]' WHERE id = $data[0]";

        $insert_Result = mysqli_query($con, $insert_Query);

        if ($insert_Result) {
            if (mysqli_affected_rows($con) > 0) {
                $msg = 'Data updated!';
            } else {
                $msg = 'Data Not updated!';
            }
        }
    }


    if (isset($_POST['search'])) {
        $data = getData();
        $query = "SELECT * FROM student WHERE student.id=$data[0]";
        $result = mysqli_query($con, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $id=$row['id'];
                $name=$row['name'];
                $cgpa=$row['cgpa'];
                $search=true;
                //echo "$id $name $cgpa<br>";
            }
        } else $msg='no data for this id!';
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Assignment</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="title">CURD Application</div>
    <form action="index.php" method="post">
        <div class="container">
            <input type="text" name="id" placeholder="ID">
            <input type="text" name="name" placeholder="Name">
            <input type="text" name="cgpa" placeholder="CGPA">
        </div>
        <div class="buttons">
            <input type="submit" name="add" value="Add" style="background-color: lightgreen;">
            <input type="submit" name="update" value="Update" style="background-color:lightblue">
            <input type="submit" name="search" value="Search By ID" style="background-color: lightsalmon;">
            <input type="submit" name="delete" value="Delete By ID" style="background-color: red;">
        </div>
    </form>
    <div class="msg" <?php if (!$search) { ?> style="display: block;" <?php } ?>><?php echo $msg; ?></div>

    <div class="show" <?php if ($search) { ?> style="display: block;" <?php } ?>>
    <h3 class="text">Search Result:</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>CGPA</th>
            </tr>
            <tr>
                <td><?php echo $id ?></td>
                <td><?php echo $name ?></td>
                <td><?php echo $cgpa ?></td>
            </tr>
        </table>
    </div>

</body>

</html>