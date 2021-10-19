
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <img style="max-width:30px; margin-top: -7px;" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQXmuQnI6IpPLYNsDQK5TOfvDOK2sTEfFZ1wRdxVQzlhUwkXikpEKfvvdGZ-2gr0RtewYg&usqp=CAU">
    <a class="navbar-brand" href="#">Welcome</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo  FRONT_ROOT."Home/showStudentControlPanelView"?>">Home</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                    Services
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="<?php echo  FRONT_ROOT."Company/showCompanyManagement"?>">Companies</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">View Our Portfolio</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Contact Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo  FRONT_ROOT."Home/Logout"?>">Logout</a>
            </li>

        </ul>
    </div>
</nav>
