<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_headsearch plugin=faq.faq action=default.list search=faq.questionOrTag *}

        <br>

        {* foreach faq *}
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse{* var faq.faq_id *}">
                            {* var faq.faq_question *}
                        </a>
                    </h4>
                </div>
                
                <div id="collapse{* var faq.faq_id *}" class="panel-collapse collapse">
                    <div class="panel-body">
	                   {* var faq.faq_answer *}
	                </div>
                </div>
            </div>
        </div>

        {* else faq *}
            {* lang default.no_record_found *}
        {* endforeach faq *}

        {* raw pages *}

    </div><!--END panel panel-body-->
</div><!--END panel-->