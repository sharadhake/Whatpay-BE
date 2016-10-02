<?php
include 'clsUtility.php';

try
{

    $dbObj=new clsUtility();

    if($dbObj->checkEnvironment())
    {
        $strUserId="2";
        $strFriendId="4";
        $strStatus="R";
    }
    else
    {
        $getJSON = @file_get_contents('php://input');
        $obj = json_decode($getJSON);

        $strUserId=$obj->{'UserId'};
        $strFriendId=$obj->{'FriendId'};
        $strStatus="R";
    }


    $sql = "update usermessages set status='".$strStatus."' where UserId=".$strUserId." and FriendId=".$strFriendId;

    ///echo $sql;

    $dbObj->saveDataToDatabase($sql);

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