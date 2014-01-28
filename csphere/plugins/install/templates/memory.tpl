<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=install.install action=install.memory *}

        <br />

        {* tpl default/msg_error *}

        <form class="form-horizontal" role="form" action="{* link install/memory *}" method="POST">

            {* tpl default/com_select_help name=cache_driver label=install.cache_type options=cache.drivers help=install.cache_info *}

            <div class="cache_redis">
            {* tpl default/com_input_adv name=cache_host label=default.host value=cache.host type=text holder=install.host_info *}

            {* tpl default/com_input_adv name=cache_port label=default.port value=cache.port type=text holder=install.port_info *}

            {* tpl default/com_input_pwd name=cache_pass label=default.password holder=default.password *}

            {* tpl default/com_input_adv name=cache_timeout label=install.timeout value=cache.timeout type=text holder=install.timeout_info *}
            </div>

            {* tpl default/com_submit_btn caption=install.test *}

        </form><!--END form-->

    </div><!--END panel-body-->
</div><!--END panel-->