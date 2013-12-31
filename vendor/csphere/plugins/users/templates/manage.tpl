<div id="users-manage" class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header clearfix">
                <h3 class="pull-left">
                    {* lang users *} - {* lang default.manage *}
                </h3><!--END header page-header headline-->

                <div class="btn-group pull-right">
                    <a href="{* link users/create *}" class="btn btn-primary">{* lang default.create *}</a>

                    <button type="button" class="btn btn-primary dropdown-toggle" id="dropdownOptions" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>

                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownOptions">
                        <li role="presentation"><a href="{* link users/options *}" role="menuitem" tabindex="-1">{* lang default.options *}</a></li>
                    </ul>
                </div><!--END header page-header btn-group-->
            </section><!--END header page-header-->

            <section class="clearfix">
                <span class="help-block pull-left">
                    {* lang default.records *}: {* var records *}{* if search != '' *} - {* lang default.hits *}: {* var hits *}{* endif search *}
                </span><!--END header help-block-->

                <div class="col-md-5 row pull-right">
                    <form class="form-inline" role="form" action="{* link users/manage *}" method="POST">
                        <div class="input-group">
                            <input type="search" class="form-control" id="inputUserName" name="search" maxlength="40" size="20" value="{* var search *}" placeholder="{* lang name *}" />
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
                        <a href="{* raw order.user_name *}">{* lang name *}</a> {* raw arrow.user_name *}
                    </th>
                    <th>
                        <a href="{* raw order.user_since *}">{* lang since *}</a> {* raw arrow.user_since *}
                    </th>
                    <th colspan="3">
                        {* lang default.options *}
                    </th>
                </tr>
            </thead><!--END table thead-->

            <tbody>
                {* foreach users *}
                <tr>
                    <td>
                        <a href="{* link users/view/id/$users.user_id *}">{* var users.user_name *}</a>
                    </td>
                    <td>
                        {* date users.user_since *}
                    </td>
                    <td>
                        <a href="{* link members/manage/search/$users.user_name *}">{* lang members.memberships *}</a>
                    </td>
                    <td>
                        <a href="{* link users/edit/id/$users.user_id *}">{* lang default.edit *}</a>
                    </td>
                    <td>
                        <a href="{* link users/remove/id/$users.user_id *}">{* lang default.remove *}</a>
                    </td>
                </tr>
                {* else users *}
                <tr>
                    <th colspan="5" class="text-center">
                        {* lang default.no_record_found *}
                    </th>
                </tr>
                {* endforeach users *}
            </tbody><!--END table tbody-->
        </table><!--END table-->

        {* raw pages *}

    </div><!--END panel panel-body-->
</div><!--END panel-->