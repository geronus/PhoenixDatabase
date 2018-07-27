<table class="input" cellspacing=0 style="width: 500px;">
    <tr>
        <th>Token Boosts Update</th>
    </tr>
    <tr>
        <td>
            How to:
            <ol>
                <li>Open Permanent Boosts</li>
                <li>Copy from "You have x tokens." to "kind of thing." at the bottom.</li>
                <li>Choose your name from the drop down</li>
                <li>Enter copied text</li>
                <li>Click "Submit"</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>
            <form action='index.php?x=boostsave' method='post'>
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
            <textarea name='eingabe' style="width: 100%; height: 200px; margin-bottom: 10px;" placeholder="Paste copied text in here..."></textarea><br />
            <input type='submit' value='Submit' />
            </form>
        </td>
    </tr>
</table>