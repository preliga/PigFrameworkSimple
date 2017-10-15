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
    <h1 class="page-header">Edit movies</h1>


    <div>
        <div class="container">
            <div class="well well-sm">
                <form action="/admin/movies/editmovie?movieId={$movie['id']}" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">
                                    Title
                                </label>
                                <input type="text" class="form-control" name="title" required="required" value="{$movie['title']}"/>
                            </div>
                            <div class="form-group">
                                <label for="name">
                                    Trailer link
                                </label>
                                <input type="text" class="form-control" name="trailer" value="{$movie['trailer']}"/>
                            </div>
                            <div class="form-group">
                                <label for="name">
                                    Duration
                                </label>
                                <input type="time" class="form-control" name="duration" required="required" value="{$movie['duration']}"/>
                            </div>
                            <div class="form-group">
                                <label for="name">
                                    Category
                                </label>
                                <select name="category" class="form-control" required="required">
                                    {*<optgroup label="Category">*}
                                        <option value="">-- Choose category --</option>
                                        {foreach $category as $cat}
                                            <option value="{$cat['id']}" {if $cat['id'] == $movie['categoryId']} selected {/if}>{$cat['name']}</option>
                                        {/foreach}
                                    {*</optgroup>*}
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">
                                    Description
                                </label>
                                <textarea name="description" class="form-control" rows="9" cols="25">{$movie['description']}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="name">
                                    Poster
                                </label>
                                <input type="file" class="form-control" name="poster" />
                            </div>
                            <img src="data:image/png;base64,{$movie['poster']}" width="600"/>
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