<?PHP

function showFormStart()
{
    echo '<div class="form-style-3">
  <form method="post" action="index.php">';
}

function showFormFieldSetStart($legend)
{
    echo '<fieldset>
    <legend>' . $legend . ':</legend> ';
}

function showFormField($field, $label, $type, $data, $required = true, $options = null)
{
    echo '<label for="' . $field . '"><span class="' . $required . '">' . $label . '*</span>';

    switch ($type) {

        case "select":
            echo '<select name="' . $field . '" class="select-field">';
            foreach ($options as $key => $value) {
                echo '<option ' . ($key == $data[$field] ? ' selected ' : '') . 'value="' . $key . '">' . $value . '</option>';
            }
            echo '</select>';
            break;

        case "radio":
            echo '<p>------------------------</p><p>------------------------</p>';
            foreach ($options as $key => $value) {
                echo '<input ' . ($key == $data[$field] ? ' checked ' : '') . 'type="' . $type . '"  name="' . $field . '" id="' . $key . '" value="' . $key . '"><label for="' . $key . '">' . $value . '</label>';
            }
            break;

        default:
            echo '<input type="' . $type . '" class="input-field" name="' . $field . '" value="' . $data[$field] . '" />';
            break;
    }
    echo '</label>';
    if (array_key_exists($field . "Err", $data)) {
        echo '  <span class="error">' . $data[$field . "Err"] . '</span>';
    }
}

function showFormFieldSetEnd()
{
    echo '</fieldset>';
}

function showFormEnd($submitButtonText, $page)
{
    echo '<fieldset>              
              <label><input type="submit" value="' . $submitButtonText . '" /></label>
              <input type="hidden" name="page" value="' . $page . '">                                                
              </fieldset>
          </form>
        </div>';
}
