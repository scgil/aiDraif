<?php
	class Header{
		function __construct(){
			$this->render();
		}
		function render(){


			include_once '../Functions/language.php';
?>

			<!DOCTYPE html>
			<html lang="en">
			    <head>
			        <meta charset="UTF-8">
			        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
			        <title><?php echo translate('AIDRAIF')?></title>
			        <!-- Bootstrap CSS -->
			       <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
			       <!-- FontAwesome for Icons -->
			       <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
			       <!-- Datatables with Bootstrap -->
			       <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>
			       <!-- CSS template -->
			       <link rel="stylesheet" type="text/css" href="../../Vistas/stylesheets/main.css">
			    </head>

			    <body>
			    	<div class="app-structure">
		              <div class="app-structure__header">
		                <nav class="bar fix-top bg-blue">
		                  <div class="app-name">
		                    <!--<a class="app-name-link" href="#">aiDraif</a>-->
		                    <a href="#" class="btn btn-primary btn-title" role="button"><?php echo translate('AIDRAIF')?></a>
		                  </div>
		                  <div class="app-logo">
		                    <img src="../Vistas/images/loginfolder.png" alt="aiDraif.com" class="app-main-logo__image"/>
		                  </div>
		                    <div class="btn-group">
		                      <button type="button" class="btn btn-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		                        <?php echo translate('USER')?>
		                      </button>
		                      <div class="dropdown-menu">
		                      	<a class="dropdown-item" href="#">
		                        <a class="dropdown-item" href="/Functions/language.php?action=switchL&from=Main">
		                        	<img src="../../Vistas/images/spanish.png" alt="folder" class="language-icons"/>
		                        	<img src="../../Vistas/images/switch.png" alt="folder" class="language-icons"/>
		                        	<img src="../../Vistas/images/english.png" alt="folder" class="language-icons"/>
		                        </a>
		                        <?php if($_SESSION['currentLanguage'] == 'Spanish'){?>
		                        	<img src="../../Vistas/images/spanish.png" alt="folder" class="language-icons"/>
		                        	<?php echo translate('SPANISH') ?></img>
		                        <?php }else{?>
		                        	 <img src="../../Vistas/images/english.png" alt="folder" class="language-icons"/>
		                        	 <?php echo translate('ENGLISH') ?></img>
		                        <?php } ?>
		                        <div class="dropdown-divider"></div>
		                        <a class="dropdown-item" href="#"><?php echo translate('SETTINGS') ?></a>
		                        <div class="dropdown-divider"></div>
		                        <a class="dropdown-item" href="/Functions/logout.php"><?php echo translate('LOGOUT') ?></a>
		                      </div>
		                    </div>
		                </nav>
		              </div>
<?php 	
		}//Render end
	}//Class end

?>
