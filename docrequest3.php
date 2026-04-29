<?php
include './doctorheader.php'; 
    $userid = $_GET['userid'];
    include './aes.class.php';
    include './aesctr.class.php';
    $result = mysqli_query($link, "select skey from newpatient where userid='$userid'");
    $row = mysqli_fetch_row($result);
    mysqli_free_result($result);
    $skey = AesCtr::decrypt($row[0], 'abc', 256);
$rs = mysqli_query($link, "select doctorid,dt,disease,sugar,bp from pdisease where userid='$userid' order by id") or die(mysqli_error($link));
echo "<div class='scrolldiv'><table class='report_tab' style='float:none;margin:auto;min-width:700px;'><thead><tr><th colspan='5'>PATIENT DISEASE INFO<tr><th>Doctor Id<th>Date<th>Disease<th>Sugar<th>BP</thead><tbody>";
    while($r = mysqli_fetch_row($rs)) {
        echo "<tr>";
        echo "<td>$r[0]";
        echo "<td>".AesCtr::decrypt($r[1], $skey, 256);
        echo "<td>".AesCtr::decrypt($r[2], $skey, 256);
        echo "<td>".AesCtr::decrypt($r[3], $skey, 256);
        echo "<td>".AesCtr::decrypt($r[4], $skey, 256);
    }
echo "</tbody></table></div><hr>";
mysqli_free_result($rs);

$rs = mysqli_query($link, "select doctorid,dt,prescription from prescrip where userid='$userid' order by id") or die(mysqli_error($link));
echo "<div class='scrolldiv'><table class='report_tab' style='float:none;margin:auto;min-width:700px;'><thead><tr><th colspan='3'>PATIENT PRESCRIPTION INFO<tr><th>Doctor Id<th>Date<th>Prescription</thead><tbody>";
    while($r = mysqli_fetch_row($rs)) {
        echo "<tr>";
        echo "<td>$r[0]";
        echo "<td>".AesCtr::decrypt($r[1], $skey, 256);
        echo "<td>".AesCtr::decrypt($r[2], $skey, 256);
    }
echo "</tbody></table></div><hr>";
mysqli_free_result($rs);

$rs = mysqli_query($link, "select doctorid,dt,fname from scan where userid='$userid' order by id") or die(mysqli_error($link));
echo "<div class='scrolldiv'><table class='report_tab' style='float:none;margin:auto;min-width:700px;'><thead><tr><th colspan='3'>PATIENT SCAN INFO<tr><th>Doctor Id<th>Date<th>Scan</thead><tbody>";
    while($r = mysqli_fetch_row($rs)) {
        echo "<tr>";
        echo "<td>$r[0]";
        echo "<td>".AesCtr::decrypt($r[1], $skey, 256);
        echo "<td><a href='dwnld.php?fn=".AesCtr::decrypt($r[2], $skey, 256)."'>Download</a>";
    }
echo "</tbody></table></div>";
mysqli_free_result($rs);
include './footer.php';
?>