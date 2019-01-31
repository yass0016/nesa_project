<?php 
	include('init.php');	
	
	/* error array containing all the error messages */
	$errors = array();

	if (!empty($_POST['add_term'])) {
		if (isset($_POST['startm'], $_POST['startd'], $_POST['starty'], $_POST['endm'], $_POST['endd'], $_POST['endy'])) {			
			if (empty($_POST['startm'])) {
				$errors[] = 'You must select a start month.';
			}
			
			if (empty($_POST['startd'])) {
				$errors[] = 'You must select a start day.';
			}
			
			if (empty($_POST['starty'])) {
				$errors[] = 'You must select a start year.';
			}
			
			if (empty($_POST['endm'])) {
				$errors[] = 'You must select end month.';
			}
			
			if (empty($_POST['endd'])) {
				$errors[] = 'You must select end day.';
			}
			
			if (empty($_POST['endy'])) {
				$errors[] = 'You must select end year.';
			}
			
			// other checking
			
			// year must be above current year
			if ($_POST['starty'] < date('Y')) {
				$errors[] = 'You must enter a correct start year.';
			}
			
			if ($_POST['endy'] < date('Y')) {
				$errors[] = 'You must enter a correct end year.';
			}
			
			// start date must not be in the same end date
			if (($_POST['startm'] == $_POST['endm']) 
			and ($_POST['startd'] == $_POST['endd']) 
			and ($_POST['starty'] == $_POST['endy'])) {
				$errors[] = 'Term cannot start and end in the same day.';
			}
			
			// end year cannot be less than start year
			if ($_POST['endy'] < $_POST['starty']) {
				$errors[] = 'End year must be bigger than start year.';
			}

			// if same year but end month is less than start month
			if ($_POST['starty'] == $_POST['endy']) {
				if ($_POST['endm'] <	$_POST['startm']) {
					$errors[] = 'End month must be bigger than start month.';
				}
			}
			
			// if same year and month but end day is less than start day
			if ($_POST['starty'] == $_POST['endy']) {
				if ($_POST['startm'] == $_POST['endm']) {
					if ($_POST['endd'] < $_POST['startd']) {
						$errors[] = 'End day must be bigger than start day.';
					}
				}
			}
			
			// if array is empty then no errors have been detected then add term
			if (empty($errors)) {
				// make variables safe from SQL injection
				$startm = mysql_real_escape_string($_POST['startm']);
				$startd = mysql_real_escape_string($_POST['startd']);
				$starty = mysql_real_escape_string($_POST['starty']);
				$endm = mysql_real_escape_string($_POST['endm']);
				$endd = mysql_real_escape_string($_POST['endd']);
				$endy = mysql_real_escape_string($_POST['endy']);

				$t_id = $_SESSION['profid'];

				$sql = "INSERT INTO terms (startm, startd, starty, endm, endd, endy, TeacherID)
				VALUES('{$startm}', '{$startd}', '{$starty}', '{$endm}', '{$endd}', '{$endy}', '{$t_id}')";

				$result = mysql_query($sql);
				if(!$result) {
					echo "Failed to create term";
				} else {

				}
				
				$result = mysql_query("SELECT term_id FROM terms WHERE TeacherID = '{$t_id}'");
	
				if (!$result) {
					die('Invalid query: ' . mysql_error());
				}
	
				while($row = mysql_fetch_array($result))
				{
					// store session variables
					$_SESSION['defaultterm'] = $row['term_id'];
				}
				
				$term_id = $_SESSION['defaultterm'];
				$result = mysql_query("UPDATE professor SET default_term = '{$term_id}' WHERE t_id = '{$t_id}'");
	
				if(!$result) {
					echo "Failed to set term as default";
				} else {
		
				}
			}
		}
	}
		
	if (!empty($_POST['default_term'])) {
		$_SESSION['defaultterm'] = htmlentities($_POST['term_id']);
		
		$t_id = $_SESSION['profid'];
		$term_id = $_POST['term_id'];
		$term_id = mysql_real_escape_string($term_id);
		
		$result = mysql_query("UPDATE professor SET default_term = '{$term_id}' WHERE t_id = '{$t_id}'");
	
		if(!$result) {
			echo "Failed to set term as default";
		} else {
		
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="includes/css/style.css" />
<title></title>
</head>
<body>
<?php include('header.php'); ?>
    <div id="leftbar" class="sidebar">
      <div class="title">
        <h3>Information</h3>
      </div>
      <div class="back">
        <ul>
          <li>You can add new terms by selecting the start and end date then press the Add Term button</li>
		  <li>To archive an old term and make the new created term the current term press the Make Default button beside the term you wish to make current</li>
        </ul>
      </div>
      <div class="bottom"></div>
    </div>
    <div id="content">
	<div class="post">
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
      <p>
      <form method="post" action="">
        <table border="0" cellspacing="0" >
          <tr>
            <td  align="left"> Start Month
              <select name="startm" value="">
                <option value='01'>January</option>
                <option value='02'>February</option>
                <option value='03'>March</option>
                <option value='04'>April</option>
                <option value='05'>May</option>
                <option value='06'>June</option>
                <option value='07'>July</option>
                <option value='08'>August</option>
                <option value='09'>September</option>
                <option value='10'>October</option>
                <option value='11'>November</option>
                <option value='12'>December</option>
              </select></td>
            <td  align="left"> Start Day
              <select name="startd">
                <option value='01'>01</option>
                <option value='02'>02</option>
                <option value='03'>03</option>
                <option value='04'>04</option>
                <option value='05'>05</option>
                <option value='06'>06</option>
                <option value='07'>07</option>
                <option value='08'>08</option>
                <option value='09'>09</option>
                <option value='10'>10</option>
                <option value='11'>11</option>
                <option value='12'>12</option>
                <option value='13'>13</option>
                <option value='14'>14</option>
                <option value='15'>15</option>
                <option value='16'>16</option>
                <option value='17'>17</option>
                <option value='18'>18</option>
                <option value='19'>19</option>
                <option value='20'>20</option>
                <option value='21'>21</option>
                <option value='22'>22</option>
                <option value='23'>23</option>
                <option value='24'>24</option>
                <option value='25'>25</option>
                <option value='26'>26</option>
                <option value='27'>27</option>
                <option value='28'>28</option>
                <option value='29'>29</option>
                <option value='30'>30</option>
                <option value='31'>31</option>
              </select></td>
            <td  align="left"> Start Year
              <input type="text" name="starty" size=4 value=""></td>
          </tr>
          <tr>
            <td  align="left"> End Month
              <select name="endm" value="">
                <option value='01'>January</option>
                <option value='02'>February</option>
                <option value='03'>March</option>
                <option value='04'>April</option>
                <option value='05'>May</option>
                <option value='06'>June</option>
                <option value='07'>July</option>
                <option value='08'>August</option>
                <option value='09'>September</option>
                <option value='10'>October</option>
                <option value='11'>November</option>
                <option value='12'>December</option>
              </select></td>
            <td  align="left"> End Day
              <select name="endd">
                <option value='01'>01</option>
                <option value='02'>02</option>
                <option value='03'>03</option>
                <option value='04'>04</option>
                <option value='05'>05</option>
                <option value='06'>06</option>
                <option value='07'>07</option>
                <option value='08'>08</option>
                <option value='09'>09</option>
                <option value='10'>10</option>
                <option value='11'>11</option>
                <option value='12'>12</option>
                <option value='13'>13</option>
                <option value='14'>14</option>
                <option value='15'>15</option>
                <option value='16'>16</option>
                <option value='17'>17</option>
                <option value='18'>18</option>
                <option value='19'>19</option>
                <option value='20'>20</option>
                <option value='21'>21</option>
                <option value='22'>22</option>
                <option value='23'>23</option>
                <option value='24'>24</option>
                <option value='25'>25</option>
                <option value='26'>26</option>
                <option value='27'>27</option>
                <option value='28'>28</option>
                <option value='29'>29</option>
                <option value='30'>30</option>
                <option value='31'>31</option>
              </select></td>
            <td  align="left"> End Year
              <input type="text" name="endy" size=4 value=""></td>
          </tr>
          <tr>
            <td><input type="submit" name="add_term" value="Add Term"></td>
          </tr>
        </table>
      </form>
      </p>
      <p>
	  
	  <? if($_SESSION['defaultterm'] < 0) {
				echo "No terms have been created yet. Create a new term above";
			} else {
			
		?>
	  
      <table width="100%" border="1">
        <tr style="background-color:#1F4189; color:#fff; font-weight:bold">
          <td><b>Term</b></td>
          <td><b>Start Date</b></td>
          <td><b>End Date</b></td>
        </tr>
        <?
						$t_id = $_SESSION['profid'];
						$sql = "SELECT * FROM terms WHERE TeacherID = '{$t_id}'";
						$result = mysql_query($sql);
	
						if(!$result) {
							echo "Error";
						}
		
						$term_count = 1;
						
						$color = false;
						$disabled = "none";
						
						while($row = mysql_fetch_array($result)) {
							if (!$color) {
								?>
        <tr style="background-color:#fff;">
          <?
							} else {
								?>
        <tr style="background-color:#E7EBF2;">
          <?
							}
							
							if ($row['term_id'] == $_SESSION['defaultterm']) {
								$disabled = "disabled";
							} else {
								$disabled = "none";
							}
							?>
          <td><? echo $term_count; ?></td>
          <td><? echo $row['startm'] . "-" . $row['startd'] . "-" . $row['starty']; ?></td>
          <td><? echo $row['endm'] . "-" . $row['endd'] . "-" . $row['endy']; ?></td>
          <td align="right"><? echo "<form id='defaultTermForm' method='post'>
										<input type='hidden' name='term_id' value='".$row['term_id']."' />
										<input type='submit' name='default_term' value='Make Default' ".$disabled." />
										</form>"; ?></td>
        </tr>
        <?
								$term_count += 1;
								$color = !$color;
						}
					?>
      </table>
	  <? } ?>
      </p>
    </div>
	</div>
    <div id="rightbar" class="sidebar">
      <div class="title">
        <h3>Calendar</h3>
      </div>
      <div class="back">
        <div id="calendar">
          <table id="calendar2" summary="Calendar">
            <thead>
              <tr>
                <th abbr="Monday" scope="col" title="Monday">M</th>
                <th abbr="Tuesday" scope="col" title="Tuesday">T</th>
                <th abbr="Wednesday" scope="col" title="Wednesday">W</th>
                <th abbr="Thursday" scope="col" title="Thursday">T</th>
                <th abbr="Friday" scope="col" title="Friday">F</th>
                <th abbr="Saturday" scope="col" title="Saturday">S</th>
                <th abbr="Sunday" scope="col" title="Sunday">S</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <td abbr="Des" colspan="3" id="prev"><a href="#">&laquo; Dec</a></td>
                <td class="pad">&nbsp;</td>
                <td abbr="Feb" colspan="3" id="next" class="pad"><a href="#">Feb &raquo;</a></td>
              </tr>
            </tfoot>
            <tbody>
              <tr>
                <td colspan="2" class="pad">&nbsp;</td>
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>5</td>
              </tr>
              <tr>
                <td>6</td>
                <td>7</td>
                <td>8</td>
                <td>9</td>
                <td>10</td>
                <td>11</td>
                <td>12</td>
              </tr>
              <tr>
                <td>13</td>
                <td>14</td>
                <td>15</td>
                <td>16</td>
                <td>17</td>
                <td>18</td>
                <td>19</td>
              </tr>
              <tr>
                <td>20</td>
                <td id="now">21</td>
                <td>22</td>
                <td>23</td>
                <td>24</td>
                <td>25</td>
                <td>26</td>
              </tr>
              <tr>
                <td>27</td>
                <td>28</td>
                <td>29</td>
                <td>30</td>
                <td>31</td>
                <td class="pad" colspan="2">&nbsp;</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="bottom"></div>
    </div>
<?php include('footer.php'); ?>
	</body>
</html>