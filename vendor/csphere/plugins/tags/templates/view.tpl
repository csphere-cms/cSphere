<div id="tags-view" class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=tags action=default.view *}

        <br />

        <table class="table table-striped table-hover">
            <tbody>
                <tr>
                    <th>
                        {* lang name *}
                    </th>
                    <td>
                        {* var tags.tag_name *}
                    </td>
                </tr>
                <tr>
                    <th>
                        {* lang since *}
                    </th>
                    <td>
                        {* date tags.tag_since *}
                    </td>
                </tr>
            </tbody><!--END table tbody-->
        </table><!--END table-->

    </div><!--END panel panel-body-->
</div><!--END panel-->