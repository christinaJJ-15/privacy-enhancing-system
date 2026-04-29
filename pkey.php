<?php
include './patientheader.php';
if(isset($_GET['gp'])) {
    include './aes.class.php';
    include './aesctr.class.php';
    $A = range('A', 'Z');
    $a = range('a','z');
    $d = range(0,9);
    $key = $A[rand(0, 25)].$d[rand(0,9)].$a[rand(0,25)].$A[rand(0,25)];
    $key1 = AesCtr::encrypt($key, 'abc', 256);
    mysqli_query($link, "update newpatient set skey='$key1',accept='accept' where userid='$_SESSION[userid]'");
    $result = mysqli_query($link, "select name,gender,addr,city,mobile,pwd,dob,bgroup,skey from newpatient where userid='$_SESSION[userid]'");
    $row = mysqli_fetch_row($result);
    if(strcasecmp($row[8],"")!=0) {
        $row[0] = AesCtr::encrypt($row[0], $key, 256);
        $row[1] = AesCtr::encrypt($row[1], $key, 256);
        $row[2] = AesCtr::encrypt($row[2], $key, 256);
        $row[3] = AesCtr::encrypt($row[3], $key, 256);
        $row[4] = AesCtr::encrypt($row[4], $key, 256);
        $row[5] = AesCtr::encrypt($row[5], $key, 256);
        $row[6] = AesCtr::encrypt($row[6], $key, 256);
        $row[7] = AesCtr::encrypt($row[7], $key, 256);
    }
    mysqli_query($link, "update newpatient set name='$row[0]',gender='$row[1]',addr='$row[2]',city='$row[3]',mobile='$row[4]',pwd='$row[5]',dob='$row[6]',bgroup='$row[7]' where userid='$_SESSION[userid]'");
    echo "<div class='center'>Your Key Generated Successfully...!</div>";
} else {
$result = mysqli_query($link, "select skey from newpatient where userid='$_SESSION[userid]'");
    $row = mysqli_fetch_row($result);
    if(strcasecmp($row[0], "")==0) {
        echo "<div class='center'><a href='pkey.php?gp' style='border:solid thin;padding:10px;'>Generate Key</a></div>";
    } else {
        echo "<div class='center'>You have Generated your Key...!</div>";
    }
mysqli_free_result($result);
}
include './footer.php';
?>