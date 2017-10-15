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
    <h1 class="page-header">Add Show</h1>

    <div>
        <div class="container">
            <div class="well well-sm">
                <form action="/admin/repertoire/addshow" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">
                                    Movies
                                </label>
                                <select name="movieId" class="form-control" required="required">
                                    <option value="">-- Choose movie --</option>
                                    {foreach $movies as $movie}
                                        <option value="{$movie['id']}">{$movie['title']}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">
                                    Term
                                </label>
                                <input type="text" class="form-control datetimepicker" name="term" required="required" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                Save
                            </button>
                        </div>
                    </div>
                </form>
                {if !empty($saveCorrect)}
                    <br>
                    <strong><span style="color: #00dd1c">Save correct</span></strong>
                {/if}
            </div>
        </div>
    </div>
</div>