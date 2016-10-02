<?php

include 'clsUtility.php';
try
{

    $dbObj=new clsUtility();

    if($dbObj->checkEnvironment())
    {
        $strUserId="4";
    }
    else
    {
        $getJSON = @file_get_contents('php://input');
        $obj = json_decode($getJSON);

        $strUserId=$obj->{'UserId'};
    }

    $return_arr = array();
    $strFrndQuery="SELECT * FROM users a, friends b WHERE b.Status ='0' AND a.userid = b.userid and b.FriendId=".$strUserId;


    if(($dbObj->checkDataExists($strFrndQuery)))
    {

        $drFrndDtls=$dbObj->getValuesAsResultSet($strFrndQuery);
        while ($rowFrnd = mysql_fetch_array($drFrndDtls, MYSQL_ASSOC))
        {
            $row_array['FriendId'] = $rowFrnd['UserId'];
            $row_array['Name'] = $rowFrnd['Name'];
            $row_array['MessageType'] = "1";

            array_push($return_arr,$row_array);
        }


    }


    $strMsgQuery="SELECT * FROM users a, usermessages b WHERE b.Status ='UR' AND a.userid = b.userid and b.FriendId=".$strUserId;

    if(($dbObj->checkDataExists($strMsgQuery)))
    {

        $drMsgDtls=$dbObj->getValuesAsResultSet($strMsgQuery);
        while ($rowMsg = mysql_fetch_array($drMsgDtls, MYSQL_ASSOC))
        {
            $row_array['FriendId'] = $rowMsg['UserId'];
            $row_array['Name'] = $rowMsg['Name'];
            $row_array['MessageType'] = "2";

            array_push($return_arr,$row_array);
        }


    }

    if($return_arr==null)
    {
        $row_array['Message'] = "No Result";
        array_push($return_arr,$row_array);
    }
    echo '{ "Request":'.json_encode($return_arr).'}';

    $dbObj=null;
    $obj = null;

}
catch(PDOException $e)
{
    echo '{"error":{"text":'. $e->getMessage() .'}}';
}
?>