<?php
session_start();

class showObjects{
	
	private $status = '';
	
	public function show(){
	
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
				if($rezultat = $pol->query("SELECT * FROM object"))
				{
					$ilerekordow=$rezultat->num_rows;
					if($ilerekordow>0)
					{
						$content =  '<table>';
						$content .= '<thead> <td>Numer komputera</td> <td>Data utworzenia</td> <td>Status</td>  <td>Usuń obiekt</td></thead>';
						$content .= '<tbody>';
						
						while($row=$rezultat->fetch_assoc())
						{
							$number = $row['number'];
							$dateCreated = $row['dateCreated'];
							$status = $row['status'];
							if($status == 1) $option1 = 'selected';
							if($status == 2) $option2 = 'selected';
							if($status == 3) $option1 = 'selected';
							if($status == 4) $option1 = 'selected';
							
							$content .= '<tr> <td>'.$number.'</td> <td>'.$dateCreated.'</td> <td>';
								$content.= '<form method="post" action="changeStatus.php">';
									$content.= '<input type="hidden" name="number" value="'.$number.'">';
									$content .= '<select name="status">';
									
									if($status == 1) $content .= '<option value="1" selected>włączony</option>';
									else $content .= '<option value="1">włączony</option>';
									
									if($status == 2) $content .= '<option value="2" selected>wyłączony</option>';
									else $content .= '<option value="2">wyłączony</option>';
									
									if($status == 3) $content .= '<option value="3" selected>hibernacja</option>';
									$content .= '<option value="3">hibernacja</option>';
									
									if($status == 4) $content .= '<option value="4" selected>uśpienie</option>';
									$content .= '<option value="4">uśpienie</option>';
									
									$content .= '</select>';
									
									$content .= ' <button> Zapisz zmiany </button>';
								$content.= '</form>';
							
							$content .= '</td> <td class="red">';

							$content.= '<form method="post" action="deleteComputer.php">';
								$content.= '<input type="hidden" name="number" value="'.$number.'">';
								$content.= '<button>X</button>';
							$content.= '</form>';
							
							$content .='</td></tr>';
						}	
						$content .= '</tbody>';
						$content .= '</table>';
						
						return $content;
						
					} else {
						return 'Brak wyników';
					}
					$rezultat->free_result();
					
				} else return 'Brak danych';
				
				$pol->close();
			}
		} catch (Exceptions $e)
		{
			return "Błąd wyświetlania strony. Prosimy spróbować za kilka minut";
			//return "informacja deweloperska: ".$e;
		}
	}
	
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
			
	<div class="container">
	
	<h2>Wszystkie komputery w pracowni</h2>
	
	<div class="error"><?php if(isset($_SESSION['error_s'])) echo $_SESSION['error_s']; unset($_SESSION['error_s']); ?></div>
	
	<?php echo showObjects::show(); ?>
	
		
	</div>
	
	<div class="nav">
		<a class="link" href="addComputer.php">Dodaj komputer</a>
		<a class="link" href="search.php">Przeszukaj dane aktualne</a>
		<a class="link" href="searchHistory.php">Przeszukaj dane historyczne</a>
	</div>


</body>
</html>