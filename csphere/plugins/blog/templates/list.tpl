<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_headsearch plugin=blog.blog action=default.list search=blog.questionOrTag *}

        <br>

        {* foreach blog *}
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse{* var blog.blog_id *}">
                            {* var blog.blog_question *}
                        </a>
                    </h4>
                </div>
                
                <div id="collapse{* var faq.faq_id *}" class="panel-collapse collapse">
                    <div class="panel-body">
	                   {* var blog.blog_answer *}
	                </div>
                </div>
            </div>
        </div>

        {* else blog *}
            {* lang default.no_record_found *}
        {* endforeach blog *}

        {* raw pages *}

    </div><!--END panel panel-body-->
</div><!--END panel-->