<div class="container-fluid col-md-2 clearfix" id="sideNav">
<ul id="sideNavLinks">
    <li class="sideNavLink"><i class="fa fa-users sideNavIcon" aria-hidden="true"></i><a href="registeruser.php">Users</a></li>
    <li class="sideNavLink"><i class="fa fa-mobile sideNavIcon largerIcon" aria-hidden="true"></i><a href="phonelist.php">Phone Inventory</a></li>
<!--    <li class="sideNavLink"><i class="fa fa-database sideNavIcon dbIcon aria-hidden="true"></i><a href="managedb.php">Manage Database</a></li>-->
    <div class="dropdown">
        <i class="fa fa-database sideNavIcon dbIcon aria-hidden="true"></i><a class="dropdown-toggle" data-toggle="dropdown" href="managedb.php">Manage Database</a>
<!--        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
<!--            Dropdown button-->
<!--        </button>-->
        <div class="dropdown-menu dbDropMenu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="vendorpanel.php">Vendors</a>
            <a class="dropdown-item" href="carrierpanel.php">Carriers</a>
            <a class="dropdown-item" href="phonepanel.php">Phones</a>
        </div>
    </div>
<!--    <li class="sideNavLink"><i class="fa fa-check sideNavIcon"></i><a href="phonecheckout.php">Checkout phone</a></li>-->
<!--    <li class="sideNavLink"><i class="fa fa-mobile sideNavIcon largerIcon" aria-hidden="true"></i><a href="phonecheckout.php">Checkout phone</a></li>-->
</ul>
</div>
