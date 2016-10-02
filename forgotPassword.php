<?php
include 'clsUtility.php';

try
{

    $dbObj=new clsUtility();

    if($dbObj->checkEnvironment())
    {
        $strEmailId="pradeep.motar@gmail.com";
    }
    else
    {
        $getJSON = @file_get_contents('php://input');
        $obj = json_decode($getJSON);

        $strEmailId=$obj->{'EmailId'};
    }

    $strQuery="select * from users where EmailId='".$strEmailId."'";

    if(($dbObj->checkDataExists($strQuery)))
    {
        $dataRow=$dbObj->getValuesFromDatabase($strQuery);
        $strName=$dataRow['Name'];
        $strEmailId=$dataRow['EmailId'];
        //$strPassword=base64_decode($dataRow['Password']);
        $strPassword=$dbObj->rand_string(6);

        $sql = "update users set Password='".base64_encode($strPassword)."', LoginFlag='0' where EmailId='".$strEmailId."'";

    	///echo $sql;

    	$dbObj->saveDataToDatabase($sql);
    
        $mail=$dbObj->sendForgotPasswordEmail($strName,$strEmailId, $strPassword);
        if($mail)
        {
            $arrRetValue = array('Message' => 'Success');
        }
        else
        {
            $arrRetValue = array('Message' => 'Failed');
        }

    }
    else
    {
        $arrRetValue = array('Message' => 'Not exist');
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