<?php


class clsUtility
{

	function getValuesFromDatabase($strQuery)
	{
		try
		{
			include 'config.php';
				
			$con = mysql_connect($dbhost,$dbuser,$dbpass);
		
			if (!$con)
			  {
				die('Could not connect: ' . mysql_error());
			  }
			
			mysql_select_db($dbname, $con);
							
			$defaultResult = mysql_query($strQuery);
			$dataRow = mysql_fetch_array($defaultResult);
			return $dataRow;
			mysql_close($con);
		}
		catch(Exception $e)
		{
			echo 'Message: ' .$e->getMessage();
		}
	}
	
	function getValuesAsResultSet($strQuery)
	{
		try
		{
			include 'config.php';
			
			$con = mysql_connect($dbhost,$dbuser,$dbpass);
		
			if (!$con)
			  {
				die('Could not connect: ' . mysql_error());
			  }
			
			mysql_select_db($dbname, $con);
							
			$defaultResult = mysql_query($strQuery);
			
			return $defaultResult;
			mysql_close($con);
		}
		catch(Exception $e)
		{
			echo 'Message: ' .$e->getMessage();
		}
	}
	
	function saveDataToDatabase($strInsertQuery)
	{
		try
		{
			include 'config.php';
			
			$con = mysql_connect($dbhost,$dbuser,$dbpass);
			if (!$con)
			  {
			  die('Could not connect: ' . mysql_error());
			  }
			
			mysql_select_db($dbname, $con);
			
			mysql_query($strInsertQuery);
					
			mysql_close($con);
		}
		catch(Exception $e)
		{
			echo 'Message: ' .$e->getMessage();
		}
	}
	
	function insertDataToDatabase($strInsertQuery)
	{
		try
		{
			include 'config.php';
			
			$con = mysql_connect($dbhost,$dbuser,$dbpass);
			if (!$con)
			  {
			  die('Could not connect: ' . mysql_error());
			  }
			
			mysql_select_db($dbname, $con);
			
			mysql_query($strInsertQuery);
			
			$id = mysql_insert_id(); 
					
			mysql_close($con);
			
			return $id;
		}
		catch(Exception $e)
		{
			echo 'Message: ' .$e->getMessage();
		}
	}
	
	function checkDataExists($strQuery)
	{
		try
		{
			include 'config.php';
			
			$con = mysql_connect($dbhost,$dbuser,$dbpass);
		
			if (!$con)
			  {
				die('Could not connect: ' . mysql_error());
			  }
			
			mysql_select_db($dbname, $con);
							
			$defaultResult = mysql_query($strQuery);
			
			$rowCount=mysql_num_rows($defaultResult);
			
			if($rowCount<=0)
				return false;
			else
				return true;
				
			mysql_close($con);
		}
		catch(Exception $e)
		{
			echo 'Message: ' .$e->getMessage();
		}
	}
	
	function sendEmail($userName,$userEmailId , $strPassword)
	{
		try
		{
			include 'config.php';
						
			// Who the email is from
			$email_from = "noreply@hookit.com";
		
			// The Subject of the email
			$email_subject = "User Password";
			
			// Message that the email has in it
			$email_message="Dear ".$userName.",<br/><br/>Please use User Name : ".$userEmailId." and password : ". $strPassword ." for login. Thank you for registration.<br/><br/>Thanks,<br/><br/>Hookit Team.";
		
			// Who the email is too
			$email_to = $userEmailId; 
			
			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headers .= "From:" . $email_from;
			
			mail($email_to,$email_subject,$email_message,$headers);
			
		}
		catch(Exception $e)
		{
			return false;
			echo 'Message: ' .$e->getMessage();
		}
		
		return true;
	}

   	function checkEnvironment()
    	{
         	include 'config.php';
         	return $strLocalhost;

    	}
    
    	function rand_string( $length ) 
    	{
        	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		return substr(str_shuffle($chars),0,$length);
    	}
    
	function sendForgotPasswordEmail($userName,$userEmailId , $strPassword)
	{
		try
		{
			include 'config.php';
						
			// Who the email is from
			$email_from = "noreply@hookit.com";
		
			// The Subject of the email
			$email_subject = "Password Reset";
			
			// Message that the email has in it
			$email_message="Dear ".$userName.",<br/><br/>Your password has been reset. Please use User Name : ".$userEmailId." and password : ". $strPassword ." for login.<br/><br/>Thanks,<br/><br/>Hookit Team.";
		
			// Who the email is too
			$email_to = $userEmailId; 
			
			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headers .= "From:" . $email_from;
			
			mail($email_to,$email_subject,$email_message,$headers);
			
		}
		catch(Exception $e)
		{
			return false;
			echo 'Message: ' .$e->getMessage();
		}
		
		return true;
	}
}

?>