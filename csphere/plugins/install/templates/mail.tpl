<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=install.install action=install.mail *}

        <br />

        {* tpl default/msg_error *}

        <form class="form-horizontal" role="form" action="{* link install/mail *}" method="POST">

            <div class="form-group">
                <label for="mail_driver" class="col-sm-2 control-label">{* lang install.server *}</label>
                <div class="col-sm-10">
                    <select class="form-control" id="mail_driver" name="mail_driver">
                    {* foreach mail.drivers *}
                    {* if drivers.active == 'yes' *}
                        <option value="{* var drivers.short *}" selected="selected">{* var drivers.name *}</option>
                    {* else drivers.active *}
                        <option value="{* var drivers.short *}">{* var drivers.name *}</option>
                    {* endif drivers.active *}
                    {* endforeach mail.drivers *}
                    </select>
                </div>
            </div><!--END form form-group mail_driver-->

            <div class="form-group">
                <label for="mail_newline" class="col-sm-2 control-label">{* lang install.mail_newline *}</label>
                <div class="col-sm-10">
                    <select class="form-control" id="mail_newline" name="mail_newline">
                    {* foreach mail.newlines *}
                    {* if newlines.active == 'yes' *}
                        <option value="{* var newlines.short *}" selected="selected">{* var newlines.name *}</option>
                    {* else newlines.active *}
                        <option value="{* var newlines.short *}">{* var newlines.name *}</option>
                    {* endif newlines.active *}
                    {* endforeach mail.newlines *}
                    </select>
                </div>
            </div><!--END form form-group mail_newline-->

            <span class="help-block">{* lang install.mail_newline_info *}</span>

            {* tpl default/com_input_adv name=mail_subject label=install.mail_subject value=mail.subject type=text holder=install.mail_subject_info *}

            {* tpl default/com_input_adv name=mail_from label=default.email value=mail.from type=email holder=default.email *}

            <div class="mail_smtp">
            {* tpl default/com_input_adv name=mail_host label=default.host value=mail.host type=text holder=install.host_info *}

            {* tpl default/com_input_adv name=mail_port label=default.port value=mail.port type=text holder=install.port_info *}

            {* tpl default/com_input_adv name=mail_user label=users.user_name value=mail.username type=text holder=users.user_name *}

            {* tpl default/com_input_pwd name=mail_pass label=default.password holder=default.password *}

            {* tpl default/com_input_adv name=mail_timeout label=install.timeout value=mail.timeout type=text holder=install.timeout_info *}
            </div>

            {* tpl default/com_submit_btn caption=install.test *}

        </form><!--END form-->

    </div><!--END panel-body-->
</div><!--END panel-->