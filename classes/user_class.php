<?php
class User
{	
	private $username;
	private $fullname;
	private $password;
	private $email;
	private $contact_no;
	private $is_admin;
	private $is_blocked;
	
	public function __construct($username,$fullname,$password,$email,$contact_no,$is_admin,$is_blocked)
	{
		$this->username=$username;
		$this->fullname=$fullname;
		$this->password=$password;
		$this->email=$email;
		$this->contact_no=$contact_no;
		$this->is_admin=$is_admin;
		$this->is_blocked=$is_blocked;
	}
	
	public function setusername($username)
	{
		$this->username=$username;
	}
	
		public function setfullname($fullname)
	{
		$this->fullname=$fullname;
	}
	
	public function setpassword($password)
	{
		$this->password=$password;
	}
	
	public function setemail($email)
	{
		$this->email=$email;
	}
	
	public function setcontactno($contact_no)
	{
		$this->contact_no=$contact_no;
	}
	
	public function setisadmin($is_admin)
	{
		$this->is_admin=$is_admin;
	}
	
	public function setisblocked($is_blocked)
	{
		$this->is_blocked=$is_blocked;
	}
	
	public function returnusername()
	{
		return $this->username;
	}
	
	public function returnfullname()
	{
		return $this->fullname;
	}
	
	public function returnpassword()
	{
		return $this->password;
	}
	
	public function returnemail()
	{
		return $this->email;
	}
	
	public function returncontactno()
	{
		return $this->contact_no;
	}
	
	public function returnisadmin()
	{
		return $this->is_admin;
	}
	
	public function returnisblocked()
	{
		return $this->is_blocked;
	}
	
	public function viewuser()
	{
		echo "Username: ".$this->username."</br>";
		echo "Email: ".$this->email."</br>";
		echo "Contact No: ".$this->contact_no."</br>";
		echo "Admin: ".$this->is_admin."</br>";
		echo "Blocked: ".$this->is_blocked."</br>";
	}
}
?>