<div id="users-form" class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header">
                <h3>
                    {* lang users *} - {* if action == 'create' *}{* lang default.create *}{* else action *}{* lang default.edit *}{* endif action *}
                </h3><!--END header page-header headline-->
            </section><!--END header page-header-->
        </header><!--END header-->

        <br />

        {* if action == 'create' *}
        <form class="form-horizontal" role="form" action="{* link users/create *}" method="POST">
        {* else action *}
        <form class="form-horizontal" role="form" action="{* link users/edit/id/$users.user_id *}" method="POST">
        {* endif action *}

            <div class="form-group">
                <label for="inputUserName" class="col-sm-2 control-label">{* lang name *}</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputUserName" name="user_name" value="{* var users.user_name *}" placeholder="{* lang name *}" />
                </div>
            </div><!--END form form-group inputUserName-->

            <div class="form-group">
                <label for="inputUserActive" class="col-sm-2 control-label">{* lang active *}</label>
                <div class="col-sm-10">

                    <label class="checkbox-inline">
                        {* if users.user_active != '1' *}
                        <input type="radio" name="user_active" value="0" checked="checked" /> {* lang default.no *}
                        {* else users.user_active *}
                        <input type="radio" name="user_active" value="0" /> {* lang default.no *}
                        {* endif users.user_active *}
                    </label>

                    <label class="checkbox-inline">
                        {* if users.user_active == '1' *}
                        <input type="radio" name="user_active" value="1" checked="checked" /> {* lang default.yes *}
                        {* else users.user_active *}
                        <input type="radio" name="user_active" value="1" /> {* lang default.yes *}
                        {* endif users.user_active *}
                    </label>

                </div>
            </div><!--END form form-group inputUserActive-->

            <div class="form-group">
                <label for="inputUserEmail" class="col-sm-2 control-label">{* lang email *}</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="inputUserEmail" name="user_email" value="{* var users.user_email *}" placeholder="{* lang email *}" />
                </div>
            </div><!--END form form-group inputUserEmail-->

            {* if action == 'create' *}
            <div class="form-group">
                <label for="inputUserPassword" class="col-sm-2 control-label">{* lang password *}</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputUserPassword" name="user_password" value="" placeholder="{* lang password *}" />
                </div>
            </div><!--END form form-group inputUserPassword-->
            {* endif action *}

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button class="btn btn-primary" type="submit">{* lang default.save *}</button>
                </div>
            </div><!--END form form-group submit-->

        </form><!--END form-->

    </div><!--END panel panel-body-->
</div><!--END panel-->