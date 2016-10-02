<?php

include 'clsUtility.php';

try
{
    $dbObj=new clsUtility();

    if($dbObj->checkEnvironment())
    {
        $strUserId="2";
        $strFriendId="4";
        $strMessage="Hello";
        $strStatus="UR";
    }
    else
    {
        $getJSON = @file_get_contents('php://input');
        $obj = json_decode($getJSON);

        $strUserId=$obj->{'UserId'};
        $strFriendId=$obj->{'FriendId'};
        $strMessage=$obj->{'Message'};
        $strStatus="UR";
    }

    $sql = "insert into usermessages (UserId,FriendId,Message,Status) "
        ."values(".$strUserId.",".$strFriendId.",'".$strMessage."','".$strStatus."')";

    ///echo $sql;

    $retId=$dbObj->insertDataToDatabase($sql);

    if($retId>0)
    {
        $arrRetValue = array('Message' => 'Success');

    }
    else
    {
        $arrRetValue = array('Message' => 'Failed');
    }

    $dbObj=null;
    $obj = null;

    echo json_encode($arrRetValue);
}
catch(PDOException $e)
{
    echo '{"error":{"text":'. $e->getMessage() .'}}';
}
?>