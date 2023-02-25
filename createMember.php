<?php
	require "logged_in_check.php";
	if ($_SESSION['isAdmin']==0 && $_SESSION['isSecretary']==0) {
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=points.php\">";
		die;
	} else {}
	require "database_connect.php";
	
	require "html_header_begin.txt";
	require "html_header_end.txt";
	
	$var = false;
	$query = $db->query("SELECT username FROM Member");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	while($row = $query->fetch()) {
		if($row['username'] == $_POST['username']) { $var = true; }
	}
	
	if($var == false) {
		$query = $db->prepare("INSERT INTO Member (username, password, firstName, lastName, status) VALUES (:username, :password, :firstName, :lastName, :status)");
		$query->execute(array('username'=>$_POST['username'], 'password'=>md5($_POST['password']), 'firstName'=>$_POST['firstName'], 'lastName'=>$_POST['lastName'], 'status'=>$_POST['status']));
	
		echo "<h3>Member Created</h3>";
		echo "<meta http-equiv=\"refresh\" content=\"2; url=manageMembers.php\">";
	} else {
		echo "<h3>Username is not unique. Try again.</h3>";
		echo "<meta http-equiv=\"refresh\" content=\"3; url=manageMembers.php\">";
	}

	require "html_footer.txt";
?>