<?php
session_start();

if(isset($_POST['id']))
{

$var_value = htmlspecialchars($_POST["id"]);
//$_SESSION['varname2'] = $var_value;
include('ConnectToDb.php');
//delete answers first, next the questions, then finally the survey. Bottom on up deletion method.
$qid= -1;

$dateDEL = "DELETE FROM LabDate where idLabDate = $var_value";
$timeDEL = "DELETE FROM LabTime where idLabDate = $var_value";
//get question id's so I can delete answers associated with survey
$dateID = "SELECT * from LabDate where idLabDate = $var_value";
//delete question answers
$result = $conn->query($dateID);
   
    if ($result->num_rows > 0){
        // output data of each row
        while($row = $result->fetch_assoc())
         {
         	$qid = $row['idLabDate'];
         	$ansDEL = "DELETE FROM LabTime where idLabDate = $qid";
            $conn->query($ansDEL);
         }
    } 
    //delete questions          
     $conn->query($dateDEL);
     //delete survey
     //$conn->query($surveyDEL);

     
}
echo"<script>window.location.href = \"labstudycreation.php\";</script>";
?>