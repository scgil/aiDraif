<?php 
class Main{

  function __construct($files,$dirs){
    $this->render($files,$dirs);
  }

  function render($files,$dirs){

    require_once '../Vistas/templates/Header.php';
    new Header();
?>
    <div class="app-structure__content">
      <div  class="app-structure__main">
        <?php if($_SESSION['top'] == false){ ?>
          <div>
            <a href="/Controller/Main_controller.php?action=goParent" class="btn btn-primary btn-title btn-position" role="button"><?php echo translate('FATHER') ?></a>
          </div>
        <?php } ?>
        <table id="dtBasicExample" class="table table-sm" cellspacing="0" width="100%">
          <thead class="thead btn-primary">
            <tr>
              <th class="th-sm"><?php echo translate('ICON') ?></th>
              <th class="th-sm"><?php echo translate('NAME') ?></th>
              <th class="th-sm"><?php echo translate('TYPE') ?></th>
              <th class="th-sm"><?php echo translate('OPTIONS') ?></th>
            </tr>
          </thead>
          <tbody>
                
             <?php if($files != false){
		            while($row=mysqli_fetch_object($files)){ ?>
          				<tr>
                    <td><img src="../../Vistas/images/data.png" alt="folder" class="main-icons"/></td>
          				  <td><?php echo $row->originalName ; ?></td>
          				  <td><?php echo $row->mimeType ;?></td>
                    <td>
                      <div class="dropdown">
                        <a class="btn" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...</a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                          <a class="delete-item dropdown-item" href="#delete_item_modal" data-toggle="modal" data-target="#delete_item_modal"><?php echo translate('DELETE') ?>
                            <div class="d-none uuid"><?php echo $row->uuid; ?></div>
                            <div class="d-none type">file</div>
                          </a>
                          <a class="share-item dropdown-item" href="share_item_modal" data-toggle="modal" data-target="#share_item_modal"><?php echo translate('SHARE') ?>
                            <div class="d-none uuid"><?php echo $row->uuid; ?></div>
                          </a>
                          <form action="/Controller/Main_controller.php?action=download" method="post">
                            <input type="hidden" name="name" value="<?php echo $row->originalName ; ?>">
                            <input type="hidden" name="uuid" value="<?php echo $row->uuid ; ?>">
                            <button class="dropdown-item" type="submit"><?php echo translate('DOWNLOAD') ?></button>
                          </form>
                        </div>
                      </div>
                    </td>
                  </tr>
<?php           }
	   		      }                                 

      if($dirs != false){
          while($row=mysqli_fetch_object($dirs)){ ?>
            <tr>
              <td><img src="../../Vistas/images/folder.png" alt="folder" class="main-icons"/></td>
              <td>
                <form action="/Controller/Main_controller.php?action=nextDir" method="post">
                  <input type="hidden" name="nextDir" value="<?php echo $row->uuid ?>"/>
                  <button type="submit" class="btn btn-primary btn-sm"><?php echo $row->name; ?></button>
                </form>
              </td>
              <td>Directorio</td>
              <td>
                  <div class="dropdown">
                    <a class="btn" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...</a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                      <a class="edit-item dropdown-item" href="#edit_item_modal" data-toggle="modal" data-target="#edit_item_modal"><?php echo translate('EDIT') ?>
                        <div class="d-none uuid"><?php echo $row->uuid ?></div>
                         <div class="d-none item_name"><?php echo $row->name; ?></div>
                         <div class="d-none type">dir</div>
                      </a>
                      <a class="delete-item dropdown-item" href="#delete_item_modal" data-toggle="modal" data-target="#delete_item_modal"><?php echo translate('DELETE') ?>
                        <div class="d-none uuid"><?php echo $row->uuid; ?></div>
                        <div class="d-none type">dir</div>
                      </a>
                    </div>
                  </div>
              </td>
            </tr>
    <?php }
        } ?>

          </tbody>
        </table>
        </div>

      <div class=app-structure__secondary>
        <ul class="main_functions">
            <li class="create_folder"><a href="#add_folder" data-toggle="modal" data-target="#add_folder"><img src = "../Vistas/images/createfolder.png" alt="create_folder" class="function-icons"/></a></li>
            <li class="upload_element"><a id="add_file" href="#add_file_modal" data-toggle="modal" data-target="#add_file_modal">
                  <img src="../../Vistas/images/uploadcloud.png" alt="upload_element"  class="function-icons"/>
                  <div class="d-none uuid"> <!--Objeto UUID--></div>
                </a></li>
        </ul>
      </div>
    </div>
     <!-- Modal Add file-->
    <div class="modal fade" id="add_file_modal" tabindex="-1" role="dialog" aria-labelledby="add_file_title" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <form action="/Controller/Main_controller.php?action=upload" method="post" enctype="multipart/form-data">
            <div class="modal-header">
              <h5 class="modal-title" id="add_file_title"><?php echo translate('ADDFILE') ?></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <input type="text" name="uuid" class="d-none">
            <div class="modal-body">
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="customFile" name="custom_file">
                <label class="custom-file-label" for="customFile"><?php echo translate('CHOOSEFILE') ?></label>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo translate('CLOSEBUTTON') ?></button>
              <button type="submit" class="btn btn-primary"><?php echo translate('UPLOADFILE') ?></button>
            </div>
        </form>
        </div>
      </div>
    </div>

    <!-- Modal Add folder-->
    <div class="modal fade" id="add_folder" tabindex="-1" role="dialog" aria-labelledby="add_folder_title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <form action = '/Controller/Main_controller.php?action=addDir' method='post'>
              <div class="modal-header">
                <h5 class="modal-title" id="add_folder_title"><?php echo translate('ADDFOLDER') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <label for="folder_name"><?php echo translate('FOLDERNAME') ?></label>
                <input name="dirName" type="text" class="form-control" id="folder_name" placeholder="<?php echo translate('FOLDERPLACEHOLDER') ?>">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo translate('CLOSEBUTTON') ?></button>
                <button type="submit" class="btn btn-primary"><?php echo translate('CREATEFOLDER') ?></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    <!-- Modal Edit item-->
    <div class="modal fade" id="edit_item_modal" tabindex="-1" role="dialog" aria-labelledby="edit_item_title" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <form action="/Controller/Main_controller.php?action=editItem" method="post">
          <div class="modal-header">
            <h5 class="modal-title" id="edit_item_title"><?php echo translate('EDITNAME') ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <input type="text" name="uuid" class="d-none">
          <input type="text" name="type" class="d-none">
          <div class="modal-body">
            <label for="Edit_name"><?php echo translate('EDITNAME') ?></label>
            <input type="text" class="form-control" id="edit_name" name="item_name" placeholder="Edit the name of the file or folder">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo translate('CLOSEBUTTON') ?></button>
            <button type="submit" class="btn btn-primary"><?php echo translate('EDITNAME') ?></button>
          </div>
        </form>
        </div>
      </div>
    </div>
    <!-- Modal Delete item-->
    <div class="modal fade" id="delete_item_modal" tabindex="-1" role="dialog" aria-labelledby="delete_item_title" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <form action="/Controller/Main_controller.php?action=deleteItem" method="post">
          <div class="modal-header">
            <h5 class="modal-title" id="delete_item_title"><?php echo translate('DELETEITEM')?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <input type="text" name="uuid" class="d-none" >
          <input type="text" name="type" class="d-none" >
          <div class="modal-body">
            <p> <?php echo translate('WARNINGDELETE')?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo translate('CLOSEBUTTON') ?></button>
              <button type="submit" class="btn btn-primary"><?php echo translate('SURE')?></button>
            </form>
          </div>
        </div>
      </div>
    </div>
        <!-- Modal Share item-->
        <div class="modal fade" id="share_item_modal" tabindex="-1" role="dialog" aria-labelledby="share_item_title" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="share_item_title"><?php echo translate('SHAREITEM') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <input type="text" name="uuid" class="d-none">
              <div class="modal-body">  
                <p id="link">www.aidraif.com/main/archivo_compartir</p>     
              </div>
              <div id="alerta" class="alert invisible"></div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo translate('CLOSEBUTTON') ?></button>
                <button type="button" class="btn btn-primary" id="btn-copy"><?php echo translate('COPYLINK') ?></button>
              </div>
            </div>
          </div>
        </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS, Datatables -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
    <script src="../../Vistas/javascript/main.js"></script>

<?php       
          include '../Vistas/templates/Footer.php';
          new Footer();
        }//Render end
  }//Main class end
?>
