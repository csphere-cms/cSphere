<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_headsearch plugin=blog.blog action=default.list search=blog.title_or_tags *}

        <br>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>
                        <a href="{* raw order.blog_title *}">{* lang blog.title *}</a> {* raw arrow.blog_title *}
                    </th>
                    <th>
                        <a href="{* raw order.blog_date *}">{* lang default.date *}</a> {* raw arrow.blog_date *}
                    </th>
                    <th>
                        {* lang default.tags *}
                    </th>
                </tr>
            </thead><!--END table thead-->

            <tbody>
                {* foreach blog *}
                <tr>
                    <td>
                        <a href="{* link blog/view/id/$blog.blog_id *}">{* var blog.blog_title *}</a>
                    </td>
                    <td>
                        {* date blog.blog_date *}
                    </td>
                    <td>
                        {* var blog.blog_tags *}
                    </td>
                </tr>
                {* else blog *}
                <tr>
                    <th class="text-center" colspan="3">
                        {* lang default.no_record_found *}
                    </th>
                </tr>
                {* endforeach blog *}
            </tbody><!--END table tbody-->
        </table><!--END table-->

        {* raw pages *}

    </div><!--END panel panel-body-->
</div><!--END panel-->
