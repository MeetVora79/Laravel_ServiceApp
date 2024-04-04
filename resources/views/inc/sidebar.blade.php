<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="{{route(Auth::user()->getDashboardRouteName())  }}">Service App</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="{{route(Auth::user()->getDashboardRouteName())  }}">SA</a>
    </div>
    <ul class="sidebar-menu">
      <li class="menu-header">Dashboard</li>
      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="bi bi-speedometer2"></i><span>Dashboard</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="{{route(Auth::user()->getDashboardRouteName()) }}">Dashboard</a></li>
        </ul>
      </li>
      @if(auth()->user()->role == 1 || auth()->user()->role == 2)
      <li class="menu-header">Staff Management</li>
      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="bi bi-people"></i> <span>Staff</span></a>
        <ul class="dropdown-menu">

          <li><a class="nav-link" href="{{ route('users.index') }}">All Staff</a></li>

          <li><a class="nav-link" href="{{ route('departments.index') }}">Departments</a></li>

          <li><a class="nav-link" href="{{ route('organizations.index') }}">Organizations</a></li>

        </ul>
      </li>
      <li class="menu-header">Customer Management</li>
      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="bi bi-person"></i> <span>Customer</span></a>
        <ul class="dropdown-menu">

          <li><a class="nav-link" href="{{ route('customers.create') }}">Create Customer</a></li>

          <li><a class="nav-link" href="{{ route('customers.index') }}">All Customers</a></li>

        </ul>
      </li>
      @endif

      @if(auth()->user()->role == 1 || auth()->user()->role == 2)
      <li class="menu-header">Ticket Management</li>
      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="bi bi-ticket-perforated"></i> <span>Tickets</span></a>
        <ul class="dropdown-menu">

          <li><a class="nav-link" href="{{ route('tickets.create') }}">New Ticket</a></li>

          <li><a class="nav-link" href="{{ route('tickets.allocation') }}">Allocated Tickets</a></li>

          <li><a class="nav-link" href="{{ route('tickets.index') }}">All Tickets</a></li>
        </ul>
      </li>
      @elseif(auth()->user()->role == 3)
      <li class="menu-header">Tickets</li>
      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="bi bi-ticket-perforated"></i> <span>Tickets</span></a>
        <ul class="dropdown-menu">

          <li class=""><a class="nav-link" href="{{ route('tickets.create') }}">Create Ticket</a></li>

          <li><a class="nav-link" href="{{ route('myallocation') }}">My Allocated Tickets</a></li>

          <li class=""><a class="nav-link" href="{{ route('mytickets') }}">My Tickets</a></li>
        </ul>
      </li>
      @else
      <li class="menu-header">Tickets</li>
      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="bi bi-ticket-perforated"></i> <span>Tickets</span></a>
        <ul class="dropdown-menu">

          <li class=""><a class="nav-link" href="{{ route('tickets.create') }}">Create Ticket</a></li>

          <li class=""><a class="nav-link" href="{{ route('mytickets') }}">My Tickets</a></li>
        </ul>
      </li>
      @endif

      @if(auth()->user()->role == 1 || auth()->user()->role == 2)
      <li class="menu-header">Asset Management</li>
      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="bi bi-hdd-rack"></i><span>Asset</span></a>
        <ul class="dropdown-menu">

          <li><a class="nav-link" href="{{ route('assets.create') }}">New Asset</a></li>

          <li><a class="nav-link" href="{{ route('assets.index') }}">All Assets</a></li>

        </ul>
      </li>
      @elseif(auth()->user()->role == 3 || auth()->user()->role == 4)
      <li class="menu-header">Asset</li>
      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="bi bi-hdd-rack"></i><span>Asset</span></a>
        <ul class="dropdown-menu">

          <li><a class="nav-link" href="{{ route('assets.myassets') }}">My Assets</a></li>

        </ul>
      </li>
      @endif

      @if(auth()->user()->role == 1 || auth()->user()->role == 2)
      <li class="menu-header">Maintenance Management</li>
      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="bi bi-shield-plus"></i><span>Maintenance</span></a>
        <ul class="dropdown-menu">
        <li><a class="nav-link" href="{{ route('maintenance.index') }}">Create Schedule</a></li>
          <li><a class="nav-link" href="{{ route('maintenance.scheduled') }}">Scheduled Maintenance</a></li>
        </ul>
      </li>
      @elseif(auth()->user()->role == 3)
      <li class="menu-header">Maintenance</li>
      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="bi bi-shield-plus"></i><span>Maintenance</span></a>
        <ul class="dropdown-menu">
        <li><a class="nav-link" href="{{ route('myschedule') }}">My Scheduled List</a></li>
        </ul>
      </li>
      @elseif ( auth()->user()->role == 4)
      <li class="menu-header">Maintenance</li>
      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="bi bi-shield-plus"></i><span>Maintenance</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="{{ route('mymaintenance') }}">My Maintenance</a></li>
        </ul>
      </li>
      @endif

      @if(auth()->user()->role == 1)
      <li class="menu-header">Permissions</li>
      <li class="dropdown">
        <a href="{{ route('permissions.index') }}" class="nav-link"><i class="bi bi-list-stars"></i> <span>Permission List</span></a>
      </li>
      <li class="menu-header">Roles</li>
      <li class="dropdown">
        <a href="{{ route('roles.index') }}" class="nav-link"><i class="bi bi-list-task"></i> <span>Role List </span></a>
      </li>
      @endif

      <li class="menu-header">Setting</li>
      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="bi bi-gear"></i><span>Setting</span></a>
        <ul class="dropdown-menu">
          <a href="{{ route('profile') }}" class="nav-link">
            <i class="far fa-user"></i> Profile
          </a>
          <a href="/logout" class="nav-link text-danger" onclick="event.preventDefault();
                 document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> Logout
          </a>
          <form id="logout-form" action="/logout" method="GET" class="d-none">
            @csrf
          </form>
        </ul>
      </li>
  </aside>
</div>