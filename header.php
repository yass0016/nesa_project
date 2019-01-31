<div id="main"> 
  <!-- header -->
  <div class="website_title">
    <h1>NeSa Professor System</h1>
  </div>
  <div id="header">
    <div id="menu">
      <?php
						if (!empty($_SESSION['username'])) {
						?>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="listTerms.php">View Terms</a></li>
        <li><a href="listStudents.php">View Students</a></li>
        <li><a href="viewScores.php">View Scores</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
      <?php
						} else {
							?>
      <ul>
		<li><a href="index.php">Home</a></li>
        <li><a href="login.php">Professor Login</a></li>
        <li><a href="register.php">Professor Register</a></li>
      </ul>
      <?php
						}
					?>
    </div>
  </div>
  <div id="page">
    <div class="inner_copy"></div>