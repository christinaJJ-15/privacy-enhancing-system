<?php
include './adminheader.php';
if(!isset($_POST['submit1'])) {
    $docid = $_GET['docid'];
    $result = mysqli_query($link, "select * from newdoctor where id='$docid'");
    $row = mysqli_fetch_array($result);
    mysqli_free_result($result);
?>
        <form name="f" action="editdoctor.php" method="post" onsubmit="return check()">
            <table class="center_tab">
                <thead>
                    <tr>
                        <th colspan="4">EDIT DOCTOR</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Name</th>
                        <td><input type="text" name="name" required autofocus value="<?php echo $row['name'];?>"></td>
                        <th>Qualification</th>
                        <td><input type="text" name="qual" required value="<?php echo $row['qual'];?>"></td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td>
                            <input type="radio" name="gender" value="Male" checked>Male
                            <input type="radio" name="gender" value="Female">Female
                        </td>
                        <th>Specialized In</th>
                        <td><input type="text" name="special" required value="<?php echo $row['special'];?>"></td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td><textarea name="addr" required><?php echo $row['addr'];?></textarea></td>
                        <th>Certificate No.</th>
                        <td><input type="text" name="certno" required value="<?php echo $row['certno'];?>"></td>
                    </tr>
                    <tr>
                        <th>City</th>
                        <td><input type="text" name="city" required value="<?php echo $row['city'];?>"></td>
                        <th>Experience (Years)</th>
                        <td><input type="text" name="expr" pattern="\d+" required value="<?php echo $row['expr'];?>"></td>
                    </tr>
                    <tr>
                        <th>Mobile</th>
                        <td><input type="text" name="mobile" required maxlength="10" value="<?php echo $row['mobile'];?>"></td>
                        <th>DOB</th>
                        <td><input type="date" name="dob" required value="<?php echo $row['dob'];?>"></td>
                    </tr>
                    <tr>
                        <th>EMail (Userid)</th>
                        <td><input type="text" name="email" required value="<?php echo $row['userid'];?>" readonly></td>
                        <th></th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Password</th>
                        <td><input type="password" name="pwd" required value="<?php echo $row['pwd'];?>"></td>
                        <th></th>
                        <td></td>
                    </tr>                    
                    <tr>
                        <th>Confirm Pwd</th>
                        <td><input type="password" name="cpwd" required value="<?php echo $row['pwd'];?>"></td>
                        <th></th>
                        <td></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="center">
                            <input type="submit" name="submit1" value="Update">
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
<?php
} else {
    extract($_POST);
    mysqli_query($link, "update newdoctor set name='$name',gender='$gender',addr='$addr',city='$city',mobile='$mobile',pwd='$pwd',qual='$qual',special='$special',certno='$certno',expr='$expr',dob='$dob' where userid='$email'");
    echo "<div class='center'>Doctor Info Modified Successfully...!<br><a href='viewdoctor.php'>Back</a></div>";
}
?>
<script>
    function check() {
        var m = f.mobile.value
        var e = f.email.value
        var pw = f.pwd.value
        var cp = f.cpwd.value
        
        var mp = /^[987]\d{9}$/
        var ep = /^\w+\.{0,1}\w+\@\w+\.([a-z]{3}|[a-z]{2}\.[a-z]{2}){1}$/
        
        if(!m.match(mp)) {
            alert("Invalid Mobile Number")
            f.mobile.focus()
            return false
        }
        if(!e.match(ep)) {
            alert("Invalid EMail Id")
            f.email.focus()
            return false
        }
        if(pw!=cp) {
            alert("Confirm Password not Match")
            f.cpwd.focus()
            return false
        }
        return true
    }
</script>
<?php
include './footer.php';
?>