<div class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header">
                <h3>
                    {* lang groups *} - {* if action == 'team' *}{* lang team *}{* else action *}{* lang default.view *}{* endif action *}
                </h3><!--END header page-header headline-->
            </section><!--END header page-header-->
        </header><!--END header-->

        <br />

        <table class="table table-striped table-hover">
            <tr>
                <th>
                    {* lang users.user_name *}
                </th>
                <td>
                    {* var groups.group_name *}
                </td>
            </tr>
            <tr>
                <th>
                    {* lang default.since *}
                </th>
                <td>
                    {* date groups.group_since *}
                </td>
            </tr>
            <tr>
                <th>
                    {* lang url *}
                </th>
                <td>
                    {* if groups.group_url == '' *}
                    --
                    {* else groups.group_url *}
                    <a href="{* var groups.group_url *}">{* var groups.group_url *}</a>
                    {* endif groups.group_url *}
                </td>
            </tr>
            <tr>
                <th>
                    {* lang info *}
                </th>
                <td>
                    {* var groups.group_info *}
                </td>
            </tr>
        </table><!--END table-->

    </div><!--END panel-body-->
</div><!--END panel-->