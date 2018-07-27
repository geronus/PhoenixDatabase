<?php

echo "<A HREF='admin.php'>Back to Index</A><br><br>";
echo "<form action='/admin.php?x=guildsave' method='post'>";
echo "<textarea name='eingabe' cols'40' rows='10'></textarea></br>";
echo "<input type='submit' value='Senden'></form>";
echo "<br><br>How to:<br><br>1. Go to Guild Member list<br>2. Open ALL Guild Members<br>3. Copy all (not Strg+A, just from first name to \"[Quit Guild]\")<br>4. Input copied text <br>5. Send<br><br>Notice: The list is just about at the max length of this form. If you copy too much, the last members could be cut of. Check for that!";
echo "</body>";
?>
