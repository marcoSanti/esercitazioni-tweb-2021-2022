<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="./">
            <img src="src/media/logo.svg" alt="" width="30" height="24" class="d-inline-block align-text-top">
            UniShare
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="./#homePageWho">Chi siamo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="search.php"><i class="fas fa-search"></i> Cerca appunti</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="./upload.php"><i class="fas fa-cloud-upload-alt"></i> Carica appunti</a>
                </li>





            </ul>
            <div class="d-flex">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Area utente
                    </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item NavBarNotLoggedOnly" href="./login.php">Accedi</a></li>
                            <li><a class="dropdown-item NavBarNotLoggedOnly" href="./register.php">Registrati</a></li>
                            <li><a class="dropdown-item NavBarLoggedOnly" href="./user.php">Profilo</a></li>
                            <li><span class="dropdown-item NavBarLoggedOnly" id="ButtonEsciNavbar">Esci</span></li>
                       </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
