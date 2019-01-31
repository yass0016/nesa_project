<?php 
	include('init.php');	
	
	/* error array containing all the error messages */
	$errors = array();
	
	if (!empty($_POST['add_student'])) {
		if (isset($_POST['sfirstname'], $_POST['slastname'], $_POST['studentnum'])) {
			
			// check for professor entered student first name
			if (empty($_POST['sfirstname'])) {
				$errors[] = 'You must enter a student first name.';
			}
			
			// check for professor entered student last name
			if (empty($_POST['slastname'])) {
				$errors[] = 'You must enter a student last name.';
			}
			
			// check for professor entered student number
			if (empty($_POST['studentnum'])) {
				$errors[] = 'You must enter a student number.';
			}			
			
			// check if the student number is longer than 9 characters
			if (strlen($_POST['studentnum']) != 9) {
				$errors[] = 'The student number must be only 9 numbers';			
			}
			
			// check if the student already exists
			if (student_exist($_POST['studentnum'])) {
				$errors[] = 'This student is already exist.';
			}
			
			// if array is empty then no errors have been detected then add student
			if (empty($errors)) {
				// make variables safe from SQL injection
				$sfirstname = mysql_real_escape_string($_POST['sfirstname']);
				$slastname = mysql_real_escape_string($_POST['slastname']);
				$studentnum = mysql_real_escape_string($_POST['studentnum']);
				$semail = mysql_real_escape_string($_POST['semail']);
				$t_id = $_SESSION['profid'];
				$t_term = $_SESSION['defaultterm'];

				$sql = "INSERT INTO student (s_number, FirstName, LastName, EmailAddress, TeacherID, TermID)
				VALUES('{$studentnum}', '{$sfirstname}', '{$slastname}', '{$semail}',  '{$t_id}', '{$t_term}')";

				$result = mysql_query($sql);
				if(!$result) {
					echo "Failed to add student";
				} else {

				}
				
				$result = mysql_query("SELECT * FROM student WHERE s_number = '{$studentnum}'");
	
				if (!$result) {
					die('Invalid query: ' . mysql_error());
				}
	
				while($row = mysql_fetch_array($result))
				{
					$s_id = $row['s_id'];
				}
				
				$sql = "INSERT INTO scores (test, final_test, swe	, pi, sos, advisor1, advisor2, design, s_id)
				VALUES(0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, '{$s_id}')";

				$result = mysql_query($sql);
				if(!$result) {
					echo "Failed to add student score";
				} else {

				}
			}
		}
	}
	
	if (!empty($_POST['delete_student'])) {
		$student_id = $_POST['student_id'];
		$student_id = mysql_real_escape_string($student_id);
				
		$result = mysql_query("DELETE FROM student WHERE s_id = '{$student_id}'");
		
		if(!$result) {
			echo "Failed to delete student";
		} else {
		}
		
		$result = mysql_query("DELETE FROM scores WHERE s_id = '{$student_id}'");
		
		if(!$result) {
			echo "Failed to delete student";
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
          <li>You can add new students by filling the form and press the Add Student button</li>
          <li>You can delete students from the table by pressing the Delete button beside each student</li>
		</ul>
      </div>
      <div class="bottom"></div>
    </div>
<div id="content">
<div class="post">
  <?php
				if ($_SESSION['defaultterm'] < 0) {
					echo "No default term selected or professor didn't not create a term";
				} else {

				?>
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

  <form id="addStudent" action="" method="post">
    <fieldset>
      <p>
        <label>First Name*:</label>
        <input type="input" name="sfirstname" maxlength="20" />
      </p>
      <p>
        <label>Last Name*:</label>
        <input type="input" name="slastname" maxlength="20" />
      </p>
      <p>
        <label>Student Number*:</label>
        <input type="number" name="studentnum" maxlength="9" />
      </p>
      <p>
        <label>Email Address:</label>
        <input type="input" name="semail" maxlength="50" />
      </p>
      <p>
        <input type="submit" name="add_student" value="Add Student" />
      </p>
    </fieldset>
  </form>
  	<? if (count_students($_SESSION['profid'], $_SESSION['defaultterm']) <= 0) {
			echo "There are currently no students to view.";
		 } else {
	?>
  <table width="100%" border="1">
    <tr style="background-color:#1F4189; color:#fff; font-weight:bold">
      <td><b>First Name</b></td>
      <td><b>Last Name</b></td>
      <td><b>Student #</b></td>
      <td><b>Email Address</b></td>
    </tr>
    <?
						$t_id = $_SESSION['profid'];
						$term_id = $_SESSION['defaultterm'];
						$sql = "SELECT * FROM student WHERE TermID = '{$term_id}' AND TeacherID = '{$t_id}' ORDER BY LastName ASC";
						$result = mysql_query($sql);
	
						if(!$result) {
							echo "Error";
						}
		
						$color = false;
						
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
							?> 
 <td><? echo $row['FirstName']; ?></td>
      <td><? echo $row['LastName']; ?></td>
      <td><? echo $row['s_number']; ?></td>
      <td><? echo $row['EmailAddress']; ?></td>
      <td><? echo "<form id='deleteForm' method='post'>
										<input type='hidden' name='student_id' value='".$row['s_id']."' />
										<input type='submit' name='delete_student' value='Delete' />
										</form>"; ?></td>
    </tr>
    <?
						$color = !$color;
						}
					?>
  </table>

  <?
					}
				}
			?>
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