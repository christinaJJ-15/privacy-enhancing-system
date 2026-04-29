<?php
include './adminheader.php';
if(isset($_GET['delid'])) {
    mysqli_query($link, "delete from newdoctor where id='$_GET[delid]'");
    echo "<script>location.href='viewdoctor.php'</script>";
}
$rs = mysqli_query($link, "select * from newdoctor order by id") or die(mysqli_error($link));
echo "<div class='scrolldiv'><table class='report_tab' style='float:none;margin:auto;min-width:700px;'><thead><tr><th colspan='12'>DOCTORS LIST<tr><th>Name<th>Gender<th>Address<th>City<th>Mobile<th>Email<th>Qual<th>Dept<th>CertNo<th>Expr<th>DOB<th>Task</thead><tbody>";
                    while($r = mysqli_fetch_row($rs)) {
                        echo "<tr>";
                        foreach($r as $k=>$rr) {
                            if($k!=0 && $k!=7 && $k!=13)
                            echo "<td>$rr";
                        }
                        echo "<td><a href='viewdoctor.php?delid=$r[0]' onclick=\"javascript:return confirm('Are You Sure to Delete ?')\">Delete</a> | <a href='editdoctor.php?docid=$r[0]' onclick=\"javascript:return confirm('Are You Sure to Edit ?')\">Edit</a>";
                    }
echo "</tbody></table></div>";
mysqli_free_result($rs);
include './footer.php';
?>