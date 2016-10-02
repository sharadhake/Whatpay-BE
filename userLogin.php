<?php
include 'clsUtility.php';

try 
{
    session_start();
    $session=session_id();
    $time=time();
    $time_check=$time-300; //SET TIME 5 Minute
    
    $dbObj=new clsUtility();

    if($dbObj->checkEnvironment())
    {
        $strEmailId="612345678";
        $strPassword="Sudhakar";
    }
    else
    {
        $getJSON = @file_get_contents('php://input');
        $obj = json_decode($getJSON);

        $strEmailId=$obj->{'EmailId'};
        $strPassword=$obj->{'Password'};
    }


   $strQuery="select * from users where Mobile='".$strEmailId."' and AccessID='".$strPassword."'";

    if(($dbObj->checkDataExists($strQuery)))
    {
        $dataRow=$dbObj->getValuesFromDatabase($strQuery);
        $strUserId=$dataRow['UserId'];
        $strUserMobile=$dataRow['Mobile'];
        $strUserName=$dataRow['UserName'];
        
        $arrRetValue = array('Message' => 'Success','UserId' => $strUserId,'UserName' => $strUserName);

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