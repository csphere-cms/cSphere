<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=install action=mail *}

        <br />

        {* tpl default/msg_error *}

        <form class="form-horizontal" role="form" action="{* link install/mail *}" method="POST">

            <div class="form-group">
                <label for="inputMailDriver" class="col-sm-2 control-label">{* lang server *}</label>
                <div class="col-sm-10">
                    <select class="form-control" id="inputMailDriver" name="mail_driver">
                    {* foreach mail.drivers *}
                    {* if drivers.active == 'yes' *}
                        <option value="{* var drivers.short *}" selected="selected">{* var drivers.name *}</option>
                    {* else drivers.active *}
                        <option value="{* var drivers.short *}">{* var drivers.name *}</option>
                    {* endif drivers.active *}
                    {* endforeach mail.drivers *}
                    </select>
                </div>
            </div><!--END form form-group inputMailDriver-->

        <form class="form-horizontal" role="form" action="{* link install/mail *}" method="POST">

            <div class="form-group">
                <label for="inputMailnewline" class="col-sm-2 control-label">{* lang mail_newline *}</label>
                <div class="col-sm-10">
                    <select class="form-control" id="inputMailnewline" name="mail_newline">
                    {* foreach mail.newlines *}
                    {* if newlines.active == 'yes' *}
                        <option value="{* var newlines.short *}" selected="selected">{* var newlines.name *}</option>
                    {* else newlines.active *}
                        <option value="{* var newlines.short *}">{* var newlines.name *}</option>
                    {* endif newlines.active *}
                    {* endforeach mail.newlines *}
                    </select>
                </div>
            </div><!--END form form-group inputMailnewline-->

            <span class="help-block">{* lang mail_newline_info *}</span>

            {* tpl default/com_input_adv name=mail_subject label=mail_subject value=mail.subject type=text holder=mail_subject_info *}

            {* tpl default/com_input_adv name=mail_from label=email value=mail.from type=email holder=email *}

            <div class="mail_smtp">
            {* tpl default/com_input_adv name=mail_host label=host value=mail.host type=text holder=host_info *}

            {* tpl default/com_input_adv name=mail_port label=port value=mail.port type=text holder=port_info *}

            {* tpl default/com_input_adv name=mail_user label=name value=mail.username type=text holder=name *}

            {* tpl default/com_input_pwd name=mail_pass label=password holder=password *}

            {* tpl default/com_input_adv name=mail_timeout label=timeout value=mail.timeout type=text holder=timeout_info *}
            </div>

            {* tpl default/com_submit_btn caption=test *}

        </form><!--END form-->

    </div><!--END panel-body-->
</div><!--END panel-->