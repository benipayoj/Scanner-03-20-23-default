<?php

include 'conn.php';
    
if (isset($_FILES["webcam"]["tmp_name"])){
    
	$sql = "SELECT * FROM attendance ORDER BY ID DESC LIMIT 1";
	$query = $conn->query($sql);
    
    if($query->num_rows > 0){
        
    $row = $query->fetch_assoc();
    $id = $row['id'];
    $faculty_id = $row['facultyID'];

    $tmpName = $_FILES ["webcam"]["tmp_name"];
    $imageName = date ("Y.m.d") . " - " . date("h.i.sa") . ' .jpeg';
    move_uploaded_file ($tmpName, 'img/' . $imageName);

    $query = "INSERT INTO  attendance_attachments(attendanceID,facultyID,attachment) VALUES ('$id','$faculty_id','$imageName')";
    // VALUES ('$date', '$imageName')
    $query = $conn->query($query);
    header("Location: index1.php");
    }


}


?>

