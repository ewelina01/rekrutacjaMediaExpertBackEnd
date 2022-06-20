<?php
session_start();

class Computer2{
	
	private $number = '';
	private $status = '';
	
	public function changeObject($number, $status){
		
		if(ctype_digit($number)) $this->number = $number;
		if(ctype_digit($status)) $this->status = $status;
		
		if( $this->number!='' && $this->status!=''){
			require_once "connect.php";
			
			mysqli_report(MYSQLI_REPORT_STRICT);
			
			try {
				$pol = new mysqli($host,$db_user,$db_password,$db_name);

				if($pol->connect_errno!=0)
				{
					throw new Exception(mysqli_connect_errno());
				}
				else 
				{
					if($rezultat = $pol->query("UPDATE object SET status='$this->status' WHERE number = '$this->number'"))
					{
						
					} else $_SESSION['error_s'] = 'Nie udało się zmienić statusu';
					
					if($rezultat = $pol->query("INSERT INTO history (number, statusH) VALUES ('$this->number','$this->status')"))
					{
						
					} else $_SESSION['error_s'] = 'Nie udało się zmienić statusu';
					
					header('Location: index.php');
					
					$pol->close();
				}
			} catch (Exceptions $e)
			{
				return "Błąd wyświetlania strony. Prosimy spróbować za kilka minut";
				//return "informacja deweloperska: ".$e;
			}
		} else $_SESSION['error_s'] = 'Nie udało się zmienić statusu';
	}
	
}

if(isset($_POST['number']) && isset($_POST['status'])){
	$number = $_POST['number'];
	$status = $_POST['status'];
	
	$komputer = new Computer2();
	
	$komputer->changeObject($number, $status);

	header('Location: index.php');
} else {
	$_SESSION['error_s'] = 'Nie udało się zmienić statusu';
	header('Location: index.php');
}
?>