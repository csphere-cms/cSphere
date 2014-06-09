<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_headsearch plugin=blog.blog action=default.list search=blog.title_or_tags *}

        <br>

        {* foreach blog *}
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a href="{* link blog/view/id/$blog.blog_id *}">
                            {* var blog.blog_title *}
                        </a>
                    </h4>
                </div>
            </div>
        </div>

        {* else blog *}
            {* lang default.no_record_found *}
        {* endforeach blog *}

        {* raw pages *}

    </div><!--END panel panel-body-->
</div><!--END panel-->
