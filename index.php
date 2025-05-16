<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Bejelentkezés</title>
</head>
<body>
    <h1>Név: Teszt Elek</h1>
    <h2>Neptun: ABC123</h2>
    <form action="auth.php" method="post">
        <label for="username">Felhasználónév (email):</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Jelszó:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Bejelentkezés</button>
    </form>
</body>
</html>