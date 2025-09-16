<form>
    <input type="text" name="searchUsr" placeholder="Sök vänner" size="30" />
    <button class="search" onclick="location.href='index.php?get=searchFriends'"><img src="/images/searchIcon.png" alt="Search" /></button>
</form>

<nav>
    <ul>
        <li><a href="index.php?get=user"><?php echo $_SESSION['name']; ?></a></li>
        <li><a href="index.php?get=flow">Flöde</a></li>
        <li><a href="index.php?get=friends">Vänner</a></li>
        <li><a href="index.php?get=preferences">Inställningar</a></li>
    </ul>
</nav>
<button class="sign" onclick="location.href='index.php?get=logOut'"><img src="/images/logout.png" alt="Logga Ut" /></button>