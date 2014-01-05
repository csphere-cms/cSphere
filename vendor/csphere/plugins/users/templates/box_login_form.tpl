<div id="users-login-box">

    <div class="page-header">
        <h4>{* lang login *}</h4>
    </div><!--END users-login-box page-header-->

    <form name="form_login" method="POST" role="form">

        {* if login_error == 'yes' *}
        <div class="alert alert-danger text-center">
            <strong>{* lang login_failed *}</strong>
        </div>
        {* endif login_error *}

        {* tpl default/com_box_input type=text name=login_name holder=user_name value=login_name *}

        {* tpl default/com_box_input type=password name=login_password holder=user_password value=login_pass *}

        {* tpl default/com_box_post caption=login plugin=users box=login *}

    </form><!--END form-->

</div><!--END users-login-box-->