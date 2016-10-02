<?php

include 'clsUtility.php';

try
{


    $dbObj=new clsUtility();

    if($dbObj->checkEnvironment())
    {
        $strUserId="2";
        $strFriendId="4";
    }
    else
    {
        $getJSON = @file_get_contents('php://input');
        $obj = json_decode($getJSON);

        $strUserId=$obj->{'UserId'};
        $strFriendId=$obj->{'FriendId'};
    }

    $sql = "insert into friends(UserId,FriendId,Status) "
        ."values(".$strUserId.",".$strFriendId.",'0')";

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