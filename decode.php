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

// 🔍 Futtatás
$passwords = decryptPasswordFile("password.txt");

// 📋 Kiírás teszteléshez
echo "<pre>";
print_r($passwords);
echo "</pre>";
?>
