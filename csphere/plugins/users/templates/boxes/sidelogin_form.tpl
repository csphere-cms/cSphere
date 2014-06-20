<div id="users-login-box">

    <div class="page-header">
        <h4>{* lang users.login *}</h4>
    </div><!--END users-login-box page-header-->

    <form name="form_login" method="POST" role="form">

        {* tpl default/msg_error *}

        {* tpl default/com_box_input type=text name=login_name holder=users.user_name value=login_name *}

        {* tpl default/com_box_input type=password name=login_password holder=users.user_password value=login_pass *}

        {* tpl default/com_box_post caption=login plugin=users.users box=login *}

    </form><!--END form-->

</div><!--END users-login-box-->
