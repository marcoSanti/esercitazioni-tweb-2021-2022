<?php include "top.html"; ?>

<form action="matches-submit.php" method="get">
    <fieldset>
        <legend>
            Returning User:
        </legend>
        <div>
            <label class="left">
                <strong>Name: </strong>
            </label>
            <input type="text" placeholder="Your name" class="chInput16" name="name" maxlength="16" required>
        </div>
        <input type="submit" value="View My Matches">
    </fieldset>
</form>



<?php include "bottom.html"; ?>
