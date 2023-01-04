<div class="container-fluid">
    <div id="two-column-menu">
    </div>
    <ul class="navbar-nav" id="navbar-nav">
        <li class="menu-title"><span data-key="t-menu">Menu</span></li>
        <li class="nav-item">
            <a class="nav-link menu-link" href="admin">
                <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboard</span>
            </a>
        </li> <!-- end Dashboard Menu -->

        <li class="nav-item">
            <a class="nav-link menu-link" href="client_exposure">
                <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Client Exposer Analysis</span>
            </a>
        </li> <!-- end Dashboard Menu -->

       <!--
        <li class="nav-item">
            <a class="nav-link menu-link" href="branch_wise_collateral">
                <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Branch Collateral Analysis</span>
            </a>
        </li> 
-->
        
        <!-- end Dashboard Menu -->


        <li class="nav-item">
            <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                <i class="ri-user-fill"></i> <span data-key="t-apps">User Management</span>
            </a>
            <div class="collapse menu-dropdown" id="sidebarApps">
                <ul class="nav nav-sm flex-column sub">
                    <li class="nav-item">
                        <a href="#sidebarProjects" class="nav-link" data-key="t-projects">
                            Add User
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#sidebarProjects" class="nav-link" data-key="t-projects">
                            Manage User
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#sidebarProjects" class="nav-link" data-key="t-projects">
                            My Account
                        </a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</div>