<?php include 'db_test.php'; 
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: LoginPage.php");
    exit();}?>
<!DOCTYPE html>
<html lang="en" >
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PIM Home</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9"
      crossorigin="anonymous"
    />
   <link rel="stylesheet" href="assets/css/nav.css">
  <link rel="stylesheet" href="assets/css/home.css" />

<script
  src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
  integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
  crossorigin="anonymous"
></script>
<script
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
  integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa"
  crossorigin="anonymous"
></script>

<script
  src="https://kit.fontawesome.com/6d009c3487.js"
  crossorigin="anonymous"
></script>
<script src="./assets/js/home.js"></script>
  </head>
  <body>
    <nav class="mainNav">
      <div>
  
      <button data-bs-toggle="modal" data-bs-target="#delModal"  class="upload" id="new">New
      <i class="fa-solid fa-circle-plus" style="color: #5B4795;"></i>
      </button>

      </div>
      <div class="cate">
        <ul class="nav flex-column">
          <li class="nav-item nav-header">
            <a class="nav-link active" href="#">
            <i class="fa-regular fa-heart" id="nav-icon-heart" 
            style="color: #403d45;"></i>
      
              Favorites</a>
          </li>
        </ul>
        <ul class="nav flex-column">
          <li class="nav-item nav-header">
            <a class="nav-link" href="photo.php">
            <i class="fa-regular fa-images" style="color: #403d45;"></i>
              Photos</a>
          </li>
        </ul>
        <ul class="nav flex-column">
          <li class="nav-item nav-header">
            <a class="nav-link" href="#">
            <i class="fa-regular fa-clock" style="color: #403d45;"></i>
            Recents</a>
          </li>
        </ul>
        <div class="tag-outline">
        <ul class="nav flex-column">
          <li class="tag-title">
           Tags
          </li>
          <?php $stmt = $conn->prepare("SELECT * FROM tags ");
   
    $stmt->execute();
    $t = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($t as $key => $v) { ?>
          <li class="tag-name">
          <i class="fa-solid fa-tag" style="color: #403d45;"></i>
           <span class="text-green"><a href="tag.php?id=<?php echo $v['id'] ?> "><?php echo $v['tag_name'] ?> </a></span>
          </li>
       <?php } ?>
        </ul> 
      </div>
        <!-- <ul class="nav flex-column">
          <li class="nav-item nav-header">
            <a class="nav-link" href="#">Tags</a>
          </li>
        </ul> -->
      </div>
    </nav>
    <div class="right">
      <header>
        <div class="search">
          <form class="d-flex" role="search">
            <input
              class="form-control me-2"
              type="search"
              placeholder="Search"
              aria-label="Search"
            />
            <button class="btn btn-outline-success" type="submit">
              <i class="fa-solid fa-magnifying-glass"></i>
            </button>
          </form>

          <div class="user-info">
            <div class="user-name"> <a href="logout.php">Logout</a></div>
            <img
              src="https://static.vecteezy.com/system/resources/previews/002/002/403/original/man-with-beard-avatar-character-isolated-icon-free-vector.jpg "
              alt="Avatar"
              class="avatar"
            />
          </div>
        </div>
        <div class="myline"></div>
        <div class="breadcrumb">
          <div class="path">
           All Documents
          </div>
        </div>
      </header>

      <section class="detail">
       
       <table class="table">
  <thead>
    <tr>
      <th scope="col"><input class="form-check-input" type="checkbox" value="" id=""></th>
      <th scope="col">Name</th>
      
      
      
      <th scope="col">Filepath</th>
      <th scope="col">Modified</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  	<?php 

 $stmt = $conn->prepare("SELECT * FROM files where type =2 ");
   
    $stmt->execute();
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($user as $key => $v) {
		
		
  	 ?>
    <tr>
    <th scope="row"><input class="form-check-input" type="checkbox" value="" id=""></th>
      <td> <?php echo $v['filename'] ?></td>
      <td> <?php echo $v['filepath'] ?></td>
     
      <td> <?php echo $v['created_at'] ?></td>
     
      
    
      <td class="action">
     <a href="delete.php?id=<?php echo $v['id'] ?>"> <i class="fa-regular fa-trash-can" style="color: #5B4795;"></i></a> | 
     <a href="download.php?id=<?php echo $v['id'] ?>"> down</a>
     

      </th>
    </tr>
	   <?php } ?>
   
   
  </tbody>
</table>
      </section>

      <!-- del Modal -->
      <div
        class="modal fade"
        id="delModal"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog">
          <div class="modal-content">
          <h1 class="h4 text-center mb-3">Drag &amp; drop file upload example</h1>

<form action="upload.php" method="post" enctype="multipart/form-data">

  <fieldset class="upload_dropZone text-center mb-3 p-4">
    <legend class="visually-hidden">Image uploader</legend>
    <svg class="upload_svg" width="60" height="60" aria-hidden="true">
      <use href="#icon-imageUpload"></use>
    </svg>
    <p class="small my-2">Drag &amp; Drop background image(s) inside dashed region<br><i>or</i></p>
    <center>
    <input type="file" multiple  name="file[]" /><br>
   TAG: <input type="text"  name="tag" />
</center>
  

    <div class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0"></div>

  </fieldset>



<svg style="display:none">
  <defs>
    <symbol id="icon-imageUpload" clip-rule="evenodd" viewBox="0 0 96 96">
      <path d="M47 6a21 21 0 0 0-12.3 3.8c-2.7 2.1-4.4 5-4.7 7.1-5.8 1.2-10.3 5.6-10.3 10.6 0 6 5.8 11 13 11h12.6V22.7l-7.1 6.8c-.4.3-.9.5-1.4.5-1 0-2-.8-2-1.7 0-.4.3-.9.6-1.2l10.3-8.8c.3-.4.8-.6 1.3-.6.6 0 1 .2 1.4.6l10.2 8.8c.4.3.6.8.6 1.2 0 1-.9 1.7-2 1.7-.5 0-1-.2-1.3-.5l-7.2-6.8v15.6h14.4c6.1 0 11.2-4.1 11.2-9.4 0-5-4-8.8-9.5-9.4C63.8 11.8 56 5.8 47 6Zm-1.7 42.7V38.4h3.4v10.3c0 .8-.7 1.5-1.7 1.5s-1.7-.7-1.7-1.5Z M27 49c-4 0-7 2-7 6v29c0 3 3 6 6 6h42c3 0 6-3 6-6V55c0-4-3-6-7-6H28Zm41 3c1 0 3 1 3 3v19l-13-6a2 2 0 0 0-2 0L44 79l-10-5a2 2 0 0 0-2 0l-9 7V55c0-2 2-3 4-3h41Z M40 62c0 2-2 4-5 4s-5-2-5-4 2-4 5-4 5 2 5 4Z"/>
    </symbol>
  </defs>
</svg>
          <center>
              <button
                type="submit"
                class="btn btn-secondary cancel"
                data-bs-dismiss="modal"
              >
                Cancel
              </button>
              <button type="button" class="btn btn-secondary sure-del">
                Delete
              </button></center></form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>


