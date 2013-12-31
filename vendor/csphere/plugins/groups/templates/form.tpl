<div id="groups-form" class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header">
                <h3>
                    {* lang groups *} - {* if action == 'create' *}{* lang default.create *}{* else action *}{* lang default.edit *}{* endif action *}
                </h3><!--END header page-header headline-->
            </section><!--END header page-header-->
        </header><!--END header-->

        <br />

        {* if action == 'create' *}
        <form class="form-horizontal" role="form" action="{* link groups/create *}" method="POST">
        {* else action *}
        <form class="form-horizontal" role="form" action="{* link groups/edit/id/$groups.group_id *}" method="POST">
        {* endif action *}

            <div class="form-group">
                <label for="inputGroupName" class="col-sm-2 control-label">{* lang name *}</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputGroupName" name="group_name" value="{* var groups.group_name *}" placeholder="{* lang name *}" />
                </div>
            </div><!--END form form-group inputGroupName-->

            <div class="form-group">
                <label for="inputGroupUrl" class="col-sm-2 control-label">{* lang url *}</label>
                <div class="col-sm-10">
                    <input type="url" class="form-control" id="inputGroupUrl" name="group_url" value="{* var groups.group_url *}" placeholder="{* lang url *}" />
                </div>
            </div><!--END form form-group inputGroupUrl-->

            <div class="form-group">
                <label for="inputGroupInfo" class="col-sm-2 control-label">{* lang info *}</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="inputGroupInfo" name="group_info" placeholder="{* lang info *}" row="3">{* var groups.group_info *}</textarea>
                </div>
            </div><!--END form form-group inputGroupInfo-->

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button class="btn btn-primary" type="submit">{* lang default.save *}</button>
                </div>
            </div><!--END form form-group submit-->

        </form><!--END form-->

    </div><!--END panel panel-body-->
</div><!--END panel-->