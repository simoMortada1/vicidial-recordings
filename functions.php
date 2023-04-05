
<?php

// some utils.


function agent_full_name($id, $link) {
        $query = "
                SELECT full_name
                FROM vicidial_users
                WHERE user='$id'
         ";
         $stmt = $link -> prepare($query);
         $stmt -> execute();
         $result = $stmt->fetchAll();
         return $result[0]["full_name"];
}

function phone_number($x){
	$pos = strpos($x, '_')+1;
	return substr($x, $pos);
}

function get_date_difference($timein, $timeout) {

$diffs = [
    'years' => 'y',
    'months' => 'm',
    'days' => 'd',
    'hours' => 'h',
    'minutes' => 'i',
    'seconds' => 's'
];

$interval = $timeout->diff($timein);
$diffArr = [];
foreach ($diffs as $k => $v) {
    $d = $interval->format('%' . $v);
    $diffArr[] = $d;
}
return $diffArr;
}

?>

