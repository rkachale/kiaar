	<?php //phpinfo(); ?>

    <?php
	//$connew = mysqli_connect("somaiya-edu.cfuahjovyrht.ap-south-1.rds.amazonaws.com", "arigel", "t)2D#+qDgkG8U-MN", "kiaar");

	// if (!$connew) {
 //            echo "Error: Unable to connect to MySQL." . PHP_EOL;
 //            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
 //            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
 //            exit;
 //        }
 //        $dbnew = $connew;
        ?>

<?php error_reporting(1); ini_set('display_errors', 1);?>
<?php

$con = mysqli_connect("somaiya-edu.cfuahjovyrht.ap-south-1.rds.amazonaws.com", "arigel", "t)2D#+qDgkG8U-MN", "kiaar");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
} else {
    echo "connected";
    exit();
}
?>