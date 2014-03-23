<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=install.install action=install.conf *}

        <br>

        {* tpl default/msg_error *}

        <form class="form-horizontal" role="form" action="{* link install/conf *}" method="POST">

            {* if config.logs == '1' *}
            {* tpl default/com_input_yesno_help name=logs label=install.error_logs help=install.logs_info *}
            {* else config.logs *}
            {* tpl default/com_input_noyes_help name=logs label=install.error_logs help=install.logs_info *}
            {* endif config.logs *}

            {* if config.zlib == '1' *}
            {* tpl default/com_input_yesno_help name=zlib label=install.zlib_compression help=install.zlib_info *}
            {* else config.zlib *}
            {* tpl default/com_input_noyes_help name=zlib label=install.zlib_compression help=install.zlib_info *}
            {* endif config.zlib *}

            {* if config.debug == '1' *}
            {* tpl default/com_input_yesno_help name=debug label=install.debug_mode help=install.debug_info *}
            {* else config.debug *}
            {* tpl default/com_input_noyes_help name=debug label=install.debug_mode help=install.debug_info *}
            {* endif config.debug *}

            {* if config.rewrite == '1' *}
            {* tpl default/com_input_yesno_help name=rewrite label=install.pretty_urls help=install.rewrite_info *}
            {* else config.rewrite *}
            {* tpl default/com_input_noyes_help name=rewrite label=install.pretty_urls help=install.rewrite_info *}
            {* endif config.rewrite *}

            {* if config.ajax == '1' *}
            {* tpl default/com_input_yesno_help name=ajax label=install.ajax_full help=install.ajax_info *}
            {* else config.ajax *}
            {* tpl default/com_input_noyes_help name=ajax label=install.ajax_full help=install.ajax_info *}
            {* endif config.ajax *}

            {* tpl default/com_submit_btn caption=default.save *}

        </form><!--END form-->

    </div><!--END panel-body-->
</div><!--END panel-->
