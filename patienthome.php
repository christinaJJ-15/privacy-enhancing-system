<?php
include './patientheader.php';
if(!isset($_POST['submit1'])) {
    include './aes.class.php';
    include './aesctr.class.php';
    $result = mysqli_query($link, "select name,gender,addr,city,mobile,pwd,dob,bgroup,skey from newpatient where userid='$_SESSION[userid]'");
    $row = mysqli_fetch_row($result);
    $row[8] = AesCtr::decrypt($row[8], 'abc', 256);
    if(strcasecmp($row[8],"")!=0) {        
        $row[0] = AesCtr::decrypt($row[0], $row[8], 256);
        $row[1] = AesCtr::decrypt($row[1], $row[8], 256);
        $row[2] = AesCtr::decrypt($row[2], $row[8], 256);
        $row[3] = AesCtr::decrypt($row[3], $row[8], 256);
        $row[4] = AesCtr::decrypt($row[4], $row[8], 256);
        $row[5] = AesCtr::decrypt($row[5], $row[8], 256);
        $row[6] = AesCtr::decrypt($row[6], $row[8], 256);
        $row[7] = AesCtr::decrypt($row[7], $row[8], 256);
    }
?>
        <form name="f" action="patienthome.php" method="post" onsubmit="return check()">
            <table class="center_tab">
                <thead>
                    <tr>
                        <th colspan="4">PROFILE</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Name</th>
                        <td><input type="text" name="name" required autofocus value="<?php echo $row[0]?>"></td>
                        <th>Blood Group</th>
                        <td><input type="text" name="bgroup" required value="<?php echo $row[7]?>"></td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td>
                            <input type="radio" name="gender" value="Male" checked>Male
                            <input type="radio" name="gender" value="Female">Female
                        </td>
                        <th></th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td><textarea name="addr" required><?php echo $row[2]?></textarea></td>
                        <th>Password</th>
                        <td><input type="password" name="pwd" required value="<?php echo $row[5]?>"></td>
                    </tr>
                    <tr>
                        <th>City</th>
                        <td><input type="text" name="city" required value="<?php echo $row[3]?>"></td>
                        <th>Confirm <br> Password</th>
                        <td><input type="password" name="cpwd" required value="<?php echo $row[5]?>"></td>
                    </tr>
                    <tr>
                        <th>Mobile</th>
                        <td><input type="text" name="mobile" required maxlength="10" value="<?php echo $row[4]?>"></td>
                        <th></th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>EMail (Userid)</th>
                        <td><input type="text" name="email" required value="<?php echo $_SESSION['userid'];?>" readonly></td>
                        <th></th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>DOB</th>
                        <td><input type="date" name="dob" required value="<?php echo $row[6]?>"></td>
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
    mysqli_free_result($result);
} else {
    extract($_POST);
    include './aes.class.php';
    include './aesctr.class.php';
    $result = mysqli_query($link, "select skey from newpatient where userid='$_SESSION[userid]'") or die(mysqli_error($link));
    if(mysqli_num_rows($result)>0) {
    $row = mysqli_fetch_row($result);
    $row[0] = AesCtr::decrypt($row[0], 'abc', 256);
        if(strcasecmp($row[0],"")!=0) {            
            $name = AesCtr::encrypt($name, $row[0], 256);
            $gender = AesCtr::encrypt($gender, $row[0], 256);
            $addr = AesCtr::encrypt($addr, $row[0], 256);
            $city = AesCtr::encrypt($city, $row[0], 256);
            $mobile = AesCtr::encrypt($mobile, $row[0], 256);
            $dob = AesCtr::encrypt($dob, $row[0], 256);
            $bgroup = AesCtr::encrypt($bgroup, $row[0], 256);
            $pwd = AesCtr::encrypt($pwd, $row[0], 256);
        }
        mysqli_query($link, "update newpatient set name='$name',gender='$gender',addr='$addr',city='$city',mobile='$mobile',pwd='$pwd',dob='$dob',bgroup='$bgroup' where userid='$email'");
    }
    mysqli_free_result($result);
    
    echo "<div class='center'>Profile Modified Successfully...!<br><br><a href='patienthome.php'>Back</a></div>";
}
?>
<script>
    function check() {
        var m = f.mobile.value
        var e = f.email.value
        
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
        if(f.pwd.value != f.cpwd.value) {
            alert("Confirm Password not Match...!")
            f.cpwd.focus();
            return false
        }
        return true
    }
</script>
<?php
include './footer.php';
?>