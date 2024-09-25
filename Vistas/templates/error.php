<?php
	class CustomError{
		function __construct($message){
			$this->render($message);
		}

		function render($message){
?>
<html lang="en">
    <head>
        <?php 
          require_once ("../Functions/language.php");
        ?>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?php echo translate('AIDRAIF')?></title>
        <!-- Bootstrap CSS -->
       <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
       <!-- FontAwesome for Icons -->
       <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
       <link rel="stylesheet" type="text/css" href="../../Vistas/stylesheets/login.css">
    </head>
<body>
      <div id="app" class="b-app-structure">
        <div class="b-app-structure__main">
          <section class="b-login-holder">
          <div class="w-app-login-logo"><img src="../Vistas/images/deletefolder.png" alt="aiDraif.com" class="w-app-login-logo__image"/>
          </div><!---->
            <div class="content"><!----><!----><!---->
              <div class="page-login">
                <div class="standard-form"><!---->
                  <div class="content"><!----><!----><!----><!----><!---->
                    <div class="login-form">
                      <div class="w-page-header no-subtitle">
                        <div class="w-page-header__title">aiDraif</div>
                        <p class="w-page-header__description">
                          <span>
                          </span><!---->
                        </p>
                      </div>
                      <form>
                        <div class="alert alert-warning" role="alert">
                          <h4 class="alert-heading">Oops!</h4>
                          <p><?php echo translate($message);?></p>
                          <hr>
                          <p class="mb-0"><?php echo translate('ERRORADVICE') ?></p>
                        </div>
                        <button type="submit" class="btn btn-primary"><?php echo translate('CONTINUE') ?></button>
                      </form>
                    </div><!---->
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    </body>
    
</html>


<?php
		}
	}

?>