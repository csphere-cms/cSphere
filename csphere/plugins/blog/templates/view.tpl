<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=blog.blog action=default.view *}

        <br>

        <table class="table table-striped table-hover">
            <tbody>
                <tr>
                    <th>
                        {* lang blog.question *}
                    </th>
                    <td>
                        {* var blog.blog_question *}
                    </td>
                </tr>
                <tr>
                    <th>
                        {* lang blog.answer *}
                    </th>
                    <td>
                        {* var blog.blog_answer *}
                    </td>
                </tr>
                <tr>
                    <th>
                        {* lang default.tags *}
                    </th>
                    <td>
                        {* foreach blog.blog_tags *}
                        <a href="{* link blog/list/search/$blog_tags.tag_name$ *}">{* var blog_tags.tag_name *}</a> 
                        {* endforeach blog.blog_tags *}
                    </td>
                </tr>
            </tbody><!--END table tbody-->
        </table><!--END table-->

    </div><!--END panel panel-body-->
</div><!--END panel-->