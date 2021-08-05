<nav class="sidebar">
  <div class="sidebar-header">
    <a href="#" class="sidebar-brand">
      Bookie<span>1.0</span>
    </a>
    <div class="sidebar-toggler not-active">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
  <div class="sidebar-body">
    <ul class="nav">
      <li class="nav-item nav-category">Main</li>
      <li class="nav-item {{ active_class(['/']) }}">
        <a href="{{ url('/') }}" class="nav-link">
          <i class="link-icon" data-feather="box"></i>
          <span class="link-title">Dashboard</span>
        </a>
      </li>
      <li class="nav-item nav-category">transactions</li>
      <li class="nav-item {{ active_class(['transactions/*']) }}">
        <a class="nav-link" data-toggle="collapse" href="#email" role="button" aria-expanded="{{ is_active_route(['transactions/*']) }}" aria-controls="email">
          <i class="link-icon" data-feather="dollar-sign"></i>
          <span class="link-title">Transactions</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse {{ show_class(['transactions/*']) }}" id="email">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ url('/transactions') }}" class="nav-link {{ active_class(['transactions']) }}">All transactions</a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/orders') }}" class="nav-link {{ active_class(['orders']) }}">Orders missing</a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/transactions/import') }}" class="nav-link {{ active_class(['import']) }}">Import</a>
            </li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</nav>
