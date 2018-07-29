<?php
include_once 'user_db.php';
use PHPMailer\PHPMailer\PHPMailer;

require '/phpmailer/Exception.php';
require '/phpmailer/PHPMailer.php';
require '/phpmailer/SMTP.php';

class UserManager
{
	public static function bulk_email()
	{
		$mail = new PHPMailer();


		//Tell PHPMailer to use SMTP
		$mail->isSMTP();
		//Enable SMTP debugging
		// 0 = off (for production use)
		// 1 = client messages
		// 2 = client and server messages
		$mail->SMTPDebug = 2;
		//Set the hostname of the mail server
		$mail->Host = gethostbyname('smtp.gmail.com');
		// use
		// $mail->Host = gethostbyname('smtp.gmail.com');
		// if your network does not support SMTP over IPv6
		//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
		$mail->Port = 587;
		//Set the encryption system to use - ssl (deprecated) or tls
		$mail->SMTPSecure = 'tls';
		//Whether to use SMTP authentication
		$mail->SMTPAuth = true;
		//Username to use for SMTP authentication - use full email address for gmail
		$mail->Username = "ongtengcheong1985@gmail.com";
		//Password to use for SMTP authentication
		$mail->Password = "kenobi666999";




		$mail->From = 'leekuanyew@gmail.com';
		$mail->FromName = 'Joker Binks';
		$mail->addAddress('kohgaywee1985@gmail.com', 'GW Koh');     // Add a recipient
		//$mail->addAddress('ellen@example.com');               // Name is optional
		
		$conn = UserDB::connect_mysql();

		if ($conn->connect_error) {    die("Connection failed: " . $conn->connect_error);}
		$sql = "SELECT fullname,email FROM cp_tb_user where is_admin=false and receving_email=true";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) 
		{
			// output data of each row
			while($row = $result->fetch_assoc()) 
			{
				$fullname=$row["fullname"];
				$email=$row["email"];
				$mail->addCC($fullname,$email);
			}	
			
		} 
		else { echo "0 results";}
		$conn->close();
		$mail->addCC('kohgaywee2015@gmail.com', 'GW Koh');


		$mail->addReplyTo('jarjarholly@gmail.com', 'Ali Baba');
		//$mail->addCC('cc@example.com');
		//$mail->addBCC('bcc@example.com');

		//$mail->addAttachment('');         // Add attachments
		//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
		$mail->isHTML(true);                                  // Set email format to HTML

		$mail->Subject = $_POST["mailtitle"];
		$mail->Body    = $_POST["mailmessage"];

