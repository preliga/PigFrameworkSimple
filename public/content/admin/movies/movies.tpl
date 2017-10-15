<br>
<nav class="navbar navbar-expand-lg navbar-light bg-faded py-lg-2">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item {if $path[3] == 'movies'} active {/if} px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="/admin/movies/movies">Movies</a>
                </li>
                <li class="nav-item px-lg-4">
                    <a class="nav-link {if $path[3] == 'addmovies'} active {/if} text-uppercase text-expanded" href="/admin/movies/addmovie">Add Movies</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="bg-faded" style="padding: 10px; text-align: center;">
    <h1 class="page-header">Movies</h1>

    <div style="display: inline-block; width: 80%;">
        <table class="table table-hover" style="text-align: left;">
            <thead>
                <tr>
                    <th>Lp.</th>
                    <th>Poster</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Duration</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            {assign var="i" value=1}
                {foreach $movies as $movie}
                    <tr>
                        <td>{$i}</td>
                        <td>
                            <img src="data:image/png;base64,{if !empty($movie['poster'])} {$movie['poster']} {else} {$emptyPoster} {/if}" width="200"/>
                        </td>
                        <td>{$movie['title']}</td>
                        <td>{$movie['category']}</td>
                        <td>{$movie['duration']}</td>
                        <td>
                            <a href="/admin/movies/editmovie?movieId={$movie['id']}"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></a>
                        </td>
                        <td>
                            <a href="/admin/movies/removemovie?movieId={$movie['id']}"><i class="fa fa-times fa-2x" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                    {assign var="i" value=$i + 1}
                {foreachelse}
                    <tr>
                        <td colspan="5">
                            <span> List movies is empty </span>
                        </td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
</div>