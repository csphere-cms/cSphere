<div id="users-list" class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header">
                <h3>
                    {* lang users *} - {* lang default.list *}
                </h3><!--END header page-header headline-->
            </section><!--END header page-header-->

            <section class="clearfix">
                <span class="help-block pull-left">
                    {* lang default.records *}: {* var records *}{* if search != '' *} - {* lang default.hits *}: {* var hits *}{* endif search *}
                </span><!--END header help-block-->

                <div class="col-md-5 row pull-right">
                    <form class="form-inline" role="form" action="{* link users/list *}" method="POST">
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
                    <th>
                        <a href="{* raw order.user_laston *}">{* lang laston *}</a> {* raw arrow.user_laston *}
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
                        {* date users.user_laston *}
                    </td>
                </tr>
                {* else users *}
                <tr>
                    <th colspan="3" class="text-center">
                        {* lang default.no_record_found *}
                    </th>
                </tr>
                {* endforeach users *}
            </tbody><!--END table tbody-->
        </table><!--END table-->

        {* raw pages *}

    </div><!--END panel panel-body-->
</div><!--END panel-->