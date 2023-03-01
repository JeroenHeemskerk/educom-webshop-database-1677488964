<?php
var_dump($data);
function showContent($data)
{

    echo '
        <div class="form-style-3">
          <form method="post" action="index.php">
            <fieldset>
              <legend>Fill out your information to change your password:</legend>              
              <label for="password"><span class="required">Password*</span><input type="password" class="input-field" name="password" value="' . $data["password"] . '" /></label>
              <span class="error">' . $data["passwordErr"] . '</span>
              <label for="newPassword"><span class="required">Choose a new password*</span><input type="password" class="input-field" name="newPassword" value="' . $data["newPassword"] . '" /></label>
              <span class="error">' . $data["newPasswordErr"] . '</span>
            </fieldset>      
            <fieldset>              
              <label><input type="submit" value="Submit" /></label>
              <input type="hidden" name="page" value="changepassword">                                                
              </fieldset>
          </form>
        </div>';
}
