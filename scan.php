<?php
include './doctorheader.php';    
if(!isset($_POST['submit1'])) {
    $userid = $_GET['userid'];
?>
        <form name="f" action="scan.php" method="post" enctype="multipart/form-data">
            <table class="center_tab" style="min-width: 400px;">
                <thead>
                    <tr>
                        <th colspan="2">PATIENT SCAN</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Patient Id</th>
                        <td><input type="text" name="userid" value="<?php echo $userid;?>" required readonly></td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <td><input type="text" name="dt" value="<?php echo date('Y-m-d',time());?>" required readonly></td>
                    </tr>
                    <tr>
                        <th>Scan</th>
                        <td><input type="file" name="ff" accept="image/*" required></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="center">
                            <input type="submit" name="submit1" value="Upload">
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
<?php
} else {
    extract($_POST);
    include './aes.class.php';
    include './aesctr.class.php';
    if(is_uploaded_file($_FILES['ff']['tmp_name'])) {
        $fname = "uploads/".time().$_FILES['ff']['name'];
        $ofname = $fname;
    $result = mysqli_query($link, "select skey from newpatient where userid='$userid'");
    $row = mysqli_fetch_row($result);
    mysqli_free_result($result);
    $skey = AesCtr::decrypt($row[0], 'abc', 256);
    $dt = AesCtr::encrypt($dt, $skey, 256);
    $fname = AesCtr::encrypt($fname, $skey, 256);
    move_uploaded_file($_FILES['ff']['tmp_name'], $ofname) or die("<div class='center'>Cannot Move Image...!<br><br><a href='docrequest.php'>Back</a></div>");
    mysqli_query($link, "insert into scan(doctorid,userid,dt,fname) values('$_SESSION[doctorid]','$userid','$dt','$fname')");
    $fh = fopen($ofname,'r');
    $c = fread($fh, filesize($ofname));
    fclose($fh);
    $dqpath = $dq."/sc.dat";
    $fh = fopen($dqpath, "a");
    fwrite($fh, $c);
    fclose($fh);
    echo "<div class='center'>Scan Uploaded Successfully...!<br><br><a href='docrequest.php'>Back</a></div>";
    } else {
        echo "<div class='center'>Scan Not Uploaded...!<br><br><a href='docrequest.php'>Back</a></div>";
    }
}
include './footer.php';
?>