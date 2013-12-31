<div id="users-profile" class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header">
                <h3>
                    {* lang users *} - {* lang profile *}
                </h3><!--END header page-header headline-->
            </section><!--END header page-header-->
        </header><!--END header-->

        <br />

        <form class="form-horizontal" role="form" action="{* link users/profile *}" method="POST">

            <div class="form-group">
                <label for="inputUserName" class="col-sm-2 control-label">{* lang name *}</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputUserName" name="user_name" value="{* var users.user_name *}" placeholder="{* lang name *}" />
                </div>
            </div><!--END form form-group inputUserName-->

            <div class="form-group">
                <label for="inputUserEmail" class="col-sm-2 control-label">{* lang email *}</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="inputUserEmail" name="user_email" value="{* var users.user_email *}" placeholder="{* lang email *}" />
                </div>
            </div><!--END form form-group inputUserEmail-->

            <div class="form-group">
                <label for="inputUserPasswordOld" class="col-sm-2 control-label">{* lang password *}</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputUserPasswordOld" name="password_old" value="" placeholder="{* lang password_old *}" />
                </div>
            </div><!--END form form-group inputUserPasswordOld-->

            <div class="form-group">
                <label for="inputUserPasswordNew" class="col-sm-2 control-label">{* lang password *}</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputUserPasswordNew" name="password_new" value="" placeholder="{* lang password_new *}" />
                </div>
            </div><!--END form form-group inputUserPasswordNew-->

            <div class="form-group">
                <label for="inputUserPasswordConfirm" class="col-sm-2 control-label">{* lang password *}</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputUserPasswordConfirm" name="password_confirm" value="" placeholder="{* lang password_confirm *}" />
                </div>
            </div><!--END form form-group inputUserPasswordConfirm-->

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button class="btn btn-primary" type="submit">{* lang default.save *}</button>
                </div>
            </div><!--END form form-group submit-->

        </form><!--END form-->

    </div><!--END panel panel-body-->
</div><!--END panel-->