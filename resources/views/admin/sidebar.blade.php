<div class="app-main">
    <div class="app-sidebar sidebar-shadow">
        <div class="app-header__logo">
            <div class="logo-src"></div>
            <div class="header__pane ml-auto">
                <div>
                    <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                    <span class="hamburger-box">
                                        <span class="hamburger-inner"></span>
                                    </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="app-header__mobile-menu">
            <div>
                <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                </button>
            </div>
        </div>
        <div class="app-header__menu">
                        <span>
                            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                                <span class="btn-icon-wrapper">
                                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                                </span>
                            </button>
                        </span>
        </div>    <div class="scrollbar-sidebar" style="overflow:auto">
            <div class="app-sidebar__inner">
                <ul class="vertical-nav-menu" id="Mysidebar" >
                    <li class="app-sidebar__heading">Dashboards</li>
                    <li>
                        <a href="{{ route('admin_dashboard') }}" class="probtn">
                            <i class="metismenu-icon pe-7s-graph"></i>
                            Statistics
                        </a>
                    </li>
                    <li class="app-sidebar__heading">Manage</li>
                    <li>
                        <a href="{{route('admin_users')}}" class="probtn">
                            <i class="metismenu-icon pe-7s-users">
                            </i>User(s)
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin_applications')}}" class="probtn">
                            <i class="metismenu-icon pe-7s-file">
                            </i>Application(s)
                        </a>
                    </li>
{{--                    <li class="app-sidebar__heading">Website Content</li>--}}

                    <li class="app-sidebar__heading">Account Settings</li>
                    <li>
                        <a href="#" class="probtn">
                            <i class="metismenu-icon pe-7s-settings">
                            </i>Account settings
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <script>

        // Add active class to the current button (highlight it)
        var header = document.getElementById("Mysidebar");
        var btns = header.getElementsByClassName("probtn");
        for (var i = 0; i < btns.length; i++) {
            btns[i].addEventListener("click", function() {
                var current = document.getElementsByClassName("mm-active");
                current[0].className = current[0].className.replace("mm-active", "");
                this.className += " mm-active";
            });
        }
    </script>
