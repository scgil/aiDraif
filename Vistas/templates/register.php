<?php 
  class Register{
    function __construct(){
      $this->render();
    }
    function render(){

?>
        <!DOCTYPE html>
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
                  <div class="w-app-login-logo"><img src="../../Vistas/images/loginfolder.png" alt="aiDraif.com" class="w-app-login-logo__image"/>
                  </div><!---->
                    <div class="content"><!----><!----><!---->
                      <div class="page-login">
                        <div class="standard-form"><!---->
                          <div class="content"><!----><!----><!----><!----><!---->
                            <div class="login-form">
                              <div class="w-page-header no-subtitle">
                                <div class="w-page-header__title"><?php echo translate('AIDRAIF')?></div>
                                <p class="w-page-header__description">
                                  <span>
                                  </span><!---->
                                </p>
                              </div>
                              <form class="needs-validation was-validated" novalidate="" method='post' action="./Register_controller.php" >
                                <div class="mb-3">
                                  <label for="username"><?php echo translate('USER')?></label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text">@</span>
                                    </div>
                                    <input type="text" class="form-control" required=""  id="username" name="user" placeholder="<?php echo translate('USERPLACEHOLDER')?>" required="">
                                    <div class="invalid-feedback">
                                      <?php echo translate('INVALIDUSERPLACEHOLDER')?>
                                    </div>
                                  </div>
                                </div>
                                <div class="mb-3">
                                  <label for="loginemail"><?php echo translate('EMAIL')?></label>
                                  <input type="email" class="form-control" required="" id="loginemail" name="email" placeholder="<?php echo translate('EMAILPLACEHOLDER')?>" required="">
                                  <div class="invalid-feedback">
                                    <?php echo translate('INVALIDEMAILPLACEHOLDER')?>
                                    
                                  </div>
                                </div>
                                <div class="mb-3">
                                  <label for="loginpassword"><?php echo translate('PASS')?></label>
                                  <input type="password" required="" class="form-control" id="loginpassword" name="pass" placeholder="<?php echo translate('PASSPLACEHOLDER')?>" required="">
                                  <div class="invalid-feedback">
                                    <?php echo translate('INVALIDPASSPLACEHOLDER')?>
                                    
                                  </div>
                                </div>
                                
                                <button class="btn btn-primary btn-lg btn-block" type="submit"><?php echo translate('REGISTRE')?></button>
                              </form>
                            </div><!---->
                          </div>
                        </div>
                      </div>
                    </div>
                  </section>
                </div>
                <div class="b-app-structure__secondary">
                  <div class="b-app-structure__secondary-content">
                    <div class="b-app-structure__secondary-content_language">
                        <a href="/Functions/language.php?action=switchL&from=Register" class="btn-language" role="button">
                            <img src="../../Vistas/images/btn_language.png" alt="folder" class="language-icons"/>
                        </a>
                    </div>
                    <div class="b-app-structure__secondary-content_clam">
                      <?php echo translate('HASACCOUNT?')?>
                    </div>
                    <div class="b-app-structure__secondary-content_button">
                      <a href="./Login_controller.php" class="btn btn-primary" role="button"><?php echo translate('LOGIN')?></a>
                    </div>
                  </div>
                </div>
              </div>

            <!-- Optional JavaScript -->
            <!-- jQuery first, then Popper.js, then Bootstrap JS -->
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

            </body>

        </html>
<?php    }//End render

  }//End class
?>
