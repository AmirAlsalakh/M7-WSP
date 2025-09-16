<form action="metod/saveGeneralMessageMsg.php" method="post">
    <textarea name="message" placeholder="Kommentera artikeln ..." required></textarea><br />
    <input type="hidden" name="CSRFMessageToken" value="<?php echo $_SESSION['CSRFMessageToken']; ?>">
    <input type="hidden" name="pid" value="<?php echo $post['pid']; ?>">
    <input type="submit" value="Svara">
</form>