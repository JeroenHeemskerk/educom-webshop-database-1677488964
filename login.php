<?php
function showContent($data)
{
  showFormStart();
  echo '
       
            <fieldset>
              <legend>Login:</legend>             
              <label for="email"><span class="required">Email*</span><input type="email" class="input-field" name="email" value="' . $data["email"] . '" /></label>
              <span class="error">' . $data["emailErr"] . '</span>
              <label for="password"><span class="required">Password*</span><input type="password" class="input-field" name="password" value="' . $data["password"] . '" /></label>
              <span class="error">' . $data["passwordErr"] . '</span>             
            </fieldset>      
            <fieldset>              
              <label><input type="submit" value="Submit" /></label>
              <input type="hidden" name="page" value="login">                                                
              </fieldset>
          </form>
        </div>
 ';
}

function showFormStart()
{
  echo '<div class="form-style-3">
  <form method="post" action="index.php">';
}
