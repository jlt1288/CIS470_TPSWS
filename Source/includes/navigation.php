<?php require_once('scripts/strings.php'); ?>

<img src="resources/tpslogo.png" class="logo" alt="TPS">
<a href="#" class="myButton">Search</a>
<a href="#" class="myButton">Contract</a>
<a href="#" class="myButton">Request</a>
<a href="#" class="myButton">Members</a>
<a href="register.php" class="<?php if (endsWith($_SERVER["PHP_SELF"], "register.php")) { echo currentButton ;} else { echo myButton; } ?>">Register</a>
<a href="login.php" class="<?php if (endsWith($_SERVER["PHP_SELF"], "login.php")) { echo currentButton; } else { echo myButton; } ?>">Login</a>
<a href="index.php" class="<?php if (endsWith($_SERVER["PHP_SELF"], "index.php")) { echo currentButton; } else { echo myButton; } ?>">Home</a>