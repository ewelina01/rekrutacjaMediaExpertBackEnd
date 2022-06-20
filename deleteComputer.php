<?php
session_start();

class Computer1{
	
	private $number = '';
	
	public function deleteObject($number){
		
		if(ctype_digit($number)) $this->number = $number;
		
		if( $this->number!=''){
			//require_once "connect.php";
			
			$host = "localhost";
			$db_user = "root";
			$db_password = "";
			$db_name = "rekrutacjamediaexpert";
			
			mysqli_report(MYSQLI_REPORT_STRICT);
			
			try {
				$pol = new mysqli($host,$db_user,$db_password,$db_name);

				if($pol->connect_errno!=0)
				{
					throw new Exception(mysqli_connect_errno());
				}
				else 
				{
					if($rezultat = $pol->query("DELETE FROM object WHERE number = '$this->number'"))
					{
						
					} else $_SESSION['error'] = 'Niepoprawne dane';
					
					if($rezultat = $pol->query("DELETE FROM history WHERE number='$this->number'"))
					{
						
					} else $_SESSION['error'] = 'Niepoprawne dane';
					
					header('Location: index.php');
					
					$pol->close();
				}
			} catch (Exceptions $e)
			{
				return "Błąd wyświetlania strony. Prosimy spróbować za kilka minut";
				//return "informacja deweloperska: ".$e;
			}
		} else $_SESSION['error'] = 'Niepoprawne dane';
	}
	
}

if(isset($_POST['number'])){
	$number = $_POST['number'];
	
	$komputer = new Computer1();
	
	$komputer->deleteObject($number);

	header('Location: index.php');
} else {
	$_SESSION['error'] = 'Niepoprawne dane';
	header('Location: index.php');
}
?>