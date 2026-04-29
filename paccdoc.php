<?php
include './patientheader.php';
if(isset($_GET['doctorid'])) {
    $doctorid = $_GET['doctorid'];
    mysqli_query($link, "update docrequest set accstatus='accept' where userid='$_SESSION[userid]' and doctorid='$doctorid'");
    echo "<div class='center'>Accepted Successfully...!<br><a href='paccdoc.php'>Back</a></div>";
} else {
$rs = mysqli_query($link, "select d.doctorid,n.name,accstatus from docrequest d,newdoctor n where d.userid='$_SESSION[userid]' and d.doctorid=n.userid and accstatus='pending'") or die(mysqli_error($link));
echo "<div class='scrolldiv'><table class='report_tab' style='float:none;margin:auto;min-width:700px;'><thead><tr><th colspan='4'>RECEIVED KEY REQUEST<tr><th>Email<th>Name<th>Status<th>Task</thead><tbody>";
                    while($r = mysqli_fetch_row($rs)) {
                        echo "<tr>";
                        foreach($r as $k=>$rr) {                            
                            echo "<td>$rr";
                        }
                        if(strcasecmp($r[2], "pending")==0)
                        echo "<td><a href='paccdoc.php?doctorid=$r[0]' onclick=\"javascript:return confirm('Are You Sure to Accept Request ?')\">Accept Request</a>";
                        else
                            echo "<td>";
                    }
echo "</tbody></table></div>";
mysqli_free_result($rs);
}
include './footer.php';
?>