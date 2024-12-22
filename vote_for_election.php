<?php
// Display the message if set in the URL
if (isset($_GET['message'])) {
    echo '<p>' . htmlspecialchars($_GET['message']) . '</p>';
}
?>
