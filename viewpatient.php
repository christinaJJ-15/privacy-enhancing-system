<?php
include './doctorheader.php';
if(isset($_GET['delid'])) {
    mysqli_query($link, "delete from newdoctor where id='$_GET[delid]'");
    echo "<script>location.href='viewdoctor.php'</script>";
}
$rs = mysqli_query($link, "select name,userid from newpatient where doctorid='$_SESSION[doctorid]' and accept='pending' order by id") or die(mysqli_error($link));
echo "<div class='scrolldiv'><table class='report_tab' style='float:none;margin:auto;min-width:700px;'><thead><tr><th colspan='3'>UPLOAD PENDING PATIENT LIST<tr><th>Name<th>Email<th>Task</thead><tbody>";
                    while($r = mysqli_fetch_row($rs)) {
                        echo "<tr>";
                        foreach($r as $k=>$rr) {                            
                            echo "<td>$rr";
                        }
                        echo "<td><a href='viewpatient.php?delid=$r[1]' onclick=\"javascript:return confirm('Are You Sure to Delete ?')\">Delete</a>";
                    }
echo "</tbody></table></div><hr>";
mysqli_free_result($rs);

$rs = mysqli_query($link, "select name,userid from newpatient where doctorid='$_SESSION[doctorid]' and accept!='pending' order by id") or die(mysqli_error($link));
echo "<div class='scrolldiv'><table class='report_tab' style='float:none;margin:auto;min-width:700px;'><thead><tr><th colspan='3'>UPLOADED PATIENT LIST<tr><th>Name<th>Email<th>Task</thead><tbody>";
                    while($r = mysqli_fetch_row($rs)) {
                        echo "<tr>";
                        foreach($r as $k=>$rr) {                            
                            echo "<td>$rr";
                        }
                        echo "<td><a href='viewpatient.php?delid=$r[1]' onclick=\"javascript:return confirm('Are You Sure to Delete ?')\">Delete</a>";
                    }
echo "</tbody></table></div>";
mysqli_free_result($rs);
include './footer.php';
?>