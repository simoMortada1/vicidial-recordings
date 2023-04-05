
<?php

//dbConfig.php to establish connection with vicidial/asterisk database.

	$dsn = "mysql: host=localhost; dbname=asterisk";
// adjust $username & $password to your local db crendentials
	$username= 'cron';
	$password = '1234';
	$options = [];

	try {
		$link = new PDO($dsn, $username, $password, $options);
		$link -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$link -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	}

	catch(PDOException $e) {
		echo 'Error Connecting to the database ' . $e->getMesssage();
	}

?>
