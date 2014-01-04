<div id="groups-options" class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=groups action=default.options *}

        <br />

        <form class="form-horizontal" role="form" action="{* link groups/options *}" method="POST">

            <div class="form-group">
                <label for="inputMainName" class="col-sm-2 control-label">{* lang main_id *}</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputMainName" name="main_name" value="{* var options.main_name *}" placeholder="{* lang main_name *}" />
                </div>
            </div><!--END form form-group inputMainName-->

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button class="btn btn-primary" type="submit">{* lang default.save *}</button>
                </div>
            </div><!--END form form-group submit-->

        </form><!--END form-->

    </div><!--END panel panel-body-->
</div><!--END panel-->