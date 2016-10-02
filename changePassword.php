<?php
include 'clsUtility.php';

try
{

    $dbObj=new clsUtility();

    if($dbObj->checkEnvironment())
    {
        $strUserId="36";
        $strPassword="Pass@123";
    }
    else
    {
        $getJSON = @file_get_contents('php://input');
        $obj = json_decode($getJSON);

        $strUserId=$obj->{'UserId'};
        $strPassword=$obj->{'Password'};
    }


    $sql = "update users set Password='".base64_encode($strPassword)."', LoginFlag='1' where UserId=".$strUserId;

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