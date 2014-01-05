<div class="panel panel-default panel-body">

    {* tpl default/com_header plugin=users action=login *}

    <br />

    <form action="{* link users/login *}" name="form_login" method="POST" class="form-horizontal" role="form">

        {* if login_error == 'yes' *}
        <div class="alert alert-danger text-center">
            <strong>{* lang login_failed *}</strong>
        </div>

        <br />
        {* endif login_error *}

        {* tpl default/com_input name=login_name label=user_name value=login_name *}

        {* tpl default/com_input_pwd name=login_password label=user_password holder=user_password *}

        {* tpl default/com_submit_btn caption=submit *}

    </form><!--END form-->

</div><!--END panel-->