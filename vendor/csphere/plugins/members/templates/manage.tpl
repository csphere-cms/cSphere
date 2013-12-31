<div id="users-manage" class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header clearfix">
                <h3 class="pull-left">
                    {* lang members *} - {* lang default.manage *}
                </h3><!--END header page-header headline-->

                <div class="btn-group pull-right">
                    <a href="{* link members/create *}" class="btn btn-primary">{* lang default.create *}</a>

                </div><!--END header page-header btn-group-->
            </section><!--END header page-header-->

            <section class="clearfix">
                <span class="help-block pull-left">
                    {* lang default.records *}: {* var records *}{* if search != '' *} - {* lang default.hits *}: {* var hits *}{* endif search *}
                </span><!--END header help-block-->

                <div class="col-md-5 row pull-right">
                    <form class="form-inline" role="form" action="{* link members/manage *}" method="POST">
                        <div class="input-group">
                            <input type="search" class="form-control" id="inputSearch" name="search" maxlength="40" size="20" value="{* var search *}" placeholder="{* lang group_or_user *}" />
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">{* lang default.search *}</button>
                            </span>
                        </div><!--END header div search input-group-->
                    </form><!--END header div search form-->
                </div><!--END header div search-->
            </section><!--END header div-->
        </header><!--END header-->

        <br />

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>
                        <a href="{* raw order.group_name *}">{* lang group_name *}</a> {* raw arrow.group_name *}
                    </th>
                    <th>
                        <a href="{* raw order.user_name *}">{* lang user_name *}</a> {* raw arrow.user_name *}
                    </th>
                    <th colspan="2">
                        {* lang default.options *}
                    </th>
                </tr>
            </thead><!--END table thead-->

            <tbody>
                {* foreach members *}
                <tr>
                    <td>
                        <a href="{* link groups/view/id/$members.group_id *}">{* var members.group_name *}</a>
                    </td>
                    <td>
                        <a href="{* link users/view/id/$members.user_id *}">{* var members.user_name *}</a>
                    </td>
                    <td>
                        <a href="{* link members/edit/id/$members.member_id *}">{* lang default.edit *}</a>
                    </td>
                    <td>
                        <a href="{* link members/remove/id/$members.member_id *}">{* lang default.remove *}</a>
                    </td>
                </tr>
                {* else members *}
                <tr>
                    <th colspan="4" class="text-center">
                        {* lang default.no_record_found *}
                    </th>
                </tr>
                {* endforeach members *}
            </tbody><!--END table tbody-->
        </table><!--END table-->

        {* raw pages *}

    </div><!--END panel panel-body-->
</div><!--END panel-->