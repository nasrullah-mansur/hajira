<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        
        


        <li class=" nav-item {{ Route::is('course.*') ? 'active' : ''}}">
            <a href="{{ route('course.index') }}"><i class="ft-clipboard"></i><span class="menu-title">Courses</span></a>
        </li>

        <li class=" nav-item {{ Route::is('student.*') ? 'active' : ''}}">
            <a href="{{ route('student.index') }}"><i class="ft-clipboard"></i><span class="menu-title">Students</span></a>
        </li>

        <li class=" nav-item {{ Route::is('attendance.*') ? 'active' : ''}}">
            <a href="{{ route('attendance.index') }}"><i class="ft-clipboard"></i><span class="menu-title">Attendance</span></a>
        </li>
        
      </ul>
    </div>
  </div>