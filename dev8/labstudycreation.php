<?php
session_start();
include('header.php');
?>

<?php
//check user is allowed
include('ConnectToDb.php');
$sql = "SELECT UserType from User where uvuID = $uvid";
$result = $conn->query($sql);
$conn->close();
if ($result->num_rows > 0)
{
    // output data of each row
    while($row = $result->fetch_assoc())
     {
        $userLevel = $row["UserType"];

    }
} else {
    echo "0 results found.<br>";
    //add user to database with participant clearance

}
if($userLevel != 'Admin')
{
	if($userLevel != 'Researcher' && $userLevel != 'Teacher')
	{
		echo"<script>window.location.href = \"index.php\";</script>";
		exit();
	}
	
}
?>

<input type="button" class = "cBtn fRight" value="Home" onclick="location='index.php'" />

<?php
//get survey type information from the stored session
include('ConnectToDb.php');
$surveyType = $_SESSION['sType'];
$sid = $_SESSION['idSurvey'];
$sName = $_SESSION['sName'];
echo "<h2>Lab Study: $sName</h2><hr/>";

//add time slot
if (isset($_POST['DateSlot'])) {
echo "Select Month:<br/>";
//month
echo "<form id=\"Addbtn\" class=\"\" action=\"labstudycreation.php\" method = \"post\">";
echo "<select name=\"selectMonth\" required>";
echo "<option value=\"0\" selected=\"selected\">Pick A Month</option> ";
echo "<option value=\"1\">January</option> ";
echo "<option value=\"2\">February</option> ";
echo "<option value=\"3\">March</option> ";
echo "<option value=\"4\">April</option> ";
echo "<option value=\"5\">May</option> ";
echo "<option value=\"6\">June</option> ";
echo "<option value=\"7\">July</option> ";
echo "<option value=\"8\">August</option> ";
echo "<option value=\"9\">September</option> ";
echo "<option value=\"10\">October</option> ";
echo "<option value=\"11\">November</option> ";
echo "<option value=\"12\">December</option> ";
echo "</select><br/>";

//day
echo "Enter the Day:<br/>";
echo" <input type = 'text' name = 'selectDay'required><br><br>";
echo "<input type=\"submit\" class = \"cBtn fLeft\" name=\"addDS\" value=\"Submit\" />";
echo "</form>";
//time





}

//add date slot
if(isset($_POST['addDS']))
{
	//insert date as a question? or create new table to handle month, and day. or parse data as a single data object and save that as question name. 
	$month = $_POST['selectMonth'];
	if($month < 10)
	{
		$temp = strval($month);
		$smonth = "0".$temp;

	}
	else
	{
	$smonth = strval($month);
	}

	$day = $_POST['selectDay'];
	 if (is_numeric($day))
	 {
	 	if($day < 10)
		{
			$temp = strval($day);
			$sday = "0".$temp;
		}
		else
		{
			$sday = strval($day);
		}
		$error = "";
	 	$_SESSION['errorNum'] = $error;

	
	 }
	 else
	 {
	 	$error = "<strong>Invalid numeric value</strong>";
?>
		 	  <script type="text/javascript">
			    alert("Invalid numeric value, Please enter a valid number.");
			   // history.ref();
			  </script>	

	 <?php	
	 	echo"<script>window.location.href = \"labstudycreation.php\";</script>";
	 	exit();
	 }

	
	$year = date("Y");
	$syear = strval($year);	
	
	if (checkdate ($month , $day , $year ))
	{
		//echo "THE DATE SELECTED IS:".$month." ".$day." ".$year." IS A CORRECT DATE!<br/>";

		$date = $syear.'/'.$smonth.'/'.$sday;
		echo $date."<br/>";
		
		include('ConnectToDb.php');
		$surveyType = $_SESSION['sType'];
		$sid = $_SESSION['idSurvey'];
		$sName = $_SESSION['sName'];
		$addDate = "INSERT INTO LabDate (idSurvey, labDate) values ($sid, '$date')";
		$conn->query($addDate);

	}
	else
	{
		echo "Date is values are invalid.<br/>";
	}

}


//buttons
echo "<form id=\"Addbtn\" class=\"\" action=\"labstudycreation.php\" method = \"post\">";
echo "<input type=\"submit\" class = \"cBtn fLeft\" name=\"DateSlot\" value=\"Add Date Slot\" />";
echo "</form>";

$sql = "SELECT * from LabDate where idSurvey = $sid";

$resultMe = $conn->query($sql);
    $labSurvey='';
    $labtimeview  = '';
    if ($resultMe->num_rows > 0){
        // output data of each row
        while($row = $resultMe->fetch_assoc())
         {
            $labdate = $row['labDate'];
            $SID = $row['idSurvey'];
            $labid = $row['idLabDate'];
			$timeselect = "SELECT * from LabTime where idLabDate = $labid";
			$labSurvey.= "<div class =\"innerRow\">
			
			<span class=\"fifty padL\">DATE: $labdate</span>
			<span class=\"padL selectRow\" onclick =\"\">|  Add Time Slot  |</span>
			<span class=\"padL selectRow\" onclick =\"deleteDateSelect($labid)\">|  Delete Date  |</span>
			</div>";
			$resulttime = $conn->query($timeselect);
			if($resulttime->num_rows > 0)
			{
				while($row = $resulttime->fetch_assoc())
         			{
         				 $labtimeid = $row['idLabTime'];
         				 $labtime = $row['labTime'];
         				 $labSurvey .= "<div class =\"innerRow\">			
							<span class=\"fifty padL\">Time: $labtime</span>
							<span class=\"padL selectRow\" onclick =\"\">|  Edit Time Slot  |</span>
							<span class=\"padL selectRow\" onclick =\"deleteTimeSelect($labtimeid)\">|  Delete Time Slot  |</span>
							</div>";

         			}

			}
			
			
			          
        }
    }           



echo "<div id=\"surveyBox\" class = \"fLef\">
    <h3>Your Studies</h3>

    <div class=\"scroll\"><div >$labSurvey</div></div><br />    
</div>";

?>
<script type="text/javascript">
function testSelect($SID){
    var form = document.createElement("form");
    input = document.createElement("input");

form.action = "editSurvey.php";
form.method = "post"

input.name = "id";
input.value = $SID;
form.appendChild(input);

document.body.appendChild(form);
form.submit();
}

function filterSelect($SID){
    var form = document.createElement("form");
    input = document.createElement("input");

form.action = "filter.php";
form.method = "post"

input.name = "id";
input.value = $SID;
form.appendChild(input);

document.body.appendChild(form);
form.submit();
}

function deleteDateSelect($SID){
    var form = document.createElement("form");
    input = document.createElement("input");

form.action = "deleteLab.php";
form.method = "post"

input.name = "id";
input.value = $SID;
form.appendChild(input);

document.body.appendChild(form);
form.submit();
}

function deleteTimeSelect($SID){
    var form = document.createElement("form");
    input = document.createElement("input");

form.action = "deleteLabTime.php";
form.method = "post"

input.name = "id";
input.value = $SID;
form.appendChild(input);

document.body.appendChild(form);
form.submit();
}

function redirect(url){
 var win = window.open(url, '_blank');
  win.focus();
}
</script>

<?php
include('footer.php');
?>

