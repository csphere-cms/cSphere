<form name="form_login" method="POST" role="form">

    {* if login_error == 'yes' *}
    <div class="alert alert-danger text-center">
        <strong>{* lang login_failed *}</strong>
    </div>
    {* endif login_error *}

    {* tpl default/com_input name=login_name label=user_name value=login_name *}

    {* tpl default/com_input_pwd name=login_password label=user_password holder=user_password *}

    <div class="form-group">
        <button type="submit" class="btn btn-success btn-block" onclick="csphere_ajax_form('users', 'login', '')">{* lang submit *}</button>
    </div><!--END form form-group submit-->

</form>