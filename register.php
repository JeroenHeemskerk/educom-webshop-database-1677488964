<?php
function showContent($data)
{
    echo '
        <div class="form-style-3">
          <form method="post" action="index.php">
            <fieldset>
              <legend>Fill out your information to register:</legend>
              <label for="name"><span class="required">Name*</span><input type="text" class="input-field" name="name" value="' . $data["name"] . '" /></label>
              <span class="error">' . $data["nameErr"] . '</span>
              <label for="email"><span class="required">Email*</span><input type="email" class="input-field" name="email" value="' . $data["email"] . '" /></label>
              <span class="error">' . $data["emailErr"] . '</span>
              <label for="password"><span class="required">Password*</span><input type="password" class="input-field" name="password" value="' . $data["password"] . '" /></label>
              <span class="error">' . $data["passwordErr"] . '</span>
              <label for="confirmPassword"><span class="required">Confirm Password*</span><input type="password" class="input-field" name="confirmPassword" value="' . $data["confirmPassword"] . '" /></label>
              <span class="error">' . $data["confirmPasswordErr"] . '</span>
            </fieldset>      
            <fieldset>              
              <label><input type="submit" value="Submit" /></label>
              <input type="hidden" name="page" value="register">                                                
              </fieldset>
          </form>
        </div>';
}
