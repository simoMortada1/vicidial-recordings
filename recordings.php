

<?php
require_once 'dbConfig.php';
include 'functions.php';

# recordings.php - Vicidial recordings access page 

# Copyright (c) Pi Telecom (pitelecomsarl@gmail.com) 2022  
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Vicidial Recordings</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" type="text/css" href="https:///cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>

</head>

<body style="font-family: lato, 'open sans'">
<div class="integration">
                                  <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="GET" class="w3-light-grey  w3-container w3-padding-16">
<div class="w3-cell-row">
                                <div class="w3-cell w3-container"><input value = "<?php echo $_GET['agent'];?>" type="text" class="w3-input w3-round" name="agent" id="agent" placeholder="Agent ID"></div>
                                <div class="w3-cell w3-container"><input type="text" class="w3-input w3-round" name = "phone_number" placeholder="Phone number: Ex. 0612345678"></div>
                                <div class="w3-cell w3-container"><input type="text" class="w3-input w3-round" name="lead_id" placeholder="Lead ID"></div>
                        </div>
			<div class="w3-section w3-cell-row" style="width:50%; margin:auto">
                                <div class="w3-cell w3-container "><label for="start_date">From</label> <input type="date" name="start_date" id="start_date" value="<?php echo $_GET['start_date']?$_GET['start_date']:date('Y-m-d') ; ?>"></div>
                                <div class="w3-cell w3-container w3-center"><label for="end_date">To</label> <input type="date" name="end_date" id="end_date" value="<?php echo $_GET['end_date']?$_GET['end_date']:date('Y-m-d'); ?>"></div>
</div>
                        <div class="w3-center w3-panel w3-margin-bottom"><input type="submit" class="w3-button w3-indigo w3-round" value="Search!"></div>

                </form>

	<?php 
			$today = date('Y-m-d');
			$from = $_GET['start_date'];
			$to = $_GET['end_date'];
			$agent = $_GET['agent'];
			$lead_id = $_GET['lead_id'];
			$phone_number = $_GET['phone_number'];
			$exp .= $agent?" user=$agent":1;
			$exp .= $from?" and date(start_time)>='$from' ":" and date(start_time)>='$today'";
			$exp .= $to ?" and date(end_time)<='$to'":" and date(end_time)<='$today'";
			$exp .= $lead_id?" and lead_id=$lead_id":''; 
		 	$exp .= $phone_number?" and substr(filename,17)=$phone_number":''; 	
			$query = "select * from recording_log where $exp order by start_time desc";
			$stmt = $link -> prepare($query);
			$stmt -> execute();
			$recordings = $stmt -> fetchAll();
			$rows = sizeof($recordings); 
			if ($rows == 0) echo ' <div class="w3-center w3-container w3-large" style="padding:150px 0">Sorry There is no result for this search!</div> '; else { 
	?>
	<div class="w3-content w3-margin-bottom"> 
	<table id="myTable" class="w3-table w3-bordered w3-small"> 
			<thead><tr class="w3-medium"><th>Recording ID</th><th>Lead ID</th><th>Phone Number</th><th>Agent </th><th>Date</th><th>Duration (sec) </th><th>Actions</th></tr></thead><tbody>
    <?php
                                       for ($i=0; $i<$rows; $i++) {
					       $agent = $recordings[$i]['user'];
					       $lead_id = '../vicidial/admin_modify_lead.php?lead_id='. $recordings[$i]['lead_id'].'&archive_search=No&archive_log=0';
					       echo '<tr><td># '. $recordings[$i]['recording_id'] . '</td>';
					       echo '<td><a target=_blank href= ' . $lead_id . '>' . $recordings[$i]['lead_id'] . '</a></td>';
					       echo '<td>'. phone_number($recordings[$i]['filename']). '</td>';
					       echo '<td><a href="../vicidial/admin.php?ADD=3&user= '. $agent . '"> '. $agent . '</a></td>';
					       echo '<td>'. $recordings[$i]['start_time'] . '</td>';
					       echo '<td>'. $recordings[$i]['length_in_sec'] . '</td>';
					       echo '<td>
						        <a href="'. $recordings[$i]['location'] .'" target=_blank><i class="fas fa-headphones w3-text-indigo"></i></a><a download href="'. $recordings[$i]['location'] .'" ><i class="fas fa-file-download w3-margin-left w3-text-indigo"></i></a> </td>';
					       echo '</tr>';  
				       }}
	?>    
</tbody>	</table>
</div>
<!--<div class="w3-section w3-light-grey w3-bottom">
<div class="w3-bar">
<a class="w3-bar-item" href="#">Home</a><a class="w3-bar-item" href="#">Link #1</a><a class="w3-bar-item" href="#">link #2</a>
</div>-->
</div>

</body>
</html>
