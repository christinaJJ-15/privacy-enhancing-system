<?php
include './header.php';
if(!isset($_POST['submit'])) {
?>
<form name="f" action="index.php" method="post">
    <table class="center_tab">
	<thead>
	    <tr>
		<th colspan="2">LOGIN</th>
	    </tr>
	</thead>
	<tbody>
	    <tr>
		<th>UserId</th>
		<td><input type="text" name="userid" required autofocus></td>
	    </tr>
	    <tr>
		<th>Password</th>
		<td><input type="password" name="pwd" required></td>
	    </tr>
	    <tr>
		<th>Type</th>
		<td>
		    <select name="utype">
			<option value="user">User</option>
                        <option value="doctor">Doctor</option>
			<option value="admin">Admin</option>
		    </select>
		</td>
	    </tr>
	</tbody>
	<tfoot>
	    <tr>
		<td colspan="2" class="center">
		    <input type="submit" name="submit" value="Login">
		</td>
	    </tr>
	</tfoot>
    </table>
</form>
<?php
} else {
    extract($_POST);
    if(strcasecmp($utype, "admin")==0) {
	$result = mysqli_query($link, "select * from admin where userid='$userid' and pwd='$pwd'") or die(mysqli_error($link));
	if(mysqli_num_rows($result)>0) {
	    $_SESSION['adminuserid'] = $userid;
	    header("Location:adminhome.php");
	} else {
	    echo "<div class='center'>Invalid Userid/Password</div>";
	}
	mysqli_free_result($result);
    } else if(strcasecmp($utype, "user")==0) {
        include './aes.class.php';
        include './aesctr.class.php';
        $result1 = mysqli_query($link, "select skey from newpatient where userid='$userid'");
        if(mysqli_num_rows($result1)>0) {
        $row = mysqli_fetch_row($result1);
        if(strcasecmp($row[0], "")!=0) {            
            $skey = AesCtr::decrypt($row[0], 'abc', 256);
            $result = mysqli_query($link, "select pwd from newpatient where userid='$userid'");
            $row = mysqli_fetch_row($result);
            $dpwd = AesCtr::decrypt($row[0], $skey, 256);
            if(strcasecmp($pwd, $dpwd)==0) {
                $_SESSION['userid'] = $userid;
                header("Location:patienthome.php");
            } else {
                echo "<div class='center'>Invalid Userid/Password</div>";
            }
            mysqli_free_result($result);
        } else {
            $result = mysqli_query($link, "select * from newpatient where userid='$userid' and pwd='$pwd'") or die(mysqli_error($link));
                if(mysqli_num_rows($result)>0) {
                    $_SESSION['userid'] = $userid;
                    header("Location:patienthome.php");
                } else {
                    echo "<div class='center'>Invalid Userid/Password</div>";
                }
            mysqli_free_result($result);
        }
        } else {
            echo "<div class='center'>Invalid Userid...!</div>";
        }
        mysqli_free_result($result1);	
    }   else if(strcasecmp($utype, "doctor")==0) {
	$result = mysqli_query($link, "select * from newdoctor where userid='$userid' and pwd='$pwd'") or die(mysqli_error($link));
	if(mysqli_num_rows($result)>0) {
	    $_SESSION['doctorid'] = $userid;
	    header("Location:doctorhome.php");
	} else {
	    echo "<div class='center'>Invalid Userid/Password</div>";
	}
	mysqli_free_result($result);
    }
    echo "<div class='center'><a href='index.php'>Back</a></div>";
}
include './footer.php';
?>