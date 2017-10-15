<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<div class="bg-faded" style="padding: 15px; text-align: center;">

    <div class="text-center mt-4">
        <h1 class="page-header">{$show['title']}</h1>
    </div>

    <div class="row">
        <div class="col-md-5">
            <br>
            {if !empty($show['poster'])}
                <img style="margin: 10px;" src="data:image/png;base64,{$show['poster']}" width="100%"/>
            {/if}
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="name">
                    Duration
                </label>
                <input type="time" class="form-control" name="duration" required="required" value="{$show['duration']}" readonly/>
            </div>
            <div class="form-group">
                <label for="name">
                    Category
                </label>
                <input type="text" class="form-control" name="duration" required="required" value="{$show['category']}" readonly/>
            </div>
            <div class="form-group">
                <label for="name">
                    Term
                </label>
                <input type="text" class="form-control" name="duration" required="required" value="{$show['term']}" readonly/>
            </div>
        </div>
        <div class="col-md-5">
            <br>
            <iframe style="margin: 10px;" width="600" height="350" src="https://www.youtube.com/embed/yRh-dzrI4Z4" ></iframe>
        </div>
    </div>
    <br><br>

    <span>
        <strong>SCREEN</strong>
    </span>

    <form action="/movie/bookTickets?showId={$show['id']}" method="post">
        {for $i = 0; $i < 5; $i++}
            <div class="text-center mt-4">
                {for $j = 0; $j < 8; $j++}
                <div class="btn-group" data-toggle="buttons" style="margin: 10px;">
                    <label class="btn {if !empty($seats[$i * 8 + $j + 1])} btn-default active {else} btn-success {/if}" style="width: 50px">
                        {$i * 8 + $j + 1}
                        <br>
                        <input type="checkbox" autocomplete="off" name="{$i * 8 + $j + 1}" {if !empty($seats[$i * 8 + $j + 1])} checked disabled{/if} >
                        <span class="glyphicon glyphicon-ok"></span>
                    </label>
                </div>
                {/for}
            </div>
            <br>
        {/for}

        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                {if !empty($bookTicketsError)}
                    <div class="form-group">
                        <strong>
                            <span style="color: #c25d4e;">{$bookTicketsError}</span>
                        </strong>
                    </div>
                {/if}
                {if !empty($bookTicketsMessage)}
                    <div class="form-group">
                        <strong>
                            <span style="color: #188634;">{$bookTicketsMessage}</span>
                        </strong>
                    </div>
                {/if}
                <div class="form-group">
                    <label for="name">
                        Email
                    </label>
                    <input type="email" class="form-control" name="email" required="required" value="" style="width: 100%;"/>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary"> Book tickets</button>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>

    </form>

    <br><br><br>
</div>

<style>
    .btn span.glyphicon {
        opacity: 0;
    }
    .btn.active span.glyphicon {
        opacity: 1;
    }
</style>