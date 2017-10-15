<div class="bg-faded" style="padding: 15px; text-align: center;">

    <div class="text-center mt-4">
        <h1 class="page-header">{$movie['title']}</h1>
    </div>

    <div class="text-center mt-4">
        <div class="text-heading text-muted text-lg">Choose day/s</div>
        {foreach $days as $day}
            <button class="btn btn-success showShows" showsClass="{$day|date_format:"Ymd"}" active="1">
                {$day}
            </button>
        {/foreach}
    </div>


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
            </tr>
            </thead>
            <tbody>
            {assign var="i" value=1}
            {foreach $shows as $show}
                <tr class="{$show['term']|date_format:"Ymd"}" style="display: none;">
                    <td>{$i}</td>
                    <td>
                        <img src="data:image/png;base64,{if !empty($show['poster'])} {$show['poster']} {else} {$emptyPoster} {/if}"
                             width="200"/>
                    </td>
                    <td>{$show['title']}</td>
                    <td>{$show['term']}</td>
                    <td>{$show['duration']}</td>
                    <td>
                        <button class="btn btn-success"
                                onclick="window.location = '/movie/stepTwo?showId={$show['id']}'"
                                style="cursor: pointer;">Book Tickets
                        </button>
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