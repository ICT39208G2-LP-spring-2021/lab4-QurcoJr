<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<body>
    <h1>Registration</h1>
    <?php if (!isset($_SESSION["submissionSuccess"])) { ?>
        <form action="add-user.php" class="form" method="post">
            <label>
                <input type="text" name="FirstName"  value = "<?php echo (isset($FirstName)) ? $FirstName : ''; ?>">
                <span class="error">*</span>
                <?php if (isset($_SESSION['FirstNameError'])) { ?>
                    <div class="error"><?php echo $_SESSION['FirstNameError'] ?></div>
                <?php } ?>
            </label>
            <label>
                <input type="text" name="LastName"  value = "<?php echo (isset($LastName)) ? $LastName : ''; ?>">
                <?php if (isset($_SESSION['LastNameError'])) { ?>
                    <div class="error"><?php echo $_SESSION['LastNameError'] ?></div>
                <?php } ?>
            </label>
            <label>
                <input type="text" name="PersonalNumber"  value = "<?php echo (isset($PersonalNumber)) ? $PersonalNumber : ''; ?>">
                <?php if (isset($_SESSION['PersonalNumberError'])) { ?>
                    <div class="error"><?php echo $_SESSION['PersonalNumberError'] ?></div>
                <?php } ?>
            </label>
            <label>
                <input type="text" name="Email"  value = "<?php echo (isset($Email)) ? $Email : ''; ?>">
                <?php if (isset($_SESSION['EmailError'])) { ?>
                    <div class="error"><?php echo $_SESSION['EmailError'] ?></div>
                <?php } ?>
            </label>
            <label>
                <input type="password" name="Password">
                <?php if (isset($_SESSION['PasswordError'])) { ?>
                    <div class="error"><?php echo $_SESSION['PasswordError'] ?></div>
                <?php } ?>
            </label>
            <button type="submit">
        </form>
    <?php } else { ?>
        <h3>User is already registered</h3>
        <p>Activation link has been sent on E-mail</p>
        <?php if(isset($_SESSION['attemptsCount']) && $_SESSION['attemptsCount'] > 0) { ?>
            <p>Resend link</p>
        <?php  } else { ?>
            <p>You can not resend link, 'cause it's reached the limit</p>
        <?php  } ?>
    <?php } ?>

    <script>
        $("#resend").click(function(){
            $.ajax({
                url : 'resend-email.php',
                type : 'post',
                success : function(data){
                    window.location.reload();
                }
            });
        });
    </script>
</body>
</html>