		if(!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
			echo 'Message has been sent';
		}
	}
	
	public static function update_mail_subscriber()
	{
		if(isset($_POST["submitted"]))
		{
			if($_POST["submitted"] == 1)
			{
			
				$conn = UserDB::connect_mysql();
				if ($conn->connect_error) {    die("Connection failed: " . $conn->connect_error);}
				$sql = "SELECT user_id FROM cp_tb_user where is_admin='false'";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) 
				{
					// output data of each row
					while($row = $result->fetch_assoc()) 
					{
						$num="is_blocked_".$row["user_id"];
						$numid=$row["user_id"];
						//echo $num." ";
						if (($_POST["{$num}"])=='true')
						{						
							//echo " is receving email: ";
							$sql2="update cp_tb_user set receving_email=1 where user_id='$numid'";
							if ($conn->query($sql2)===true)
							{
								//echo "Record updated successfully</br>";
							}
							else
							{
								//echo "Error updated record</br>";
							}
						}
						else
						{
							//echo " is ot receivng email: ";
							$sql2="update cp_tb_user set receving_email=0 where user_id='$numid'";
							if ($conn->query($sql2)===true)
							{
								//echo "Record updated successfully</br>";
							}
							else
							{
								//echo "Error updated record</br>";
							}
						}
						echo "</br>";
					}
					
					
				} 
				else { echo "0 results";}
				$conn->close();
			}
		}
		

		$conn=UserDB::connect_mysql();
		if ($conn->connect_error) {    die("Connection failed: " . $conn->connect_error);}
		$sql = "SELECT user_id,username,fullname,email,receving_email FROM cp_tb_user where is_admin='false'";
		$result = $conn->query($sql);
		if($result->num_rows==0)
		{
			echo "No results</br>";
			$conn->close();
			return false;
		}
		
		echo "<form action=\"\" method=\"post\">";
		echo "<table>";
		while($row = $result->fetch_assoc()) 
		{
			echo "<tr>";
			echo "<td>Username: " . $row["username"]. " </td><td>Full Name: " . $row["fullname"]." </td><td>Email: " . $row["email"]." </td><td> Mailing List: ". $row["receving_email"]."</td><td>";
			if($row["receving_email"])
			{
				echo " <input type=\"radio\" name=\"is_blocked_".$row["user_id"]."\" value=\"true\" checked> True";
				echo "<input type=\"radio\" name=\"is_blocked_".$row["user_id"]."\" value=\"false\"> False";
			}
			else
			{
				echo " <input type=\"radio\" name=\"is_blocked_".$row["user_id"]."\" value=\"true\" checked> True";
				echo "<input type=\"radio\" name=\"is_blocked_".$row["user_id"]."\" value=\"false\"checked> False";
			}
			echo "</td>";
			echo"</tr>";
			
		}
		echo "</table>";
		echo "<input name=\"submitted\" type=\"hidden\" value=\"1\" />";
		echo "<input type=\"submit\"  value=\"Update\" /></br>";
		echo "</form>";
		$result->free();
		$conn->close();
		
		return true;
	}
	
	public static function editprofile($input_username)
	{
		$dbconnection=UserDB::connect_mysql();
		if ($dbconnection->connect_error) {    die("Connection failed: " . $dbconnection->connect_error);}
		$sql = "SELECT user_id,username,fullname,email FROM cp_tb_user where username='$username'";
		$result = $dbconnection->query($sql);
		$dbconnection->close();
		
		return true;
	}
	/*
	**/
	public static function authenticateuserforadmin($input_username,$input_password)
	{
		$dbconnection=UserDB::connect_mysql();
		if ($dbconnection->connect_error) {    die("Connection failed: " . $dbconnection->connect_error);}
		$sql = "SELECT user_id,username,fullname,email,contact_no FROM cp_tb_user where username='$input_username' and password='$input_password' and is_admin=true";
		$result = $dbconnection->query($sql);
		if ($result->num_rows ==1) 
		{
			$dbconnection->close();	
			return true;
		}
		else
		{
			$dbconnection->close();	
			return false;
		}
	}
	
	public static function authenticateuserfororduser($input_username,$input_password)
	{
		$dbconnection=UserDB::connect_mysql();
		if ($dbconnection->connect_error) {    die("Connection failed: " . $dbconnection->connect_error);}
		$sql = "SELECT user_id,username,fullname,email,contact_no FROM cp_tb_user where username='$input_username' and password='$input_password' and is_admin=false";
		$result = $dbconnection->query($sql);
		if ($result->num_rows ==1) 
		{
			$dbconnection->close();	
			return true;
		}
		else
		{
			$dbconnection->close();	
			return false;
		}
	}
	
	public static function identifyuser($input_username)
	{
		$dbconnection=UserDB::connect_mysql();
		if ($dbconnection->connect_error) {    die("Connection failed: " . $dbconnection->connect_error);}
		$sql = "SELECT user_id,username,fullname,email,contact_no FROM cp_tb_user where username='$input_username'";
		$result = $dbconnection->query($sql);
		if ($result->num_rows ==1) 
		{
			$dbconnection->close();	
			return true;
		}
		else
		{
			$dbconnection->close();	
			return false;
		}
	}
	
	public static function updateuser($username,$fullname,$email,$contactno)
	{
		$dbconnection=UserDB::connect_mysql();
		if ($dbconnection->connect_error) {    die("Connection failed: " . $dbconnection->connect_error);}
		$sql = "update cp_tb_user set fullname='$fullname',email='$email',contact_no='$contactno' where username='$username'";
		$result = $dbconnection->query($sql);
		if ($result) 
		{
			echo "user updated</br>";
			$dbconnection->commit();
			$dbconnection->close();	
			return true;
		}
		else
		{
			echo "update user failure</br>";
			$dbconnection->close();	
			return false;
		}
	}
	
	public static function changepassword($username,$password)
	{
		$dbconnection=UserDB::connect_mysql();
		if ($dbconnection->connect_error) {    die("Connection failed: " . $dbconnection->connect_error);}
		$sql = "update cp_tb_user set password='$password' where username='$username'";
		$result = $dbconnection->query($sql);
		if ($result) 
		{
			echo "user passwordupdated</br>";
			$dbconnection->commit();
			$dbconnection->close();	
			return true;
		}
		else
		{
			echo "update user pasword failure</br>";
			$dbconnection->close();	
			return false;
		}
	}
	
	public static function insertadminuser($username,$password,$fullname,$email,$contactno)
	{
		$dbconnection=UserDB::connect_mysql();
		if ($dbconnection->connect_error) {    die("Connection failed: " . $dbconnection->connect_error);}
		$sql = "INSERT INTO cp_tb_user (username,password,fullname,email,contact_no,is_admin,is_blocked) VALUES ('$username','$password','$fullname','$email','$contactno',true,false)";
		$result = $dbconnection->query($sql);
		if ($result) 
		{
			echo "admin inserted</br>";
			$dbconnection->commit();
			$dbconnection->close();	
			return true;
		}
		else
		{
			echo "insert admin failure</br>";
			$dbconnection->close();	
			return false;
		}
	}
	
	public static function insertorduser($username,$password,$fullname,$email,$contactno)
	{
		$dbconnection=UserDB::connect_mysql();
		if ($dbconnection->connect_error) {    die("Connection failed: " . $dbconnection->connect_error);}
		$sql = "INSERT INTO cp_tb_user (username,password,fullname,email,contact_no,is_admin,is_blocked) VALUES ('$username','$password','$fullname','$email','$contactno',false,false)";
		$result = $dbconnection->query($sql);
		if ($result) 
		{
			echo "ord user inserted</br>";
			$dbconnection->commit();
			$dbconnection->close();	
			return true;
		}
		else
		{
			echo "insert ord user falure</br>";
			$dbconnection->close();	
			return false;
		}
	}
	
	public static function viewprofile($input_username)
	{
		$dbconnection=UserDB::connect_mysql();
		if ($dbconnection->connect_error) {    die("Connection failed: " . $dbconnection->connect_error);}
		$sql = "SELECT user_id,username,fullname,email,contact_no,is_blocked FROM cp_tb_user where username='$input_username'";
		$result = $dbconnection->query($sql);
		if ($result->num_rows > 0) 
		{
			// output data of each row
			while($row = $result->fetch_assoc()) 
			{
				$input_username=$row["username"];
				$input_fullname=$row["fullname"];
				$input_email=$row["email"];
				$input_contact_no=$row["contact_no"];
				$input_is_blocked=$row["is_blocked"];
			}
		
			$dbconnection->close();			
			$outputuser=new User($input_username,$input_fullname,"",$input_email,$input_contact_no,false,$input_is_blocked);
			return $outputuser;
		}
		else
		{
			echo "can't find person</br>";
			$dbconnection->close();		
			return false;
		}
	}
	
	public static function viewselectedprofile($input_id)
	{
		$dbconnection=UserDB::connect_mysql();
		if ($dbconnection->connect_error) {    die("Connection failed: " . $dbconnection->connect_error);}
		$sql = "SELECT user_id,username,fullname,email,contact_no FROM cp_tb_user where user_id='$input_id'";
		$result = $dbconnection->query($sql);
		if ($result->num_rows > 0) 
		{
			// output data of each row
			while($row = $result->fetch_assoc()) 
			{
				$input_username=$row["username"];
				$input_fullname=$row["fullname"];
				$input_email=$row["email"];
				$input_contact_no=$row["contact_no"];
			}
		
			$dbconnection->close();			
			$outputuser=new User($input_username,$input_fullname,"",$input_email,$input_contact_no,false,false);
			return $outputuser;
		}
		else
		{
			echo "can't find person</br>";
			$dbconnection->close();		
			return false;
		}
	}
	
	
	public static function adminsearchbyusername($input_username)
	{
		$dbconnection=UserDB::connect_mysql();
		if ($dbconnection->connect_error) {    die("Connection failed: " . $dbconnection->connect_error);}
		$sql = "SELECT user_id,username,fullname,email,is_blocked,is_admin FROM cp_tb_user where username like'%$input_username%'";
		$result = $dbconnection->query($sql);
		if($result->num_rows==0)
		{
			$dbconnection->close();
			echo "No results</br>";
			return false;
		}
		
		echo "<form action=\"\" method=\"post\">";
		echo "<table>";
		while($row = $result->fetch_assoc()) 
		{
			echo "<tr>";
			echo "<td>Username: " . $row["username"]. " </td><td>Full Name: " . $row["fullname"]." </td><td>Email: " . $row["email"]." </td><td> Blocked: ". $row["is_blocked"]."</td><td>";
			$test_admin=$row["is_admin"];
			if(!$test_admin)
			{
				if($row["is_blocked"])
				{
					echo " <input type=\"radio\" name=\"is_blocked_".$row["user_id"]."\" value=\"true\" checked> True";
					echo "<input type=\"radio\" name=\"is_blocked_".$row["user_id"]."\" value=\"false\"> False";
				}
				else
				{
					echo " <input type=\"radio\" name=\"is_blocked_".$row["user_id"]."\" value=\"true\" checked> True";
					echo "<input type=\"radio\" name=\"is_blocked_".$row["user_id"]."\" value=\"false\"checked> False";
				}
			}
			else{
				echo " Admin Status";
			}
			echo " </td><td><a href=\"vieweachprofile.php?input_id=".$row["user_id"]."\">View Profile</a></td>";
			echo"</tr>";
			
		}
		echo "</table>";
		echo "<input name=\"submitted\" type=\"hidden\" value=\"2a\" />";
		echo "<input name=\"search_variable\" type=\"hidden\" value=\"$input_username\" />";
		echo "<input type=\"submit\"  value=\"Update\" /></br>";		
		echo "</form>";
		$result->free();
		$dbconnection->close();
		return true;
	}
	
	public static function adminsearchbyusername_updatestatus($input_username)
	{
		$conn=UserDB::connect_mysql();
		if ($conn->connect_error) {    die("Connection failed: " . $conn->connect_error);}
		$sql = "SELECT user_id FROM cp_tb_user where username like '%$input_username%' and is_admin=false";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) 
		{
			// output data of each row
			while($row = $result->fetch_assoc()) 
			{
				$num="is_blocked_".$row["user_id"];
				$numid=$row["user_id"];
				echo $num." ";
				if (($_POST["{$num}"])=='true')
				{						
					echo " is blocked: ";
					$sql2="update cp_tb_user set is_blocked=1 where user_id='$numid'";
					if ($conn->query($sql2)===true)
					{
						echo "Record updated successfully</br>";
					}
					else
					{
						echo "Error updated record</br>";
					}
				}
				else
				{
					echo " is unblocked: ";
					$sql2="update cp_tb_user set is_blocked=0 where user_id='$numid'";
					if ($conn->query($sql2)===true)
					{
						echo "Record updated successfully</br>";
					}
					else
					{
						echo "Error updated record</br>";
					}
				}
				echo "</br>";
			}
			
			
		} 
		else { echo "0 results";}
		$conn->close();
	}
	
	public static function adminsearchbyfullname($input_fullname)
	{
		$dbconnection=UserDB::connect_mysql();
		if ($dbconnection->connect_error) {    die("Connection failed: " . $dbconnection->connect_error);}
		$sql = "SELECT user_id,username,fullname,email,is_blocked,is_admin FROM cp_tb_user where fullname like '%$input_fullname%'";
		$result = $dbconnection->query($sql);
		if($result->num_rows==0)
		{
			$dbconnection->close();
			echo "No results</br>";
			return false;
		}
		
		echo "<form action=\"\" method=\"post\">";
		echo "<table>";
		while($row = $result->fetch_assoc()) 
		{
			echo "<tr>";
			echo "<td>Username: " . $row["username"]. " </td><td>Full Name: " . $row["fullname"]." </td><td>Email: " . $row["email"]." </td><td> Blocked: ". $row["is_blocked"]."</td><td>";
			$test_admin=$row["is_admin"];
			if(!$test_admin)
			{
				if($row["is_blocked"])
				{
					echo " <input type=\"radio\" name=\"is_blocked_".$row["user_id"]."\" value=\"true\" checked> True";
					echo "<input type=\"radio\" name=\"is_blocked_".$row["user_id"]."\" value=\"false\"> False";
				}
				else
				{
					echo " <input type=\"radio\" name=\"is_blocked_".$row["user_id"]."\" value=\"true\" checked> True";
					echo "<input type=\"radio\" name=\"is_blocked_".$row["user_id"]."\" value=\"false\"checked> False";
				}
			}
			else{
				echo " Admin Status";
			}
			echo " </td><td><a href=\"vieweachprofile.php?input_id=".$row["user_id"]."\">View Profile</a></td>";
			echo"</tr>";
			
		}
		echo "</table>";
		echo "<input name=\"submitted\" type=\"hidden\" value=\"2b\" />";
		echo "<input name=\"search_variable\" type=\"hidden\" value=\"$input_username\" />";
		echo "<input type=\"submit\"  value=\"Update\" /></br>";		
		echo "</form>";
		$result->free();
		$dbconnection->close();
		return true;
	}
	
	public static function adminsearchbyfullname_updatestatus($input_fullname)
	{
		$conn=UserDB::connect_mysql();
		if ($conn->connect_error) {    die("Connection failed: " . $conn->connect_error);}
		$sql = "SELECT user_id FROM cp_tb_user where fullname like '%$input_fullname%' and is_admin=false";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) 
		{
			// output data of each row
			while($row = $result->fetch_assoc()) 
			{
				$num="is_blocked_".$row["user_id"];
				$numid=$row["user_id"];
				echo $num." ";
				if (($_POST["{$num}"])=='true')
				{						
					echo " is blocked: ";
					$sql2="update cp_tb_user set is_blocked=1 where user_id='$numid'";
					if ($conn->query($sql2)===true)
					{
						echo "Record updated successfully</br>";
					}
					else
					{
						echo "Error updated record</br>";
					}
				}
				else
				{
					echo " is unblocked: ";
					$sql2="update cp_tb_user set is_blocked=0 where user_id='$numid'";
					if ($conn->query($sql2)===true)
					{
						echo "Record updated successfully</br>";
					}
					else
					{
						echo "Error updated record</br>";
					}
				}
				echo "</br>";
			}
			
			
		} 
		else { echo "0 results";}
		$conn->close();
	}
	
	public static function adminsearchbyemail($input_email)
	{
		$dbconnection=UserDB::connect_mysql();
		if ($dbconnection->connect_error) {    die("Connection failed: " . $dbconnection->connect_error);}
		$sql = "SELECT user_id,username,fullname,email,is_blocked,is_admin FROM cp_tb_user where email like '%$input_email%'";
		$result = $dbconnection->query($sql);
		if($result->num_rows==0)
		{
			$dbconnection->close();
			echo "No results</br>";
			return false;
		}
		
		echo "<form action=\"\" method=\"post\">";
		echo "<table>";
		while($row = $result->fetch_assoc()) 
		{
			echo "<tr>";
			echo "<td>Username: " . $row["username"]. " </td><td>Full Name: " . $row["fullname"]." </td><td>Email: " . $row["email"]." </td><td> Blocked: ". $row["is_blocked"]."</td><td>";
			$test_admin=$row["is_admin"];
			if(!$test_admin)
			{
				if($row["is_blocked"])
				{
					echo " <input type=\"radio\" name=\"is_blocked_".$row["user_id"]."\" value=\"true\" checked> True";
					echo "<input type=\"radio\" name=\"is_blocked_".$row["user_id"]."\" value=\"false\"> False";
				}
				else
				{
					echo " <input type=\"radio\" name=\"is_blocked_".$row["user_id"]."\" value=\"true\" checked> True";
					echo "<input type=\"radio\" name=\"is_blocked_".$row["user_id"]."\" value=\"false\"checked> False";
				}
			}
			else{
				echo " Admin Status";
			}
			echo " </td><td><a href=\"vieweachprofile.php?input_id=".$row["user_id"]."\">View Profile</a></td>";
			echo"</tr>";
			
		}
		echo "</table>";
		echo "<input name=\"submitted\" type=\"hidden\" value=\"2c\" />";
		echo "<input name=\"search_variable\" type=\"hidden\" value=\"$input_email\" />";
		echo "<input type=\"submit\"  value=\"Update\" /></br>";
		echo "</form>";
		$result->free();
		$dbconnection->close();
		return true;
	}
	
	public static function adminsearchbyemail_updatestatus($input_email)
	{
		$conn=UserDB::connect_mysql();
		if ($conn->connect_error) {    die("Connection failed: " . $conn->connect_error);}
		$sql = "SELECT user_id FROM cp_tb_user where email like '%$input_email%' and is_admin=false";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) 
		{
			// output data of each row
			while($row = $result->fetch_assoc()) 
			{
				$num="is_blocked_".$row["user_id"];
				$numid=$row["user_id"];
				echo $num." ";
				if (($_POST["{$num}"])=='true')
				{						
					echo " is blocked: ";
					$sql2="update cp_tb_user set is_blocked=1 where user_id='$numid'";
					if ($conn->query($sql2)===true)
					{
						echo "Record updated successfully</br>";
					}
					else
					{
						echo "Error updated record</br>";
					}
				}
				else
				{
					echo " is unblocked: ";
					$sql2="update cp_tb_user set is_blocked=0 where user_id='$numid'";
					if ($conn->query($sql2)===true)
					{
						echo "Record updated successfully</br>";
					}
					else
					{
						echo "Error updated record</br>";
					}
				}
				echo "</br>";
			}
			
			
		} 
		else { echo "0 results";}
		$conn->close();
	}
	
	public static function usersearchbyusername($input_username)
	{
		// Create connection
		$conn = UserDB::connect_mysql();
		if ($conn->connect_error) {    die("Connection failed: " . $conn->connect_error);}
		$sql = "SELECT user_id,username,fullname,email FROM cp_tb_user where username like '%$input_username%' and is_admin=false";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			// output data of each row
			echo "<table>";
			while($row = $result->fetch_assoc()) 
			{
				echo"<tr>";
				echo "<td>Username: " . $row["username"]. " </td><td>Full Name: " . $row["fullname"]." </td><td> Email: " . $row["email"]." </td><td><a href=\"vieweachprofile.php?input_id=".$row["user_id"]."\"> View Profile</a></td>";
				echo "</tr>";
			}			
			echo "</table>";
		
		} else { echo "0 results";}
		$result->free();
		$conn->close();
	}
	
	public static function usersearchbyfullname($input_fullname)
	{
		// Create connection
		$conn = UserDB::connect_mysql();
		if ($conn->connect_error) {    die("Connection failed: " . $conn->connect_error);}
		$sql = "SELECT user_id,username,fullname,email FROM cp_tb_user where fullname like '%$input_fullname%' and is_admin=false";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			echo "<table>";
			while($row = $result->fetch_assoc()) 
			{
				echo"<tr>";
				echo "<td>Username: " . $row["username"]. " </td><td>Full Name: " . $row["fullname"]." </td><td> Email: " . $row["email"]." </td><td><a href=\"vieweachprofile.php?input_id=".$row["user_id"]."\"> View Profile</a></td>";
				echo "</tr>";
			}			
			echo "</table>";
		
		} else { echo "0 results";}
		$result->free();
		$conn->close();
	}
	
	public static function usersearchbyemail($input_email)
	{
		// Create connection
		$conn = UserDB::connect_mysql();
		if ($conn->connect_error) {    die("Connection failed: " . $conn->connect_error);}
		$sql = "SELECT user_id,username,fullname,email FROM cp_tb_user where email like '%$input_email%'  and is_admin=false";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			echo "<table>";
			while($row = $result->fetch_assoc()) 
			{
				echo"<tr>";
				echo "<td>Username: " . $row["username"]. " </td><td>Full Name: " . $row["fullname"]." </td><td> Email: " . $row["email"]." </td><td><a href=\"vieweachprofile.php?input_id=".$row["user_id"]."\"> View Profile</a></td>";
				echo "</tr>";
			}			
			echo "</table>";
			
		
		} else { echo "0 results";}
		$result->free();
		$conn->close();
	}
	
	public static function usersetsession($username,$password)
	{
		session_start();
		$_SESSION["username"] = $username;
		$_SESSION["password"] = $password;
		echo "Session variables are set.";

	}
	
	public static function userdestroysession()
	{
		session_unset();
		// destroy the session
		session_destroy();
		echo "Session Variables removed and Session destroyed";
	}
}
?>