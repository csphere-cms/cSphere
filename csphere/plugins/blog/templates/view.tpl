<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=faq.faq action=default.view *}

        <br>

        <table class="table table-striped table-hover">
            <tbody>
                <tr>
                    <th>
                        {* lang faq.question *}
                    </th>
                    <td>
                        {* var faq.faq_question *}
                    </td>
                </tr>
                <tr>
                    <th>
                        {* lang faq.answer *}
                    </th>
                    <td>
                        {* var faq.faq_answer *}
                    </td>
                </tr>
                <tr>
                    <th>
                        {* lang default.tags *}
                    </th>
                    <td>
                        {* foreach faq.faq_tags *}
                        <a href="{* link faq/list/search/$faq_tags.tag_name$ *}">{* var faq_tags.tag_name *}</a> 
                        {* endforeach faq.faq_tags *}
                    </td>
                </tr>
            </tbody><!--END table tbody-->
        </table><!--END table-->

    </div><!--END panel panel-body-->
</div><!--END panel-->