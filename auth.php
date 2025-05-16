<?php
function decryptPasswordFile($filename) {
    $key = [5, -14, 31, -9, 3];
    $lines = file($filename);
    $decoded = [];

    foreach ($lines as $line) {
        $line = rtrim($line, "\n");
        $decodedLine = '';
        $keyIndex = 0;

        for ($i = 0; $i < strlen($line); $i++) {
            $ord = ord($line[$i]);
            $decodedChar = chr($ord - $key[$keyIndex]);
            $decodedLine .= $decodedChar;

            $keyIndex = ($keyIndex + 1) % count($key);
        }

        list($username, $password) = explode('*', $decodedLine);
        $decoded[$username] = $password;
    }

    return $decoded;
}

// 1. POST adatok beolvasása
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (!$username || !$password) {
    die("Hiányzó adatok!");
}

// 2. Jelszavak dekódolása
$passwords = decryptPasswordFile("password.txt");

if (!isset($passwords[$username])) {
    die("Nincs ilyen felhasználó.");
}

if ($passwords[$username] !== $password) {
    echo "Hibás jelszó. Átirányítás 3 mp múlva...";
    header("refresh:3;url=https://www.police.hu");
    exit;
}

// 3. Adatbázis kapcsolat
$mysqli = new mysqli("localhost", "adatak", "Gabi10", "adatak");
if ($mysqli->connect_errno) {
    die("Adatbázis hiba: " . $mysqli->connect_error);
}

$stmt = $mysqli->prepare("SELECT Titkos FROM tabla WHERE Username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $color = htmlspecialchars($row['Titkos']);
    echo "<body style='background-color: $color; color: white;'><h1>Sikeres bejelentkezés!</h1><p>Kedvenc színed: $color</p></body>";
} else {
    echo "Adat nem található.";
}

?>
