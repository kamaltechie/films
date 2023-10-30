<nav class="main-navbar navbar navbar-expand-lg navbar-light sticky-top" style="background-color: #3B3131;">
    <button class="sidebar-toggle-button" data-sidebar-state="open">
        <i class="fa fa-bars"></i>
    </button>
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0"></ul>
    <div class="user-logout">
        <form action="../authentication/login.php" method="post">
            <button id="logoutButton" name="logout_button" type="submit" class="btn transparent-bg text-white align-items-center">
                <i class="fa fa-sign-out mr-1" aria-hidden="true"></i>
                Logout
            </button>
        </form>
    </div>
</nav>
