<html>
<title>Post Form</title>
<link rel="stylesheet" type="text/css" href="fstyle.css">
<?php require '../includes/dbconnect.php'; ?>
<body>
<div class="form-page-wrapper">
	<div class="nav-bar">
		<ul>
		<li><a href="../index.php">Home</a></li>
		<li><a href="#">Apps</a></li>
		<li><a href="#">Contact</a></li>
		<li><a href="regform.php">Register</a></li>
		<li><a href="#">Submit</a></li>
		<li><a href="login.php">Login</a></li>
		</ul>
	</div>
	<div class="form-page-content">
        <h1> Post Creation </h1>
        <form action="addpost.php" method="get">
			<div id="ptitle">
				Post Title:
					<div id="titletxt">
						<textarea type="text"  name="title" maxlength="50" required placeholder="Enter Post Title" ></textarea>
					</div>
				<br />
			</div>
				<div id="psummary">
				Post Summary:
					<div id="summarytext">
						<textarea type="text" name="summary" maxlength="50"  placeholder="Enter Post Summary" ></textarea>
					</div>
				</div>
				<br />
			<div id="pbody">
				Post Body:
				<div id="bodytext">
						<textarea type="text" name="body" rows="5" cols="50" required placeholder="Enter Post Body"></textarea>
				</div>
			</div>
				<br />
				<br />
				<input type="submit" class="submit-btn btn" value="Submit">
				<input type="reset" class="reset-btn btn" value="Reset">
		</form>
	</div>					
</body>
<div class="footer">
	<div class="footer-cont">
	<?php $thisYear = (int)date('Y');
	echo $thisYear; ?> © by &#x1f916;
	</div>
</div>
</div>
</html>
