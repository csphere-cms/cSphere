<div id="users-form" class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=install action=admin *}

        <br />

        {* if error != '' *}
        <div class="alert alert-danger text-center">
            <strong>{* var error *}</strong>
        </div>

        <br />
        {* endif error *}

        <form class="form-horizontal" role="form" action="{* link install/admin *}" method="POST">

                <div class="form-group">
                    <label for="inputUserName" class="col-sm-2 control-label">{* lang name *}</label>
                    <div class="col-sm-10">
                        <input type="text" autocomplete="off" class="form-control" id="inputUserName" name="user_name" value="{* var user_name *}" placeholder="{* lang name *}" />
                    </div>
                </div><!--END form form-group inputUserName-->

                <div class="form-group">
                    <label for="inputUserEmail" class="col-sm-2 control-label">{* lang email *}</label>
                    <div class="col-sm-10">
                        <input type="email" autocomplete="off" class="form-control" id="inputUserEmail" name="user_email" value="{* var user_email *}" placeholder="{* lang email *}" />
                    </div>
                </div><!--END form form-group inputUserEmail-->

                <div class="form-group">
                    <label for="inputUserPassword" class="col-sm-2 control-label">{* lang password *}</label>
                    <div class="col-sm-10">
                        <input type="password" autocomplete="off" class="form-control" id="inputUserPassword" name="user_password" value="" placeholder="{* lang password *}" />
                    </div>
                </div><!--END form form-group inputUserPassword-->

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button class="btn btn-primary" type="submit">{* lang default.save *}</button>
                    </div>
                </div><!--END form form-group submit-->
            </form><!--END form-->

    </div><!--END panel panel-body-->
</div><!--END panel-->