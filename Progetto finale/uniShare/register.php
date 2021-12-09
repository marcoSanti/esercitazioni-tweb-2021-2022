<?php
include "header.html";
include "navbar.php";

?>

<div  id="LoginForm">
    <h4>Creazione nuovo utente</h4>
    <span class="px-4 py-3">
        <div class="mb-3">
            <label for="exampleDropdownFormEmail1" class="form-label">Nome</label>
            <input type="email" class="form-control" id="exampleDropdownFormEmail1" placeholder="email@example.com">
        </div>
        <div class="mb-3">
            <label for="exampleDropdownFormEmail1" class="form-label">Cognome</label>
            <input type="email" class="form-control" id="exampleDropdownFormEmail1" placeholder="email@example.com">
        </div>
        <div class="mb-3">
            <label for="exampleDropdownFormEmail1" class="form-label">Email</label>
            <input type="email" class="form-control" id="exampleDropdownFormEmail1" placeholder="email@example.com">
        </div>
        <div class="mb-3">
            <label for="exampleDropdownFormPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" id="exampleDropdownFormPassword1" placeholder="Password">
        </div>
        <div class="mb-3">
            <label for="exampleDropdownFormPassword1" class="form-label">Ripeti password</label>
            <input type="password" class="form-control" id="exampleDropdownFormPassword1" placeholder="Password">
        </div>

        <button type="submit" class="btn btn-primary">Registrati</button>
    </span>
</div>


<?php
include "footer.html";
?>
