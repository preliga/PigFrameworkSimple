<div class="container">

    <div class="bg-faded p-4 my-4">
        <!-- Welcome Message -->
        <div class="text-center mt-4">
            <div class="text-heading text-muted text-lg">Welcome To Cinema Center</div>
            <h1 class="my-2">Choose movie</h1>
        </div>

        <!-- Image Carousel -->
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                {assign var="i" value=0}
                {foreach $movies as $movie}
                    <li data-target="#carouselExampleIndicators" data-slide-to="{$i}" {if $i == 1}active{/if}></li>
                    {assign var="i" value=$i + 1}
                {/foreach}
            </ol>
            <div class="carousel-inner" role="listbox">
                {assign var="i" value=0}
                {foreach $movies as $movie}
                    <div class="carousel-item {if $i == 0}active{/if}">
                        <img class="d-block img-fluid w-100" src="data:image/png;base64,{if !empty($movie['poster'])} {$movie['poster']} {else} {$emptyPoster} {/if}" style="width: 600px; height: 400px;" alt="">
                        <div class="carousel-caption d-none d-md-block">
                            <h1 class="text-shadow" style="cursor: pointer;" onclick="window.location = '/movie/movie?movieId={$movie['movieId']}'">
                                <strong>
                                    {$movie['title']}
                                </strong>
                            </h1>
                        </div>
                    </div>
                    {assign var="i" value=$i + 1}
                {/foreach}
            </div>

            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

    </div>

</div>
