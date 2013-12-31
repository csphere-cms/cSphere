<div id="errors-latest-box">

    <div class="page-header">
        <h4>{* lang latest_errors *}</h4>
    </div><!--END errors-latest-box page-header-->

    <div class="list-group">
        {* foreach files *}
        <a href="{* link errors/file/date/$files.date$ *}" class="list-group-item">
            <span class="badge">{* var files.entries *}</span>
            {* var files.date *}
        </a>
        {* else files *}
        {* lang no_file *}
        {* endforeach files *}
    </div><!--END lerrors-latest-box ist-group-->

    <button type="submit" class="btn btn-default pull-right" onclick="csphere_ajax_box('errors', 'latest', 'refresh/1')">{* lang refresh *}</button>

</div><!--END errors-latest-box-->