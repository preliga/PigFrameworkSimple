<br>
<nav class="navbar navbar-expand-lg navbar-light bg-faded py-lg-2">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item {if $path[3] == 'repertoire'} active {/if} px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="/admin/repertoire/repertoire">Repertoire</a>
                </li>
                <li class="nav-item px-lg-4">
                    <a class="nav-link {if $path[3] == 'addshow'} active {/if} text-uppercase text-expanded" href="/admin/repertoire/addshow">Add Show</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="bg-faded" style="padding: 10px; text-align: center;">
    <h1 class="page-header">Repertoire</h1>

    <div style="display: inline-block; width: 80%;">
        <table class="table table-hover" style="text-align: left;">
            <thead>
            <tr>
                <th>Lp.</th>
                <th>Poster</th>
                <th>Title</th>
                <th>Term</th>
                <th>Duration</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            {assign var="i" value=1}
            {foreach $shows as $show}
                <tr>
                    <td>{$i}</td>
                    <td>
                        <img src="data:image/png;base64,{if !empty($show['poster'])} {$show['poster']} {else} {$emptyPoster} {/if}" width="200"/>
                    </td>
                    <td>{$show['title']}</td>
                    <td>{$show['term']}</td>
                    <td>{$show['duration']}</td>
                    <td>
                        <a href="/admin/repertoire/editshow?showId={$show['id']}"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></a>
                    </td>
                    <td>
                        <a href="/admin/repertoire/removeshow?showId={$show['id']}"><i class="fa fa-times fa-2x" aria-hidden="true"></i></a>
                    </td>
                    <td>
                        <a href="/admin/repertoire/seats?showId={$show['id']}"><i class="fa fa-users fa-2x" aria-hidden="true"></i></a>
                    </td>
                </tr>
                {assign var="i" value=$i + 1}
                {foreachelse}
                <tr>
                    <td colspan="5">
                        <span> List shows is empty </span>
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
</div>