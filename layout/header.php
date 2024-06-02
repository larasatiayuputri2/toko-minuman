<?php if(isset($_SESSION['id_user']) && $_SESSION['id_user'] !='' ) { ?>
	<button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
	  <span class="navbar-toggler-icon"></span>
	</button>
	<a class="navbar-brand" href="<?= $base_url; ?>">
	  N-TWO
	</a>
	<button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
	  <span class="navbar-toggler-icon"></span>
	</button>
	<ul class="nav navbar-nav ml-auto">
	  <li class="nav-item">
	    <a class="nav-link" href="<?= $base_url; ?>logout.php" style="padding-right: 15px" alt="Logout">
	      <i class="fas fa-sign-out-alt"></i>
	    </a>
	  </li>
	</ul>
<?php } else{ ?>
  <a class="navbar-brand" href="<?= $base_url; ?>">
    N-TWO
  </a>
  <ul class="nav navbar-nav ml-auto">
    <li class="nav-item" style="margin-right: 15px;">
      <a class="btn btn-primary" href="<?= $base_url; ?>login.php" style="padding-right: 15px" alt="Login">
        Login
      </a>
    </li>
    <li class="nav-item" style="margin-right: 15px;">
      <a class="btn btn-success" href="<?= $base_url; ?>register.php" style="padding-right: 15px" alt="Register">
        Register
      </a>
    </li>
  </ul>
<?php } ?>