<?php 
	include('init.php');
	
	$color = false;
	$t_id = $_SESSION['profid'];
	$term_id = $_SESSION['defaultterm'];
	
	// select the default raw scores
	$result = mysql_query("SELECT * FROM rawScore WHERE TeacherID = '{$t_id}'");
	
	if (!$result) {
		die('Invalid query: ' . mysql_error());
	}
						
	while($row = mysql_fetch_array($result))
	{
		$defaultTest = $row['test_score'];
		$defaultFinalTest = $row['fa_score'];
		$defaultSWE = $row['swe_score'];
		$defaultPI = $row['pi_score'];
		$defaultSOS = $row['sos_score'];
		$defaultAdvisor1 = $row['a1_score'];
		$defaultAdvisor2 = $row['a2_score'];
		$defaultDesign = $row['design_score'];
	}
					
	$defaultTotal = $defaultTest + $defaultFinalTest + $defaultSWE + $defaultPI + $defaultSOS + $defaultAdvisor1 + $defaultAdvisor2 + $defaultDesign;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="includes/css/style.css" />
<title></title>
<script>
function editScore() {
    var newForm = window.open('editScore.php', 'formpopup', 'width=450,height=600,resizeable,scrollbars');
}
</script>
</head>
<body>
<?php include('header.php'); ?>
<div id="scoreContent">
<div class="post">
	<? if (count_students($_SESSION['profid'], $_SESSION['defaultterm']) <= 0) {
			echo "There are currently no students to view. Please add students first.";
		 } else {
	?>
  <table class="scoreTable" width="100%" border="1">
  <tr  style="background-color:#1F4189; color:#fff;">
    <td rowspan="2"><strong>Student</strong></td>
    <td colspan="2"><strong>Test</strong></td>
    <td colspan="2"><strong>Final Assessment</strong></td>
    <td colspan="2"><strong>SWE</strong></td>
    <td colspan="2"><strong>PI</strong></td>
    <td colspan="2"><strong>SOS</strong></td>
    <td colspan="2"><strong>Advisor1</strong></td>
    <td colspan="2"><strong>Advisor2</strong></td>
    <td colspan="2"><strong>Design</strong></td>
    <td colspan="2"><strong>Total </strong></td>
	<td><strong>Edit </strong></td>
    </tr>
  <tr>
    <td style="background-color:#E7EBF2"><strong><? echo $defaultTest; ?></strong></td>
    <td><strong>15%</strong></td>
    <td style="background-color:#E7EBF2"><strong><? echo $defaultFinalTest; ?></strong></td>
    <td><strong>25%</strong></td>
    <td style="background-color:#E7EBF2"><strong><? echo $defaultSWE; ?></strong></td>
    <td><strong>5%</strong></td>
    <td style="background-color:#E7EBF2"><strong><? echo $defaultPI; ?></strong></td>
    <td><strong>5%</strong></td>
    <td style="background-color:#E7EBF2"><strong><? echo $defaultSOS; ?></strong></td>
    <td><strong>25%</strong></td>
    <td style="background-color:#E7EBF2"><strong><? echo $defaultAdvisor1; ?></strong></td>
    <td><strong>5%</strong></td>
    <td style="background-color:#E7EBF2"><strong><? echo $defaultAdvisor2; ?></strong></td>
    <td><strong>5%</strong></td>
    <td style="background-color:#E7EBF2"><strong><? echo $defaultDesign; ?></strong></td>
    <td><strong>15%</strong></td>
    <td style="background-color:#E7EBF2"><strong><? echo $defaultTotal; ?></strong></td>
    <td><strong>100%</strong></td>
    <td></td>
  </tr>
    <?
						$result = mysql_query("SELECT student.FirstName, student.LastName, scores.test, scores.*
															   FROM student LEFT JOIN scores ON (student.s_id=scores.s_id) WHERE student.TeacherID = '{$t_id}' AND student.TermID = '{$term_id}' ORDER BY student.LastName ASC");
	
						if (!$result) {
							die('Invalid query: ' . mysql_error());
						}
	
						while($row = mysql_fetch_array($result))
						{ 
							$rawTest = $row['test'];
							$rawFinalTest = $row['final_test'];
							$rawSWE = $row['swe'];
							$rawPI = $row['pi'];
							$rawSOS = $row['sos'];
							$rawAdvisor1 = $row['advisor1'];
							$rawAdvisor2 = $row['advisor2'];
							$rawDesign = $row['design'];
							$rawTotal = $rawTest + $rawFinalTest + $rawSWE + $rawPI + $rawSOS + $rawAdvisor1 + $rawAdvisor2 + $rawDesign;
							
							$testResult = (($rawTest * 15) / $defaultTest);
							$finalTestResult = (($rawFinalTest * 25) / $defaultFinalTest);
							$sweResult = (($rawSWE * 5) / $defaultSWE);
							$piResult = (($rawPI * 5) / $defaultPI);
							$sosResult = (($rawSOS * 25) / $defaultSOS);
							$advisor1Result = (($rawAdvisor1 * 5) / $defaultAdvisor1);
							$advisor2Result = (($rawAdvisor2 * 5) / $defaultAdvisor2);
							$designResult = (($rawDesign * 15) / $defaultDesign);
							$totalResult = $testResult + $finalTestResult + $sweResult + $piResult + $sosResult + $advisor1Result + $advisor2Result + $designResult;
							
							?>
							<tr>
								<td><? echo $row['FirstName'] . " " . $row['LastName']; ?></td>
								<td style="background-color:#E7EBF2"><? echo $rawTest; ?></td>
								<td><? echo round($testResult, 2); ?></td>
								<td style="background-color:#E7EBF2"><? echo $rawFinalTest; ?></td>
								<td><? echo round($finalTestResult, 2); ?></td>
								<td style="background-color:#E7EBF2"><? echo $rawSWE; ?></td>
								<td><? echo round($sweResult, 2); ?></td>
								<td style="background-color:#E7EBF2"><? echo $rawPI; ?></td>
								<td><? echo round($piResult, 2); ?></td>
								<td style="background-color:#E7EBF2"><? echo $rawSOS; ?></td>
								<td><? echo round($sosResult, 2); ?></td>
								<td style="background-color:#E7EBF2"><? echo $rawAdvisor1; ?></td>
								<td><? echo round($advisor1Result, 2); ?></td>
								<td style="background-color:#E7EBF2"><? echo $rawAdvisor2; ?></td>
								<td><? echo round($advisor2Result, 2); ?></td>
								<td style="background-color:#E7EBF2"><? echo $rawDesign; ?></td>
								<td><? echo round($designResult, 2); ?></td>
								<td style="background-color:#E7EBF2"><? echo $rawTotal; ?></td>
								<td><? echo round($totalResult, 2); ?></td>
								<td><? echo "<form id='editScoreForm' action='editScore.php' method='post'>
										<input type='hidden' name='student_id' value='".$row['s_id']."' />
										<input type='submit' name='edit_score' value='Edit Scores' />
										</form>"; ?></td>
							  </tr>
							<?
						}
	?>
  </table>
  <br/>
  <form id='editRawForm' action='editRawScores.php' method='post'>
	<input type='submit'  value='Edit Default Items Score' />
  </form>
  <? } ?>
</div>
</div>
<?php include('footer.php'); ?>
</body>
</html>