<?php
include './doctorheader.php';
if(isset($_GET['pid'])) {
    $b = mysqli_query($link, "insert into docrequest(doctorid,userid) values('$_SESSION[doctorid]','$_GET[pid]')");
    if($b) {
        echo "<div class='center'>Request Send Successfully...!<br><a href='docrequest.php'>Back</a></div>";
    } else {
        echo "<div class='center'>Request Already Send...!<br><a href='docrequest.php'>Back</a></div>";
    }
}
if(isset($_GET['userid'])) {
    include './aes.class.php';
    include './aesctr.class.php';
    $userid=$_GET['userid'];
    $result = mysqli_query($link, "select skey from newpatient where userid='$userid'");
    $row = mysqli_fetch_row($result);
    $skey = AesCtr::decrypt($row[0], 'abc', 256);
    mysqli_free_result($result);
    echo "<script>alert('Secret Key is : $skey')</script>";
}
$rs = mysqli_query($link, "select name,userid from newpatient where accept!='pending' and userid not in(select userid from docrequest where doctorid='$_SESSION[doctorid]') order by id") or die(mysqli_error($link));
echo "<div class='scrolldiv'><table class='report_tab' style='float:none;margin:auto;min-width:700px;'><thead><tr><th colspan='3'>KEY REQUEST TO PATIENT<tr><th>Name<th>Email<th>Task</thead><tbody>";
                    while($r = mysqli_fetch_row($rs)) {
                        echo "<tr>";
                        foreach($r as $k=>$rr) {                            
                            echo "<td>$rr";
                        }
                        echo "<td><a href='docrequest.php?pid=$r[1]' onclick=\"javascript:return confirm('Are You Sure to Send Request ?')\">Send Request</a>";
                    }
echo "</tbody></table></div><hr>";
mysqli_free_result($rs);

$rs = mysqli_query($link, "select n.name,d.userid,accstatus from docrequest d,newpatient n where d.doctorid='$_SESSION[doctorid]' and d.userid=n.userid") or die(mysqli_error($link));
echo "<div class='scrolldiv'><table class='report_tab' style='float:none;margin:auto;min-width:700px;'><thead><tr><th colspan='4'>KEY REQUEST STATUS<tr><th>Name<th>Email<th>Status<th>Task</thead><tbody>";
                    while($r = mysqli_fetch_row($rs)) {
                        echo "<tr>";
                        foreach($r as $k=>$rr) {                            
                            echo "<td>$rr";
                        }
                        if(strcasecmp($r[2], "pending")!=0)
                        echo "<td><a href='docrequest1.php?userid=$r[1]' onclick=\"javascript:return confirm('Are You Sure to Upload Disease ?')\">Disease</a> | <a href='docrequest2.php?userid=$r[1]' onclick=\"javascript:return confirm('Are You Sure to Upload Prescription ?')\">Prescription</a> | <a href='scan.php?userid=$r[1]' onclick=\"javascript:return confirm('Are You Sure to Upload Scan ?')\">Scan</a> | <a href='docrequest3.php?userid=$r[1]' onclick=\"javascript:return confirm('Are You Sure to View ?')\">View</a>";
                        else
                            echo "<td>Pending";
                    }
echo "</tbody></table></div>";
mysqli_free_result($rs);
include './footer.php';
?>