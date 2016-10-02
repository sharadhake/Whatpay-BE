<?php
include 'clsUtility.php';
try
{
    session_start();
    $session=session_id();
    $time=time();
    $time_check=$time-300;

    $dbObj=new clsUtility();

    if($dbObj->checkEnvironment())
    {
        $strUserId="2";
    }
    else
    {
        $getJSON = @file_get_contents('php://input');
        $obj = json_decode($getJSON);

        $strUserId=$obj->{'UserId'};
    }

    $sql="SELECT * FROM user_online WHERE UserId='$strUserId'";
    $result=$dbObj->getValuesAsResultSet($sql);

    $count=mysql_num_rows($result);
    if($count=="0")
    {
        $sql1="INSERT INTO user_online(UserId, session, time)VALUES($strUserId,'$session', '$time')";
        $result1=$dbObj->getValuesAsResultSet($sql1);
    }

    else
    {
        $sql2="UPDATE user_online SET time='$time' WHERE UserId= '$UserId'";
        $result2=$dbObj->getValuesAsResultSet($sql2);
    }

    /*$sql3="SELECT * FROM user_online";
    $result3=mysql_query($sql3);
    $count_user_online=mysql_num_rows($result3);
    echo "User online : $count_user_online ";*/

    // if over 5 minute, delete session
    $sql4="DELETE FROM user_online WHERE time<$time_check";
    $result4=$dbObj->getValuesAsResultSet($sql4);

    $arrRetValue = array('Message' => 'Success');

    $dbObj=null;
    $obj = null;

    echo json_encode($arrRetValue);
}
catch(PDOException $e)
{
    echo '{"error":{"text":'. $e->getMessage() .'}}';
}
?>