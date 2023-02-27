<?php

function showContactContent($data)
{

  echo '
        <div class="form-style-3">
          <form method="post" action="index.php">
            <fieldset>
              <legend>Personal</legend>
              <label for="name"><span class="required">Name*</span><input type="text" class="input-field" name="name" value="' . $data["name"] . '" /></label>
              <span class="error">' . $data["nameErr"] . '</span>
              <label for="email"><span class="required">Email*</span><input type="email" class="input-field" name="email" value="' . $data["email"] . '" /></label>
              <span class="error">' . $data["emailErr"] . '</span>
              <label for="phone"><span class="required">Phone*</span><input type="text" class="input-field" name="phone" value="' . $data["phone"] . '" /></label>
              <span class="error">' . $data["phoneErr"] . '</span>
              <label for="salutation"><span>How can we address you?</span><select name="salutation" class="select-field">
                  <option ';
  if ($data["salutation"] === "Mrs") {
    echo "selected";
  }
  echo 'value="Mrs">Mrs</option>
                  <option ';
  if ($data["salutation"] === "Ms") {
    echo "selected";
  }
  echo 'value="Ms">Ms</option>
                  <option ';
  if ($data["salutation"] === "Mx") {
    echo "selected";
  }
  echo 'value="Mx">Mx</option>
                  <option ';
  if ($data["salutation"] === "Mr") {
    echo "selected";
  }
  echo 'value="Mr">Mr</option>
                </select></label>
            </fieldset>
            <fieldset>
              <legend>Preferred contact option *:</legend>
              <label for="email"><span>email</span></label>
              <input type="radio" id="email" name="contactOption" class="required"';

  if ($data["contactOption"] === "email") {
    echo "checked";
  }
  echo ' value="email"><br>
              <label for="phone"><span>phone</span></label>
              <input type="radio" id="phone" name="contactOption" class="required"';
  if ($data["contactOption"] ===  "phone") {
    echo "checked";
  }
  echo ' value="phone"><br>
              <span class="error">' . $data["contactOptionErr"] . '</span>
            </fieldset>
            <fieldset>
              <legend>How can I help you?</legend>
              <label for="message"><span class="required">Message*</span><textarea name="message" class="textarea-field">' . $data["message"] . '</textarea></label>
              <span class="error">' . $data["messageErr"] . '</span>
              <p></p>
              <label><input type="submit" value="Submit" /></label>
              <input type="hidden" name="page" value="contact">                                                
              </fieldset>
          </form>
        </div>';
}

function showContent($data)
{
  if ($data['valid'] === true) {
    include('thanks.php');
    showThankYouContent($data);
  } else {
    showContactContent($data);
  }
}
