<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" />
  <title>Comanda</title>
  <link type="image/x-icon" href="./assets/img/logos/logo.png" rel="icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../assets/css/styles.css" />
</head>


<div class="main-content">
    <header>
      <h2>
        <label for="nav-toggle">
          <span class="las la-bars"><i class="fa-solid fa-user-tie"></i></span> 
        </label>
      
      </h2>
      <div>
        <h2>Bienvenido</h2>
      </div>
      <div><i class="fa-solid fa-heart"></i></div>
      <div>
        <i class="fa-solid fa-question-circle" title="Ayuda" style="color: green; margin-left: 8px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#helpModal"></i>
      </div>
      <div class="collapse navbar-collapse d-flex flex-row-reverse bd-highlight" id="navbarSupportedContent">
        <div class="btn-group dropstart">
			<div class="btn-group dropstart">
				<button type="button" title="Profile" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
					<i class="bi bi-person-circle"></i>
				</button>
				<ul class="dropdown-menu" aria-labelledby="navbarDropdown">					
					</li>
          <li><a class="dropdown-item" href="<?= base_url('login/logout') ?>"><i class="bi bi-box-arrow-left" style="color: blue;"></i> Sign off</a></li>

				</ul>
			</div>	
    </header>

    <<!-- Modal de Ayuda -->
<div class="modal fade" id="helpModal" tabindex="-1" aria-labelledby="helpModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="helpModalLabel">Ayuda en Video</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="ratio ratio-16x9">
          <iframe src="https://www.youtube.com/embed/sM27-g6Zdb4" title="YouTube video" allowfullscreen></iframe>
        </div>
      </div>
    </div>
  </div>
</div>
