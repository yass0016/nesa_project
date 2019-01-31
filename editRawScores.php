<?php 
	include('init.php');	

	if (!empty($_POST['save_score'])) {
		if (isset($_POST['test'], $_POST['final_test'], $_POST['swe'], $_POST['pi'], $_POST['sos'], $_POST['advisor1'], $_POST['advisor2'], $_POST['design'])) {
			$defaultTest = $_POST['test'];
			$defaultFinalTest = $_POST['final_test'];
			$defaultSWE = $_POST['swe'];
			$defaultPI = $_POST['pi'];
			$defaultSOS = $_POST['sos'];
			$defaultAdvisor1 = $_POST['advisor1'];
			$defaultAdvisor2 = $_POST['advisor2'];
			$defaultDesign = $_POST['design'];
			$t_id = $_SESSION['profid'];
			
			$sql = "UPDATE rawScore SET test_score = '{$defaultTest}', fa_score = '{$defaultFinalTest}', swe_score = '{$defaultSWE}', pi_score = '{$defaultPI}', sos_score = '{$defaultSOS}', a1_score = '{$defaultAdvisor1}', a2_score = '{$defaultAdvisor2}', design_score = '{$defaultDesign}' WHERE TeacherID = '{$t_id}'";
			
			$result = mysql_query($sql);
	
			if(!$result) {
				echo "Failed to set save default scores";
			} else {
				header('Location: viewScores.php');
				die();
			}
		}
	}
	
	// select default item raw scores
	$t_id = $_SESSION['profid'];
	$sql = "SELECT * FROM rawScore WHERE TeacherID = '{$t_id}'";
	$result = mysql_query($sql);
	
	if(!$result) {
		echo "Could not execute query";
	}
		
	while($row = mysql_fetch_array($result)) {
		$defaultTest = $row['test_score'];
		$defaultFinalTest = $row['fa_score'];
		$defaultSWE = $row['swe_score'];
		$defaultPI = $row['pi_score'];
		$defaultSOS = $row['sos_score'];
		$defaultAdvisor1 = $row['a1_score'];
		$defaultAdvisor2 = $row['a2_score'];
		$defaultDesign = $row['design_score'];
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="includes/css/style.css" />
<title>Edit Score</title>
</head>
<body>
<div class="formWrapper">
  <div class="formHeader">
    <h3>Edit Score for Student <? echo $firstname . " " . $lastname; ?></h3>
  </div>
  <form id="editScoreForm" class="form" method="post">
    <fieldset>
      <label class="label">Test</label>
      <input type="number" id="test" class="required" maxlength="30" name="test" value="<?php echo $defaultTest; ?>" />
      <br/>
      <div class="clear">&nbsp;</div>
      <label class="label">Final Assessment</label>
      <input type="number" id="final_test" class="required" maxlength="30" name="final_test" value="<?php echo $defaultFinalTest; ?>" />
      <br/>
      <div class="clear">&nbsp;</div>
      <label class="label">SWE</label>
      <input type="number" id="swe" class="required" maxlength="30" name="swe" value="<?php echo $defaultSWE; ?>" />
      <br/>
      <div class="clear">&nbsp;</div>
      <label class="label">PI</label>
      <input type="number" id="pi" class="required" maxlength="30" name="pi" value="<?php echo $defaultPI; ?>" />
      <br/>
      <div class="clear">&nbsp;</div>
      <label class="label">SOS</label>
      <input type="number" id="sos" class="required" maxlength="30" name="sos" value="<?php echo $defaultSOS; ?>" />
      <br/>
      <div class="clear">&nbsp;</div>
      <label class="label">Advisor1</label>
      <input type="number" id="advisor1" class="required" maxlength="30" name="advisor1" value="<?php echo $defaultAdvisor1; ?>" />
      <br/>
      <div class="clear">&nbsp;</div>
      <label class="label">Advisor2</label>
      <input type="number" id="advisor2" class="required" maxlength="30" name="advisor2" value="<?php echo $defaultAdvisor2; ?>" />
      <br/>
      <div class="clear">&nbsp;</div>
      <label class="label">Design</label>
      <input type="number" id="design" class="required" maxlength="30" name="design" value="<?php echo $defaultDesign; ?>" />
      <br/>
      <div class="clear">&nbsp;</div>
	  <input type='hidden' name='t_id' value='<? echo $t_id; ?>' />
      <input type="submit" value="Save" name="save_score" class="btn primary wide">
    </fieldset>
  </form>
</div>
</body>
</html>