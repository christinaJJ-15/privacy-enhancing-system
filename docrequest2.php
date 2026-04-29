<?php
include './doctorheader.php';    
if(!isset($_POST['submit1'])) {
    $userid = $_GET['userid'];
?>
        <form name="f" action="docrequest2.php" method="post">
            <table class="center_tab" style="min-width: 400px;">
                <thead>
                    <tr>
                        <th colspan="2">PATIENT PRESCRIPTION</th>
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
                        <th>Prescription</th>
                        <td><textarea name="prescription" required autofocus></textarea></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="center">
                            <input type="submit" name="submit1" value="Create">
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
    $result = mysqli_query($link, "select skey from newpatient where userid='$userid'");
    $row = mysqli_fetch_row($result);
    mysqli_free_result($result);
    $skey = AesCtr::decrypt($row[0], 'abc', 256);
    $dt = AesCtr::encrypt($dt, $skey, 256);
    $prescription = AesCtr::encrypt($prescription, $skey, 256);
    mysqli_query($link, "insert into prescrip(doctorid,userid,dt,prescription) values('$_SESSION[doctorid]','$userid','$dt','$prescription')");
    $dqpath = $dq."/pres.dat";
    $fh = fopen($dqpath,"a");
    fwrite($fh,$dt."~".$prescription."\n");
    fclose($fh);
    echo "<div class='center'>Prescription Uploaded Successfully...!<br><br><a href='docrequest.php'>Back</a></div>";
}
include './footer.php';
?>