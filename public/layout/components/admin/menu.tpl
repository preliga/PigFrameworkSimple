<nav class="navbar navbar-expand-lg navbar-light bg-faded py-lg-4">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item {if $path[2] == 'movies'} active {/if} px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="/admin/movies/movies">Movies</a>
                </li>
                <li class="nav-item {if $path[2] == 'repertoire'} active {/if} px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="/admin/repertoire/repertoire">Repertoire</a>
                </li>
                <li class="nav-item px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="/admin/logout">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>