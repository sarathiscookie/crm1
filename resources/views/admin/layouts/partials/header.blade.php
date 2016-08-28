<header class="site-header">
  <a href="#" class="brand-main">
    <strong>FCG</strong>CRM
    <img src="/assets/admin/img/logo-mobile.png" id="logo-mobile" alt="Laraspace Logo" class="hidden-md-up">
  </a>
  <a href="#" class="nav-toggle">
    <div class="hamburger hamburger--htla">
      <span>toggle menu</span>
    </div>
  </a>

    <ul class="action-list">
      <li>
        <div class="form-group navbar-form navbar-right" role="search">
          <input type="text" id="searchkey" class="form-control" placeholder="{{ trans('messages.headerSearchPlaceholder') }}" autocomplete="off">
          <div style="margin-top: 10px;position: absolute; z-index: 100; background: #ffffff; padding: 10px; display: none;" id="navSrchBox" class="table-bordered col-md-12"></div>
        </div>
      </li>
      <!--<li>
        <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-plus"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item" href="#"><i class="fa fa-edit"></i> New Post</a>
          <a class="dropdown-item" href="#"><i class="fa fa-tag"></i> New Category</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#"><i class="fa fa-star"></i> Separated link</a>
        </div>
      </li>
      <li>
        <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bell"></i></a>
        <div class="dropdown-menu dropdown-menu-right notification-dropdown">
          <h6 class="dropdown-header">Notifications</h6>
          <a class="dropdown-item" href="#"><i class="fa fa-user"></i> New User was Registered</a>
          <a class="dropdown-item" href="#"><i class="fa fa-comment"></i> A Comment has been posted.</a>
        </div>
      </li>-->
      <li>
        <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog fa-lg" aria-hidden="true"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right notification-dropdown">
          <a class="dropdown-item" href="#"><i class="fa fa-user"></i> {{Auth::user()->name}}</a>
          <a class="dropdown-item" href="/logout"><i class="fa fa-sign-out"></i> Logout</a>
        </div>
      </li>
    </ul>
</header>
