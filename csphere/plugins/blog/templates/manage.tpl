<div id="blog-manage" class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_headsearch plugin=blog.blog action=default.manage search=blog.title_or_tags *}

        <br>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>
                        <a href="{* raw order.blog_title *}">{* lang blog.title *}</a> {* raw arrow.blog_title *}
                    </th>
                    <th>
                        {* lang default.tags *}
                    </th>
                    <th colspan="2">
                        {* lang default.options *}
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
                        {* var blog.blog_tags *}
                    </td>
                    <td>
                        <a href="{* link blog/edit/id/$blog.blog_id *}">{* lang default.edit *}</a>
                    </td>
                    <td>
                        <a href="{* link blog/remove/id/$blog.blog_id *}">{* lang default.remove *}</a>
                    </td>
                </tr>
                {* else blog *}
                <tr>
                    <th class="text-center" colspan="5">
                        {* lang default.no_record_found *}
                    </th>
                </tr>
                {* endforeach blog *}
            </tbody><!--END table tbody-->
        </table><!--END table-->

        {* raw pages *}

    </div><!--END panel panel-body-->
</div><!--END panel-->
