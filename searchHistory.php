<?php
session_start();

class searchObjects{
	
	private $number = '';
	private $status = '';
	private $dateFrom = '';
	private $dateTo = '';
	
	public function show(){
		if( isset($_GET['number']) || isset($_GET['status']) || isset($_GET['dateFrom']) || isset($_GET['dateTo'])){
			//require_once "connect.php";
			if(isset($_GET['number']) && ctype_digit($_GET['number'])){
				$this->number = $_GET['number'];
			}
			
			if(isset($_GET['status']) && ctype_digit($_GET['status']) && $_GET['status']!='0'){
				$this->status = $_GET['status'];
			}
			
			if(isset($_GET['dateFrom']) ){
				
				$day = date_format(date_create($_GET['dateFrom']),'d');
				$month = date_format(date_create($_GET['dateFrom']),'m');
				$year = date_format(date_create($_GET['dateFrom']),'Y');
				
				if(checkdate($month, $day, $year)){
					$this->dateFrom = $_GET['dateFrom'];
				}
			}
			
			if(isset($_GET['dateTo']) ){
				
				$day = date_format(date_create($_GET['dateTo']),'d');
				$month = date_format(date_create($_GET['dateTo']),'m');
				$year = date_format(date_create($_GET['dateTo']),'Y');
				
				if(checkdate($month, $day, $year)){
					$this->dateTo = $_GET['dateTo'];
				}
			}
			
			
			
			$zapytanie = "SELECT o.number, h.dateModified, h.statusH FROM object as o, history as h WHERE o.number=h.number";
			
			if($this->number!='') $zapytanie .= " AND o.number='$this->number' ";
			if($this->status!='') $zapytanie .= " AND h.statusH='$this->status' ";
			if($this->dateFrom!='') $zapytanie .= " AND h.dateModified >= '$this->dateFrom 00:00' ";
			if($this->dateTo!='') $zapytanie .= " AND h.dateModified <= '$this->dateTo 23:59' ";
			
		
			
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
					if($rezultat = $pol->query($zapytanie))
					{
						$ilerekordow=$rezultat->num_rows;
						if($ilerekordow>0)
						{
							$content =  '<table>';
							$content .= '<thead> <td>Numer komputera</td> <td>Data modyfikacji statusu</td> <td>Status</td></thead>';
							$content .= '<tbody>';
							
							while($row=$rezultat->fetch_assoc())
							{
								$number = $row['number'];
								$dateCreated = $row['dateModified'];
								$status = $row['statusH'];
								if($status == 1) $option1 = 'selected';
								if($status == 2) $option2 = 'selected';
								if($status == 3) $option1 = 'selected';
								if($status == 4) $option1 = 'selected';
								
								$content .= '<tr> <td>'.$number.'</td> <td>'.$dateCreated.'</td> <td>';
										
										if($status == 1) $content .= 'włączony';
										if($status == 2) $content .= 'wyłączony';
										if($status == 3) $content .= 'hibernacja';
										if($status == 4) $content .= 'uśpienie';
								
								
								$content .= '</td>';
								$content .= '</tr>';
							}	
							$content .= '</tbody>';
							$content .= '</table>';
							
							return '<h2>Wyniki wyszukiwania</h2>'.$content;
							
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
	
	<h2>Wyszukiwarka danych historycznych</h2>
	
	<form method="get">
		<div class="grid">
			<div class="grid-row">
				<h3>Numer komputera</h3>
				<input type="number" name="number" value="<?php if(isset($_GET['number'])) echo $_GET['number']; ?>"/>
			</div>
			
			<div class="grid-row">
				<h3>Status historyczny</h3>
				<select name="status">
					<option value="0">wszystkie</option>
					<option value="1" <?php if(isset($_GET['status']) && $_GET['status']==1) echo 'selected'; ?>>włączony</option>
					<option value="2" <?php if(isset($_GET['status']) && $_GET['status']==2) echo 'selected'; ?>>wyłączony</option>
					<option value="3" <?php if(isset($_GET['status']) && $_GET['status']==3) echo 'selected'; ?>>hibernacja</option>
					<option value="4" <?php if(isset($_GET['status']) && $_GET['status']==4) echo 'selected'; ?>>uśpienie</option>
				</select>
			</div>
			<div class="grid-row">
				<h3>Data modyfikacji od</h3>
				<input type="date" name="dateFrom"  value="<?php if(isset($_GET['dateFrom'])) echo $_GET['dateFrom']; ?>"/>
			</div>
			<div class="grid-row">
				<h3>Data modyfikacji do</h3>
				<input type="date" name="dateTo"  value="<?php if(isset($_GET['dateTo'])) echo $_GET['dateTo']; ?>"/>
			</div>
			
			<div class="grid-row">
				
				<button>Szukaj </button>
			</div>
			
		</div>
	</form>
	
	
	
	<?php 
		$search = new searchObjects();
		
		echo $search->show();
	
	?>
	
		
	</div>
	
	<div class="nav">
		<a class="link" href="addComputer.php">Dodaj komputer</a>
		<a class="link" href="index.php">Przejdź do listy komputerów</a>
		<a class="link" href="search.php">Przeszukaj dane aktualne</a>
	</div>


</body>
</html>