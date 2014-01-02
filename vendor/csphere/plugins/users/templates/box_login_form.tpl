<form name="form_login" method="POST" role="form">

    {* if login_error == 'yes' *}
    <div class="alert alert-danger text-center">
        <strong>{* lang login_failed *}</strong>
    </div>
    {* endif login_error *}

    <div class="form-group">
        <label class="sr-only" for="inputUserName">{* lang user_name *}</label>
        <input type="text" class="form-control" id="inputUserName" name="login_name" placeholder="{* lang user_name *}" value="{* var login_name *}" required>
    </div><!--END form form-group inputUserName-->

    <div class="form-group">
        <label class="sr-only" for="inputUserPassword">{* lang user_password *}</label>
        <input type="password" class="form-control" id="inputUserPassword" name="login_password" placeholder="{* lang user_password *}" required>
    </div><!--END form form-group inputUserPassword-->

    <div class="form-group">
        <button type="submit" class="btn btn-success btn-block" onclick="csphere_ajax_form('users', 'login', '')">{* lang submit *}</button>
    </div><!--END form form-group submit-->

</form>