<!DOCTYPE html>
<html lang="en">
<?php
    session_start();
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
</head>

<body>
    <h1>Home</h1>
    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) { ?>
        <div><?php echo $_SESSION['firstName'] . ' ' . $_SESSION['lastName'] ?></div>
        <?php if (isset($_SESSION['statusId']) && $_SESSION['statusId'] == 0) { ?>
            <p>Account is not activated, resend link on email</p>
        <?php } ?>
    <?php } else {
        header("location: login.php");
        exit;
    } ?>
    <script>
        $("#resend").click(function() {
            $.ajax({
                url: 'resend-email.php',
                type: 'post',
                success: function(data) {
                    window.location.reload();
                }
            });
        });
    </script>
</body>

</html>