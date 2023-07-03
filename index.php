<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

  <label>ID</label>
  <input type="text" name="ID"><br>
  <label>BSN</label>
  <input type="text" name="BSN"><br>
  <label>Datum</label>
  <input type="text" name="Datum" id="datepicker"><br>
  <label>Tijd</label>
  <input type="text" name="Tijd"><br>
  <label>Temperatuur</label>
  <input type="text" name="Temperatuur"><br>
  <label>Luchtvochtigheid</label>
  <input type="text" name="Luchtvochtigheid"><br>
  <label>Lichtintensiteit</label>
  <input type="text" name="Lichtintensiteit"><br>
  <label>CO2-gehalte</label>
  <input type="text" name="CO2-gehalte"><br>
  <input type="submit" name="data" value="Opslaan">
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>

<script>

  $(function() {

    $("#datepicker").datepicker({ dateFormat: 'yy-mm-dd' });

  });

</script>
<?php
$host = "localhost";
$dbname = "guusberend_mjlo";
$username = "guusberend";
$password = "Gb141155";

$PDOoptions = [
    PDO::ATTR_PERSISTENT => true,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_TIMEOUT => 5, // in seconds
    PDO::MYSQL_ATTR_FOUND_ROWS => true
];

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, $PDOoptions);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

try {
    $sql = "SELECT * FROM metingen ORDER BY Datum DESC LIMIT 20";
    $query = $db->query($sql);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);   // resultaten als key-value pairs
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

if (isset($_POST['data'])) {

    $kastje = $_POST['BSN'];
    $datum = $_POST['Datum'];
    $tijd = $_POST['Tijd'];
    $temperatuur = $_POST['Temperatuur'];
    $luchtvochtigheid = $_POST['Luchtvochtigheid'];
    $co2gehalte = $_POST['Lichtintensiteit'];
    $lichtintensiteit = $_POST['CO2-gehalte'];

    try {
        $query = "INSERT INTO metingen (`ID`, `BSN`, `Datum`, `Tijd`, `Temperatuur`, `Luchtvochtigheid`, `Lichtintensiteit`, `CO2-gehalte`) 
        VALUES ('',?, ?, ?, ?, ?, ?, ?)";
$stmt = $db->prepare($query);

// Voer de query uit met de ingevoerde gegevens
$stmt->execute([$kastje, $datum, $tijd, $temperatuur, $luchtvochtigheid, $co2gehalte, $lichtintensiteit]);

        echo "Gegevens succesvol opgeslagen in de database.";
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

$db = null;
?>

<body>
    <style>
        table {
            border-collapse: collapse; }
        th, td {
            border: 1px solid black;
            padding: 5px;}
    </style>
    <table>
    <?php
        foreach ($result[0] as $key => $value) {
                echo "<th>$key</th>";}
        foreach ($result as $row) {
            echo "<tr>";
             foreach ($row as $value) {
                echo "<td>$value</td>";}
            echo "</tr>";}
        ?>
    </table>
</body>

