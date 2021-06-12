<?php
session_start();
require_once "dbConnect.php";

if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) {
    header("location: home.php");
    exit;
}
$email = $password = "";
$emailError = $passwordError = '';
$loginError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['Email'])) {
        $emailError = "email is required";
    } else {
        $email = $_POST['Email'];
    }
    if (empty($_POST['Password'])) {
        $passwordError = "password is required";
    } else {
        $password = $_POST['Password'];
    }

    if (empty($emailError) && empty($passwordError)) {
        $sql = "SELECT Id, FirstName, LastName, Email, HashedPassword, StatusID, EmailVerificationToken FROM users WHERE Email = :Email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['Email' => $email]);
        if ($stmt->rowCount() == 1) {
            $result = $stmt->fetch();
            $Id = $result -> Email;
            $Email = $result -> Email;
            $FirstName = $result -> FirstName;
            $LastName = $result -> LastName;
            $hashedPassword = $result -> HashedPassword;
            $StatusID = $result -> StatusID;
            $EmailVerificationToken = $result -> EmailVerificationToken;

            if (password_verify($password, $hashedPassword)) {

                session_start();

                $_SESSION["loggedin"] = true;
                $_SESSION["email"] = $Email;
                $_SESSION["firstName"] = $FirstName;
                $_SESSION["lastName"] = $LastName;
                $_SESSION["statusId"] = $StatusID;
                $_SESSION["emailVerificationToken"] = $EmailVerificationToken;

                header("location: home.php");
            } else {
                $passwordError = "Incorrect password.";
            }
        } else {
            $emailError = "Invalid email";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <h1>Login</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label>
            <input type="text" name="Email"  value="<?php echo (isset($Email)) ? $Email : ''; ?>">
        </label>
        <label>
            <input type="text" name="Password">
        </label>
        <?php if (isset($loginError)) { ?>
            <span ><?php echo $loginError ?></span>
        <?php } ?>
        <?php if (isset($emailError)) { ?>
            <span ><?php echo $emailError ?></span>
        <?php } ?>
        <?php if (isset($passwordError)) { ?>
            <span ><?php echo $passwordError ?></span>
        <?php } ?>
        <input type="submit" value="submit">
    </form>
</body>

</html>