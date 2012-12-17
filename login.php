<?php
        include("lib.class/functions.class.php");
        $fun = new Functions();
        echo $fun->libJquery();
        include("lib.class/mysql.class.php");
        $sql = MysqlServer::getInstance();
        if (isset($_POST["save"])) {
  		$user = $_POST["u"];
			$pass = $_POST["p"];
			$fusion = md5($user."-".$pass);
            if ($fun->validateUser($user, $fusion) == true) {
                session_start();
                $fun->starTimeLive();
                $_SESSION["idU"] = $fun->getID($_POST["u"], $_POST["p"]);
				$_SESSION["state"] = "logged";;
                $fun->redirect404("/fullmovie/list-movies.php");
            } else {
                $fun->redirect404("/fullmovie/login.php?access=false");
            }
        } else {
            ?>
<!doctype html>
<html>
    <head>
            <meta charset="utf-8">
            <title>Full Movie</title>
            <?php echo $fun->loadCoreEfects(); ?>
            <link rel="stylesheet" type="text/css" href="style.css">
            <script>
                // placeholder polyfill
                $(document).ready(function(){
                    function add() {
                        if($(this).val() === ''){
                            $(this).val($(this).attr('placeholder')).addClass('placeholder');
                        }
                    }

                    function remove() {
                        if($(this).val() === $(this).attr('placeholder')){
                            $(this).val('').removeClass('placeholder');
                        }
                    }
                    // Create a dummy element for feature detection
                    if (!('placeholder' in $('<input>')[0])) {

                        // Select the elements that have a placeholder attribute
                        $('input[placeholder], textarea[placeholder]').blur(add).focus(remove).each(add);

                        // Remove the placeholder text before the form is submitted
                        $('form').submit(function(){
                            $(this).find('input[placeholder], textarea[placeholder]').each(remove);
                        });
                    }
                });
            </script>   

        </head>
        <body>
            <div id="m-wrapper">
                <div id="m-header">
                    <div class="m-logo"> <a href="/fullmovie"><img src="images/logo.png"></a> </div>
                    <div class="m-search-movie">
                    <?php
					echo "<ul role=\"nav\">";
					if (isset($_SESSION["state"]) == "logged") {
					
						echo "<li>";
							echo "<a role=\"upload-button\" href=\"list-movies.php\">List Movies</a>";
						echo "</li>";
						echo "<li>";
							echo '<a role="upload-button" href="/fullmovie/update.php?u=up">Update Ratings</a>';
						echo "</li>";
					}
					?>
					<?php
						echo "<li>";
							echo $fun->loginState();
						echo "</li>";
					echo "</ul>";
					?>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="m-title-page">

                </div>
                <div class="m-top">
                    <div class="m-top-2"></div>
                </div>
                <div id="m-content">
                    <div class="m-content-2">
                        <!--<div class="upload-movies"> <a role="upload-button" href="form-upload.php">Upload</a> </div>-->
                        <?php
						
						if(isset($_GET["logout"]) == "true") {
							$msg = "<h5>session completed successfully</h5>";
							echo $fun->messageFadeOut("finalizesession", $msg);
						}
						if(isset($_GET["access"]) == "false") {
							$msg = "<h5 role=\"denied\">access denied</h5>";
							echo $fun->messageFadeOut("accesdenied", $msg); 
						}
						if(isset($_GET["hack"]) == "fail") {
							$msg = "<h5 role=\"denied\"><p id=\"k\">hacking attempt failed</p></h5>";
							echo $fun->messageFadeOut("kackerror", $msg);
						}
						?>
                        <div class="line-btm"></div>
                        <?php
                        echo "<div><h4>Login Access</h4></div>";
                        echo $fun->formAccess($_SERVER["PHP_SELF"]);
                        ?>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="m-bottom">
                    <div class="m-bottom-2"></div>
                </div>
                <div id="m-footer">
                    <div class="shadow-footer"></div>
                    <p> &copy; Copyright
                        <?php echo date("Y");   ?>
                        <a href="http://www.todaysweb.com">Todays Web</a></p>
                </div>
            </div>
        </body>
        <?php
    }
    ?>
</html>
