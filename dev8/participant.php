<?php
include('NewMySurveys.php');
	echo "<div id=\"surveyBox\" class = \"fLef\">
	<h3>Potential Studies</h3>
	<p>Take the following brief screening surveys to determine which studies you qualify for:</p>
	<div class=\"scroll\"><div >$ResearchSurvey</div></div><br />
	<h3>Studies You Qualify For</h3>
	<p>After completing the brief screening surveys,\n the studies you qualify for will appear here:</p>
	<div class=\"scroll\"><div >$QualticsSurvey</div></div>
</div>
<br />
<input type=\"button\" class='cBtn' value=\"Charateristics profile\" onclick=\"location='characteristics.php'\" /> ";
?>