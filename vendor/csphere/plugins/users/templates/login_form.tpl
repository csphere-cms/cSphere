<div id="users-login-form" class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header">
                <h3>
                    {* lang users *} - {* lang login *}
                </h3><!--END header page-header headline-->
            </section><!--END header page-header-->
        </header><!--END header-->

        <br />

        <form action="{* link users/login *}" name="form_login" method="POST" class="form-horizontal" role="form">

            {* if login_error == 'yes' *}
            <div class="alert alert-danger text-center">
                <strong>{* lang login_failed *}</strong>
            </div>

            <br />
            {* endif login_error *}

            <div class="form-group">
                <label for="inputUserName" class="col-sm-2 control-label">{* lang user_name *}</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputUserName" name="login_name" value="{* var login_name *}" placeholder="{* lang name *}" />
                </div>
            </div><!--END form form-group inputUserName-->

            <div class="form-group">
                <label for="inputUserPassword" class="col-sm-2 control-label">{* lang user_password *}</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputUserPassword" name="login_password" value="" placeholder="{* lang password *}" />
                </div>
            </div><!--END form form-group inputUserPassword-->

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button class="btn btn-primary" type="submit">{* lang submit *}</button>
                </div>
            </div><!--END form form-group submit-->

        </form>

    </div><!--END panel panel-body-->
</div><!--END panel-->