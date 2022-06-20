<?php
session_start();

class Computer{
	
	private $number = '';
	private $status = '';
	
	public function addObjects($number, $status){
		
		if(ctype_digit($number)) $this->number = $number;
		if(ctype_digit($status)) $this->status = $status;
		
		if( $this->number!='' &&  $this->status!=''){
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
					if($rezultat = $pol->query("INSERT INTO object (number, status) VALUES ('$this->number','$this->status')"))
					{
						
					} else $_SESSION['error'] = 'Niepoprawne dane';
					
					if($rezultat = $pol->query("INSERT INTO history (number, statusH) VALUES ('$this->number','$this->status')"))
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

if(isset($_POST['number']) && isset($_POST['status'])){
	$number = $_POST['number'];
	$status = $_POST['status'];
	
	$komputer = new Computer();
	
	$komputer->addObjects($number, $status);

	
	header('Location: index.php');
}
?>


<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ewelina Ozga - Rekrutacja Media Expert</title>
	<meta name="description" content="" />

	<link rel="stylesheet" href="style.css" type="text/css"/>
	
</head>
<body>

	<h1>Aplikacja zarządzania pracownią komputerową</h1>
			

	
	
	<div class="container-1">
		<h2>Dodaj nowy komputer</h2>
		
		<form action="addComputer.php" method="post">
				<div class="books-add">
					<div class="column-left">
						Numer komputera:
					</div>
					<div class="column-right">
						<input type="text" name="number"/>
						<?php
							if(isset($e_book_name) && $e_book_name==true) echo '<div class="error">Podaj nr komputera</div>';
						?>
					</div>
				</div>
				
				
				<div class="books-add">
					<div class="column-left">
						Status:
					</div>
					<div class="column-right">
						<select name="status">
							<option value="1">włączony</option>
							<option value="2">wyłączony</option>
							<option value="3">hibernacja</option>
							<option value="4">uśpienie</option>
						</select>
					</div>
				</div>
				
				<div class="error"><?php if(isset($_SESSION['error'])) echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
				
				<div class="books-add-button">
					<div class="column-left">
						
					</div>
					<div class="column-right button-add">
						<button>Dodaj komputer</button>
					</div>
					
				</div>
			</form>
	</div>
	
	<div class="nav">
	
		<a class="link" href="index.php">Przejdź do listy komputerów</a>
		<a class="link" href="search.php">Przeszukaj dane aktualne</a>
		<a class="link" href="searchHistory.php">Przeszukaj dane historyczne</a>
	</div>


</body>
</html>