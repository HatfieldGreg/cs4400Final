
<?php
include('header.php');
include('ConnectToDb.php');
include('GetUserLevel.php');

 echo "<br /><button class = 'cBtn fRight' onclick ='Sure()'>Log off</button>";
switch($userLevel)
{
	case 'New':
		echo "<h2>New User Page </h2><hr />";
		include('NewUser.php');	
		break;
	case 'Participant':
		echo "<h2>Participant &nbsp;&nbsp;&nbsp;&nbsp; $uvid</h2><hr />";
		include('participant.php');	
		break;
	case 'Teacher':
		echo "<h2>Teacher &nbsp;&nbsp;&nbsp;&nbsp; $uvid</h2><hr />";
		include('Teacher_Researcher.php');
		break;
	case 'Researcher':
		echo "<h2>Researcher &nbsp;&nbsp;&nbsp;&nbsp; $uvid</h2><hr />";
		include('Teacher_Researcher.php');
		break;
	case 'Admin':
		echo "<h2>Admin &nbsp;&nbsp;&nbsp;&nbsp; $uvid</h2><hr />";
		include('Admin.php');
		break; 
	default:
		echo "No user type found";
}

$conn->close();
include('footer.php');
?>
<script type = "text/javascript">
function Sure(){
if (confirm('Are you sure you want to log off the uvu web service?')) {
	location.href = 'http://cas.uvu.edu/cas/logout';
} else {
    // Do nothing!
}
}
</script>

