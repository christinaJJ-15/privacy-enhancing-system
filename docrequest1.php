<?php
include './doctorheader.php';    
if(!isset($_POST['submit1'])) {
    $userid = $_GET['userid'];
?>
        <form name="f" action="docrequest1.php" method="post">
            <table class="center_tab" style="min-width: 400px;">
                <thead>
                    <tr>
                        <th colspan="2">PATIENT DISEASE INFO</th>
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
                        <th>Disease<br>Description</th>
                        <td><textarea name="disease" required autofocus></textarea></td>
                    </tr>
                    <tr>
                        <th>Sugar Level</th>
                        <td><input type="text" name="sugar" required></td>
                    </tr>
                    <tr>
                        <th>Blood Pressure</th>
                        <td><input type="text" name="bp" required></td>
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
    $disease = AesCtr::encrypt($disease, $skey, 256);
    $sugar = AesCtr::encrypt($sugar, $skey, 256);
    $bp = AesCtr::encrypt($bp, $skey, 256);
    mysqli_query($link, "insert into pdisease(doctorid,userid,dt,disease,sugar,bp) values('$_SESSION[doctorid]','$userid','$dt','$disease','$sugar','$bp')");
    $dqpath = $dq."/sample.dat";
    $fh = fopen($dqpath,"a");
    fwrite($fh,$dt."~".$disease."~".$sugar."~".$bp."\n");
    fclose($fh);
    echo "<div class='center'>Patient Disease Uploaded Successfully...!<br><br><a href='docrequest.php'>Back</a></div>";
}
include './footer.php';
?>