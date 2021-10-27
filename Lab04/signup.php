<?php
require_once("top.html");
?>
<form action="signup-submit.php" method="post">
    <fieldset>
        <legend>New USer Signup</legend>
        <div>
            <label class="left">
                <strong>Name: </strong>
            </label>
            <input type="text" placeholder="Your name here" name="name" maxlength="16" class="chInput16" required>
        </div>
        <div>
            <label class="left">
                <strong>Gender: </strong>
            </label>
            <input type="radio" value="M" name="gender"><label for="Male">Male</label>
            <input type="radio" value="F" name="gender"><label for="Female">Female</label>
        </div>
        <div>
            <label class="left">
                <strong>Age: </strong>
            </label>
            <input type="text" placeholder="Age" name="age" class="chInput6" maxlength="2" required>
        </div>
        <div>
            <label class="left">
                <strong>Personality type: </strong>
            </label>
            <input type="text" placeholder="Pers." class="chInput6" name="persType" maxlength="4"  required>
            <label>(<a href="http://www.humanmetrics.com/cgi-win/jtypes2.asp" target="_blank">Don't know your type?</a>)</label>
        </div>
        <div>
            <label class="left">
                <strong>Favorite OS: </strong>
            </label>
            <select name="os"  required>
                <option value="Windows">Windows</option>
                <option value="Linux" selected>Linux</option>
                <option value="Mac OS X">MacOS X</option>
            </select>
        </div>
        <div>
            <label class="left">
                <strong>Seeking age: </strong>
            </label>
            <input type="text" placeholder="From" class="chInput6" name="ageFrom" maxlength="2"  required>
             to
            <input type="text" placeholder="To" class="chInput6" name="ageTo" maxlength="2"  required>

        </div>

        <br>
        <input type="submit" value="Sign Up">
    </fieldset>
</form>

<?php
require_once ("bottom.html");
?>
