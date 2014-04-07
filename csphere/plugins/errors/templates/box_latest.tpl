<div id="errors-latest-box">

    <div class="page-header">
        <h4>{* lang errors.latest_errors *}</h4>
    </div><!--END errors-latest-box page-header-->

    <div class="list-group">
        {* foreach files *}
        <a href="{* link errors/file/date/$files.date$ *}" class="list-group-item">
            <span class="badge">{* var files.entries *}</span>
            {* var files.date *}
        </a>
        {* else files *}
        {* lang errors.no_file *}
        {* endforeach files *}
    </div><!--END lerrors-latest-box ist-group-->

    {* tpl default/com_box_get caption=errors.refresh plugin=errors box=latest *}

</div><!--END errors-latest-box-->
