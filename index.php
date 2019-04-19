<?php
	require_once 'app/init.php';
	
	if (isset($_GET["dates"])) {
		$dates = $_GET["dates"];
	} else {
		$dates = '0000-00-00 00:00:00';
	}
	
	$app = new Controller;
    $show = $app->model('Ticket_model')->showTicket($dates);
    $count = count($show);

    echo"
    <table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Ticket</th>
            <th>TID</th>
            <th>Status</th>
            <th>Remark</th>
            <th>Information</th>
            <th>Chat ID</th>
            <th>From ID</th>
            <th>Chat Name</th>
            <th>Chat Type</th>
            <th>Input Date</th>
        </tr>
    </thead><tbody id='content'>";

    for($i=0;$i<$count;$i++){
        echo "<tr><td>" . $show[$i]['id'] . "</td>";
        echo "<td id='ticket'>" . $show[$i]['ticket'] . "</td>";
        echo "<td id='tid'>" . $show[$i]['tid'] . "</td>";
        echo "<td id='status'>" . $show[$i]['status'] . "</td>";
        echo "<td id='remark'>" . $show[$i]['remark'] . "</td>";
        echo "<td id='information'>" . $show[$i]['information'] . "</td>";
        echo "<td id='chat_id'>" . $show[$i]['chat_id'] . "</td>";
        echo "<td id='from_id'>" . $show[$i]['from_id'] . "</td>";
        echo "<td id='chat_name'>" . $show[$i]['chat_name'] . "</td>";
        echo "<td id='chat_type'>" . $show[$i]['chat_type'] . "</td>";
        echo "<td id='input_date'>" . $show[$i]['input_date'] . "</td>";
        echo "</tr>";        
    }

    echo "</tbody></table>";
?>
