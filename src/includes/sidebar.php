<div class='container-fluid col-md-2 clearfix' id='sideNav'>
<ul id='sideNavLinks'>
    <?php 
    
        if(isset($_SESSION['role'])&&!empty($_SESSION['role'])&&(
            $_SESSION['role']=='admin')){
            echo "<li class='sideNavLink'><i class='fa fa-users sideNavIcon' aria-hidden='true'></i><a href='registeruser.php'>Users</a></li>";
        }
    ?>

    <li class='sideNavLink'><i class='fa fa-mobile sideNavIcon largerIcon' aria-hidden='true'></i><a href='phonelist.php'>Phone Inventory</a></li>
<!--    <li class='sideNavLink'><i class='fa fa-database sideNavIcon dbIcon aria-hidden='true'></i><a href='managedb.php'>Manage Database</a></li>-->
    <?php


    if(isset($_SESSION['role'])&&!empty($_SESSION['role'])&&(
            $_SESSION['role']=='admin'||$_SESSION['role']=='manager'||$_SESSION['role']=='superuser')){
        $display ="<div class='dropdown'>";
        $display.="<i class='fa fa-database sideNavIcon dbIcon aria-hidden='true'></i><a class='dropdown-toggle' data-toggle='dropdown' href='managedb.php'>Manage Database</a>";
        $display.="<div class='dropdown-menu dbDropMenu' aria-labelledby='dropdownMenuButton'>";
        $display.="<a class='dropdown-item' href='vendorpanel.php'>Vendors</a>";
        $display.="<a class='dropdown-item' href='phonepanel.php'>Phones</a>";
        $display.="</div>";
        $display.="</div>";
        echo $display;

    }

    ?>


<!--    <li class='sideNavLink'><i class='fa fa-check sideNavIcon'></i><a href='phonecheckout.php'>Checkout phone</a></li>-->
<!--    <li class='sideNavLink'><i class='fa fa-mobile sideNavIcon largerIcon' aria-hidden='true'></i><a href='phonecheckout.php'>Checkout phone</a></li>-->
</ul>
</div>
