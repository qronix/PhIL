<nav class='navbar navbar-expand-lg navbar-dark'>
    <a class='navbar-brand' href='#'><img src='vendor/icons/Best_Buy_Logo.svg' id='navLogo'><p id='philLogoNav'>PhIL</p></a>
    <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarNavDropdown' aria-controls='navbarNavDropdown' aria-expanded='false' aria-label='Toggle navigation'>
        <span class='navbar-toggler-icon'></span>
    </button>
    <div class='collapse navbar-collapse float-md-right justify-content-end' id='navbarNavDropdown'>
        <ul class='navbar-nav float-xs-right'>
            <li class="nav-item welcome float-xs-right">
                <p>Welcome, <?php echo $_SESSION['username'];?></p>
            </li>
            <li class='nav-item float-xs-right'>
                <a class='nav-link' href='logout.php'>Logout</a>
            </li>
        </ul>
    </div>
</nav>