<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=blog.blog action=default.view *}

        <br>

        <table class="table table-striped table-hover">
            <tbody>
                <tr>
                    <th>
                        {* lang blog.title *}
                    </th>
                    <td>
                        {* var blog.blog_title *}
                    </td>
                </tr>
                <tr>
                    <th>
                        {* lang default.since *}
                    </th>
                    <td>
                        {* date blog.blog_date *}
                    </td>
                </tr>
                <tr>
                    <th>
                        {* lang blog.content *}
                    </th>
                    <td>
                        {* var blog.blog_content *}
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
