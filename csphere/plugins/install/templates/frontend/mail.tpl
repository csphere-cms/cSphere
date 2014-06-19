<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=install.install action=install.mail *}

        <br>

        {* tpl default/msg_error *}

        <form class="form-horizontal" role="form" action="{* link install/mail *}" method="POST">

            {* tpl default/com_select name=mail_driver label=install.server options=mail.drivers *}

            {* tpl default/com_select_help name=mail_newline label=install.mail_newline options=mail.newlines help=install.mail_newline_info *}

            {* tpl default/com_input_adv name=mail_subject label=install.mail_subject value=mail.subject type=text holder=install.mail_subject_info *}

            {* tpl default/com_input_adv name=mail_from label=default.email value=mail.from type=email holder=default.email *}

            <div class="mail_smtp">
            {* tpl default/com_input_adv name=mail_host label=default.host value=mail.host type=text holder=install.host_info *}

            {* tpl default/com_input_adv name=mail_port label=default.port value=mail.port type=text holder=install.port_info *}

            {* tpl default/com_input_adv name=mail_user label=install.user_name value=mail.username type=text holder=install.user_name *}

            {* tpl default/com_input_pwd name=mail_pass label=default.password holder=default.password *}

            {* tpl default/com_input_adv name=mail_timeout label=install.timeout value=mail.timeout type=text holder=install.timeout_info *}
            </div>

            {* tpl default/com_submit_btn caption=install.test *}

        </form><!--END form-->

    </div><!--END panel-body-->
</div><!--END panel-->
