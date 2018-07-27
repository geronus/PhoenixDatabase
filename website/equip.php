<table class="input" cellspacing=0 style="width: 500px;">
    <tr>
        <th>Equipment Update</th>
    </tr>
    <tr>
        <td>
            <img src='/equip.png' align='right' />
            How to:
            <ol>
                <li>Copy marked area, and ONLY marked area (screenshot)</li>
                <li>Choose your name from the drop down</li>
                <li>Enter copied text</li>
                <li>Click "Submit"</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>
            <form action='index.php?x=equipsave' method='post'>
            Input:<br />
            <select name='name' style="width:100%; margin: 10px 0;">
                <option value='-' selected>--Member--</option>
            <?php 
                $q = mysqli_query($link, "SELECT * FROM Userliste WHERE Active LIKE '0' ORDER BY Name;");
                while($row = mysqli_fetch_array($q)){
	               echo "<option value='" . $row["Name"] . "'>" . $row["Name"] . "</option>";
                }
            ?>
            </select>
            <br />
            <textarea name='data' style="width: 100%; height: 200px; margin-bottom: 10px;" placeholder="Paste copied text in here..."></textarea><br />
            <input type='submit' value='Submit' />
            </form>
        </td>
    </tr>
</table>
