<?php
date_default_timezone_set("Europe/London");
$date = date("Y-m-d");
$first = date("Y-m-01", strtotime($date));
$last = date("Y-m-t", strtotime($date));
$milestones = [0, 1000, 2500, 5000, 10000, 15000, 20000, 25000, 30000, 35000, 40000, 45000, 50000, 55000, 60000, 65000, 70000, 75000, 80000, 85000, 90000, 95000, 100000, "Ask Drunky!"];
$prices = [0, 5, 5, 10, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60, 65, 70, 75, 80, 85, 90, 95, 100, "!"];
$totalgdp = 0;
echo "<table border=1><tr><td>Name</td><td>GDP</td><td>Current Milestone</td><td>Next Milestone</td></tr>";
$q = mysqli_query($link, "SELECT Name, SUM(GDP) AS GDP FROM Updates WHERE `Update` >= '$first' AND `Update` <= '$last' GROUP BY Name ORDER BY GDP DESC;");
while($row = mysqli_fetch_array($q)){
	if($row["GDP"] > 0){
		echo "<tr><td><A HREF='index.php?x=user&name=" . $row["Name"] . "'>" . $row["Name"] . "</A></td><td>" . $row["GDP"] . "</td>";
		/*$count = count($milestones);
		for($i = 0; $i < $count; $i++){
			if($row["GDP"] <= $milestones[$i]){
				if($row["GDP"] == $milestones[$i]){
					echo "<td>" . $milestones[$i] . "(" . $prices[$i] . "p)</td><td>" . $milestones[$i+1] . "(" . $prices[$i+1] . "p)</td></tr>";
				}elseif($row["GDP"] < $milestones[$i]){
					echo "<td>" . $milestones[$i-1] . "(" . $prices[$i-1] . "p)</td><td>" . $milestones[$i] . "(" . $prices[$i] . "p)</td></tr>";
				}elseif($row["GDP"] > $milestones[10]){
					echo "<td>" . $milestones[10] . "(" . $prices[10] . "p)</td><td>" . $milestones[11] . "(" . $prices[11] . ")</td></tr>";
				}
				
				break;
			}
		}*/
		
			if($row["GDP"] < 1000){
				echo "<td>0 (0p)</td><td>1000 (5p)</td></tr>";
			}elseif(($row["GDP"] >= 1000) && ($row["GDP"] < 2500)){
				echo "<td>1000 (5p)</td><td>2500 (5p)</td></tr>";
			}elseif(($row["GDP"] >= 2500) && ($row["GDP"] < 5000)){
				echo "<td>2500 (5p)</td><td>5000 (10p)</td></tr>";
			}elseif(($row["GDP"] >= 5000) && ($row["GDP"] < 10000)){
				echo "<td>5000 (10p)</td><td>10000 (10p)</td></tr>";
			}elseif(($row["GDP"] >= 10000) && ($row["GDP"] <= 100000)){
				echo "<td>" . (floor($row["GDP"]/5000)*5000) . " (" . (floor($row["GDP"]/5000)*5) . "p)</td><td>" . (floor($row["GDP"]/5000+1)*5000) . " (" . (floor($row["GDP"]/5000+1)*5) . "p)</td></tr>";
			}elseif($row["GDP"] > 100000){
				echo "<td>" . (floor($row["GDP"]/5000)*5000) . " (100p)</td><td>" . (floor($row["GDP"]/5000+1)*5000) . " (100p)</td></tr>";
			}
	}
	$totalgdp = $totalgdp + $row["GDP"];
}
echo "<tr><td>Total GDP this month</td><td>" . $totalgdp . "</td><td colspan=2></td></tr>";
echo "</table>";
?>
