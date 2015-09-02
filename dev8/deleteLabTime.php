<?php
session_start();

if(isset($_POST['id']))
{

$var_value = htmlspecialchars($_POST["id"]);
//$_SESSION['varname2'] = $var_value;
include('ConnectToDb.php');
//delete answers first, next the questions, then finally the survey. Bottom on up deletion method.
$qid= -1;


$timeDEL = "DELETE FROM LabTime where idLabTime = $var_value";
//get question id's so I can delete answers associated with survey

    //delete questions          
     $conn->query($timeDEL);
     //delete survey
     //$conn->query($surveyDEL);

     
}
echo"<script>window.location.href = \"labstudycreation.php\";</script>";
?>