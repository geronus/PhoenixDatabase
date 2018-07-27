<script>
function getVote(voteid) {
    if (voteid == "") {
        document.getElementById("Poll").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("Poll").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getvote.php?voteid="+voteid,true);
        xmlhttp.send();
    }
}
</script>
<?php
$pollname = $_POST["name"];
$type = $_POST["type"];
$pollname = $_POST["name"];
$option1 = $_POST["option1"];
$option2 = $_POST["option2"];
$option3 = $_POST["option3"];
$option4 = $_POST["option4"];
$option5 = $_POST["option5"];
$dpoll = $_POST["dpollid"];
$vpollid = $_POST["vpollid"];
$vuser = $_POST["vuser"];
$voptionid = $_POST["voptionid"];

echo "<table witdth=100%>";

if($type == "deactivate"){
	$date = date("Y-m-d");
	mysqli_query($link, "UPDATE Polls SET Active = '1', Enddate = '$date' WHERE PollID LIKE '$dpoll';");
	echo "<tr><td width=100% align='center'>Poll ended.<br><br><br></tr></td>";
}elseif($type == "newpoll"){
	$q = mysqli_query($link, "SELECT * FROM Polls ORDER BY PollID DESC LIMIT 1;");
	while($row = mysqli_fetch_array($q)){
		if($pollname != ""){
			if(($option1 != "") && ($option2 != "") && ($option3 != "")){
				$pollid = $row["PollID"] +1;
				mysqli_query($link, "INSERT INTO Polls` (`PollID`, `Name`, `Active`, `Enddate`) VALUES ('$pollid', '$pollname', '0', '');");
				mysqli_query($link, "INSERT INTO PollOptions (`PollID`, `OptionID`, `Option`) VALUES ('$pollid', '1', '$option1');");
				mysqli_query($link, "INSERT INTO PollOptions (`PollID`, `OptionID`, `Option`) VALUES ('$pollid', '2', '$option2');");
				mysqli_query($link, "INSERT INTO PollOptions (`PollID`, `OptionID`, `Option`) VALUES ('$pollid', '3', '$option3');");
				if($option4 != ""){
					mysqli_query($link, "INSERT INTO `PollOptions` (`PollID`, `OptionID`, `Option`) VALUES ('$pollid', '4', '$option4');");
				}
				if($option5 != ""){
					mysqli_query($link, "INSERT INTO `PollOptions` (`PollID`, `OptionID`, `Option`) VALUES ('$pollid', '5', '$option5');");
				}
				echo "<tr><td width=100% align='center'>Created new Poll with name: " . $pollname . "<br><br><br></tr></td>";
			}else{
				echo "<tr><td width=100% align='center'>Need at least three options.<br><br><br></tr></td>";
			}
		}elseif($pollname == ""){
			echo "<tr><td width=100% align='center'>Insert a name you bloody idiot.<br><br><br></tr></td>";
		}
	}
}elseif($type == "vote"){
	if(($vpollid != "-") && ($vuser != "-") && ($voptionid != "-")){
		mysqli_query($link, "INSERT INTO `Votes` (`PollID`, `Name`, `VoteID`) VALUES ('$vpollid', '$vuser', '$voptionid');");
		echo "<tr><td width=100% align='center'>Voted.<br><br><br></tr></td>";
	}else{
		echo "<tr><td width=100% align='center'>Choose on all dropdowns to set a vote.<br><br><br></tr></td>";
	}
}

echo "<tr><td width=100% align='center'><form action='admin.php?x=polls' method='post'>";
echo "<input type='hidden' name='type' value='deactivate'>";
echo "<select name='dpollid'>";
echo "<option selected value='-'>-</option>";

$q = mysqli_query($link, "SELECT * FROM Polls WHERE Active = '0' ORDER BY PollID DESC;");
while($row = mysqli_fetch_array($q)){
	echo "<option value='" . $row["PollID"] . "'>" . $row["Name"] . "</option>";	
}
echo "</select><input type='submit' value='End Poll'></form><br><br></td></tr>";

echo "<tr><td width=100% align='center'><form action='admin.php?x=polls' method='post'>";
echo "<input type='hidden' name='type' value='newpoll'>";
echo "Poll name: <input type='text' name='name' size'20'><br><br>";
echo "Option 1: <input type='text' name='option1' size'20'><br>";
echo "Option 2: <input type='text' name='option2' size'20'><br>";
echo "Option 3: <input type='text' name='option3' size'20'><br>";
echo "Option 4: <input type='text' name='option4' size'20'><br>";
echo "Option 5: <input type='text' name='option5' size'20'><br>";
echo "<input type='submit' value='Submit'></form></td></tr>";

echo "<tr><td width=100% align='center'><form action='admin.php?x=polls' method='post'>";
echo "<input type='hidden' name='type' value='vote'>";
echo "<select name='vpollid' onchange='getVote(this.value)'>";
echo "<option selected value='-'>-</option>";
$q = mysqli_query($link, "SELECT * FROM Polls WHERE Active LIKE '0' ORDER BY Name ASC;");
while($row = mysqli_fetch_array($q)){
	echo "<option value='" . $row["PollID"] . "'>" . $row["Name"] . "</option>";
}
echo "</select><br><div id='Poll'></div>";
/*echo "<select name='vuser'>";
echo "<option selected value='-'>-</option>";
$q = mysqli_query($link, "SELECT * FROM Userliste WHERE Active LIKE '0' ORDER BY Name ASC;");
while($row = mysqli_fetch_array($q)){
	echo "<option value='" . $row["Name"] . "'>" . $row["Name"] . "</option>";
}
echo "</select><select name='voptionid'>";
echo "<option selected value='-'>-</option>";
echo "<option value='1'>Option 1</option>";
echo "<option value='2'>Option 2</option>";
echo "<option value='3'>Option 3</option>";
echo "<option value='4'>Option 4</option>";
echo "<option value='5'>Option 5</option>";
echo "</select><br><input type='submit' value='Vote'>";*/
echo "</form><br><br></td></tr>";
	
?>
