<?php
include "header.html";
include "navbar.php";

?>
<script src="src/js/login.js"></script>
<form  id="LoginForm">
    <h4>Accesso utente registrato</h4>
    <div class="alert alert-danger ErrorLoginRegisterDiv" role="alert" id="ErrorLoginDiv">
        <strong>Errore: </strong>
        <div id="ErrorLoginDivContent">
        </div>
    </div>
    <span class="px-4 py-3">
        <div class="mb-3">
            <label for="LoginEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="LoginEmail" name="mail" placeholder="email@example.com">
        </div>
        <div class="mb-3">
            <label for="LoginPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="LoginPassword" name="password" placeholder="Password">
        </div>
        <div class="mb-3">

        </div>
        <div id="loginButton" class="btn btn-primary">Accedi</div>
    </span>

</form>

<?php
include "footer.html";
?>
