<?PHP

function showThankYouContent($data)
{
    echo '
        <p>Thank you for your reply!</p>

        <div>Name: ' . $data["salutation"] . " " . $data["name"] . '</div>
        <div>Email: ' . $data["email"] . ' </div>
        <div>Phone: ' . $data["phone"] . '</div>
        <div>Preferred Contact Option: ' . $data["contactOption"] . '</div>
        <div>Message: ' . $data["message"] . '</div>        
    </div> ';
}
