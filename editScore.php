<?php 
	include('init.php');	

	/* error array containing all the error messages */
	$errors = array();
	
	if (!empty($_POST['save_score'])) {
		if (isset($_POST['test'], $_POST['final_test'], $_POST['swe'], $_POST['pi'], $_POST['sos'], $_POST['advisor1'], $_POST['advisor2'], $_POST['design'])) {
			$rawTest = $_POST['test'];
			$rawFinalTest = $_POST['final_test'];
			$rawSWE = $_POST['swe'];
			$rawPI = $_POST['pi'];
			$rawSOS = $_POST['sos'];
			$rawAdvisor1 = $_POST['advisor1'];
			$rawAdvisor2 = $_POST['advisor2'];
			$rawDesign = $_POST['design'];
			$s_id = $_POST['s_id'];
			
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
		
			if ($rawTest > $defaultTest) {
				$errors[] = 'Student score for the Test must be less than the default score.';
			}
			
			if ($rawFinalTest > $defaultFinalTest) {
				$errors[] = 'Student score for the Final Assessment must be less than the default score.';
			}
			
			if ($rawSWE > $defaultSWE) {
				$errors[] = 'Student score for the SWE must be less than the default score.';
			}
			
			if ($rawPI > $defaultPI) {
				$errors[] = 'Student score for the PI must be less than the default score.';
			}
			
			if ($rawSOS > $defaultSOS) {
				$errors[] = 'Student score for the SOS must be less than the default score.';
			}
			
			if ($rawAdvisor1 > $defaultAdvisor1) {
				$errors[] = 'Student score for the Advisor1 must be less than the default score.';
			}
			
			if ($rawAdvisor2 > $defaultAdvisor2) {
				$errors[] = 'Student score for the Advisor2 must be less than the default score.';
			}
		
			if ($rawDesign > $defaultDesign) {
				$errors[] = 'Student score for the Design must be less than the default score.';
			}
			
			// if array is empty then no errors have been detected then update student scores
			if (empty($errors)) {
				$sql = "UPDATE scores SET test = '{$rawTest}', final_test = '{$rawFinalTest}', swe = '{$rawSWE}', pi = '{$rawPI}', sos = '{$rawSOS}', advisor1 = '{$rawAdvisor1}', advisor2 = '{$rawAdvisor2}', design = '{$rawDesign}' WHERE s_id = '{$s_id}'";
			
				$result = mysql_query($sql);
	
				if(!$result) {
					echo "Failed to set save student scores";
				} else {
					header('Location: viewScores.php');
					die();
				}
			}
		}
	}
	
	if (isset($_POST['student_id'])) {
		$student_id = $_POST['student_id'];
		
		$sql = "SELECT FirstName, LastName FROM student WHERE s_id = '{$student_id}'";
		$result = mysql_query($sql);
	
		if(!$result) {
			echo "Could not execute query";
		}
		
		while($row = mysql_fetch_array($result)) {
			$firstname = $row['FirstName'];
			$lastname = $row['LastName'];
		}
		
		// select current student scores and store them in variables
		$sql = "SELECT * FROM scores WHERE s_id = '{$student_id}'";
		$result = mysql_query($sql);
	
		if(!$result) {
			echo "Could not execute query";
		}
		
		while($row = mysql_fetch_array($result)) {
			$rawTest = $row['test'];
			$rawFinalTest = $row['final_test'];
			$rawSWE = $row['swe'];
			$rawPI = $row['pi'];
			$rawSOS = $row['sos'];
			$rawAdvisor1 = $row['advisor1'];
			$rawAdvisor2 = $row['advisor2'];
			$rawDesign = $row['design'];
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
	} else {
		//header('Location: index.php');
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
<p>
        <?php
						// check if error is not empty then print all detected errors
						if (empty($errors) === false) {
							?>
      <ul>
        <?php
									foreach ($errors as $error) {
										echo "<li>{$error}</li>";
									}
								?>
      </ul>
      <?php
						}
					?>
</p>
<div class="formWrapper">
  <div class="formHeader">
    <h3>Edit Score for Student <? echo $firstname . " " . $lastname; ?></h3>
  </div>
  <form id="editScoreForm" class="form" method="post">
    <fieldset>
      <label class="label">Test out of <? echo $defaultTest; ?></label>
      <input type="number" id="test" class="required" maxlength="30" name="test" value="<?php echo $rawTest; ?>" />
      <br/>
      <div class="clear">&nbsp;</div>
      <label class="label">Final Assessment out of <? echo $defaultFinalTest; ?></label>
      <input type="number" id="final_test" class="required" maxlength="30" name="final_test" value="<?php echo $rawFinalTest; ?>" />
      <br/>
      <div class="clear">&nbsp;</div>
      <label class="label">SWE out of <? echo $defaultSWE; ?></label>
      <input type="number" id="swe" class="required" maxlength="30" name="swe" value="<?php echo $rawSWE; ?>" />
      <br/>
      <div class="clear">&nbsp;</div>
      <label class="label">PI out of <? echo $defaultPI; ?></label>
      <input type="number" id="pi" class="required" maxlength="30" name="pi" value="<?php echo $rawPI; ?>" />
      <br/>
      <div class="clear">&nbsp;</div>
      <label class="label">SOS out of <? echo $defaultSOS; ?></label>
      <input type="number" id="sos" class="required" maxlength="30" name="sos" value="<?php echo $rawSOS; ?>" />
      <br/>
      <div class="clear">&nbsp;</div>
      <label class="label">Advisor1 out of <? echo $defaultAdvisor1; ?></label>
      <input type="number" id="advisor1" class="required" maxlength="30" name="advisor1" value="<?php echo $rawAdvisor1; ?>" />
      <br/>
      <div class="clear">&nbsp;</div>
      <label class="label">Advisor2 out of <? echo $defaultAdvisor2; ?></label>
      <input type="number" id="advisor2" class="required" maxlength="30" name="advisor2" value="<?php echo $rawAdvisor2; ?>" />
      <br/>
      <div class="clear">&nbsp;</div>
      <label class="label">Design out of <? echo $defaultDesign; ?></label>
      <input type="number" id="design" class="required" maxlength="30" name="design" value="<?php echo $rawDesign; ?>" />
      <br/>
      <div class="clear">&nbsp;</div>
	  <input type='hidden' name='s_id' value='<? echo $student_id; ?>' />
      <input type="submit" value="Save" name="save_score" class="btn primary wide">
    </fieldset>
  </form>
</div>
</body>
</html>