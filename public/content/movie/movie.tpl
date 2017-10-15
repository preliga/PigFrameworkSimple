<div class="bg-faded" style="padding: 15px; text-align: center;">

    <div class="text-center mt-4">
        <h1 class="page-header">{$movie['title']}</h1>
    </div>

    <button class="btn btn-success" onclick="window.location = '/movie/stepOne?movieId={$movie['id']}'" style="cursor: pointer;">Book Tickets</button>
    <div>
        <div class="container">
            <div class="well well-sm">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">
                                Title
                            </label>
                            <input type="text" class="form-control" name="title" required="required" value="{$movie['title']}" readonly/>
                        </div>
                        <div class="form-group">
                            <label for="name">
                                Duration
                            </label>
                            <input type="time" class="form-control" name="duration" required="required" value="{$movie['duration']}" readonly/>
                        </div>
                        <div class="form-group">
                            <label for="name">
                                Category
                            </label>
                            <input type="text" class="form-control" name="duration" required="required" value="{$movie['category']}" readonly/>
                        </div>
                        <div class="form-group">
                            <label for="name">
                                Description
                            </label>
                            <textarea name="description" class="form-control" rows="9" cols="25" readonly>{$movie['description']}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <br>
                        {if !empty($movie['poster'])}
                            <img style="margin: 10px;" src="data:image/png;base64,{$movie['poster']}" width="600"/>
                        {/if}
                        <iframe style="margin: 10px;" width="600" height="350" src="{$movie['trailer']}" ></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>