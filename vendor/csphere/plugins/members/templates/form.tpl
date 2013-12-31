<div id="members-form" class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header">
                <h3>
                    {* lang members *} - {* if action == 'create' *}{* lang default.create *}{* else action *}{* lang default.edit *}{* endif action *}
                </h3><!--END header page-header headline-->
            </section><!--END header page-header-->
        </header><!--END header-->

        <br />

        {* if action == 'create' *}
        <form class="form-horizontal" role="form" action="{* link members/create *}" method="POST">
        {* else action *}
        <form class="form-horizontal" role="form" action="{* link members/edit/id/$members.member_id *}" method="POST">
        {* endif action *}

            <div class="form-group">
                <label for="inputGroupName" class="col-sm-2 control-label">{* lang group_name *}</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputGroupName" name="group_name" value="{* var members.group_name *}" placeholder="{* lang group_name *}" />
                </div>
            </div><!--END form form-group inputGroupName-->

            <div class="form-group">
                <label for="inputUserName" class="col-sm-2 control-label">{* lang user_name *}</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputUserName" name="user_name" value="{* var members.user_name *}" placeholder="{* lang user_name *}" />
                </div>
            </div><!--END form form-group inputUserName-->

            <div class="form-group">
                <label for="inputUserAdmin" class="col-sm-2 control-label">{* lang group_admin *}</label>
                <div class="col-sm-10">

                    <label class="checkbox-inline">
                        {* if members.member_admin != '1' *}
                        <input type="radio" name="member_admin" value="0" checked="checked" /> {* lang default.no *}
                        {* else members.member_admin *}
                        <input type="radio" name="member_admin" value="0" /> {* lang default.no *}
                        {* endif members.member_admin *}
                    </label>

                    <label class="checkbox-inline">
                        {* if members.member_admin == '1' *}
                        <input type="radio" name="member_admin" value="1" checked="checked" /> {* lang default.yes *}
                        {* else members.member_admin *}
                        <input type="radio" name="member_admin" value="1" /> {* lang default.yes *}
                        {* endif members.member_admin *}
                    </label>

                </div>
            </div><!--END form form-group inputUserAdmin-->

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button class="btn btn-primary" type="submit">{* lang default.save *}</button>
                </div>
            </div><!--END form form-group submit-->

        </form><!--END form-->

    </div><!--END panel panel-body-->
</div><!--END panel-->