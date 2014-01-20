<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=install action=conf *}

        <br />

        {* tpl default/msg_error *}

        <form class="form-horizontal" role="form" action="{* link install/conf *}" method="POST">

            {* if config.logs == '1' *}
            {* tpl default/com_input_yesno name=logs label=error_logs *}
            {* else config.logs *}
            {* tpl default/com_input_noyes name=logs label=error_logs *}
            {* endif config.logs *}

            <span class="help-block">{* lang logs_info *}</span>

            {* if config.zlib == '1' *}
            {* tpl default/com_input_yesno name=zlib label=zlib_compression *}
            {* else config.zlib *}
            {* tpl default/com_input_noyes name=zlib label=zlib_compression *}
            {* endif config.zlib *}

            <span class="help-block">{* lang zlib_info *}</span>

            {* if config.debug == '1' *}
            {* tpl default/com_input_yesno name=debug label=debug_mode *}
            {* else config.debug *}
            {* tpl default/com_input_noyes name=debug label=debug_mode *}
            {* endif config.debug *}

            <span class="help-block">{* lang debug_info *}</span>

            {* if config.rewrite == '1' *}
            {* tpl default/com_input_yesno name=rewrite label=pretty_urls *}
            {* else config.rewrite *}
            {* tpl default/com_input_noyes name=rewrite label=pretty_urls *}
            {* endif config.rewrite *}

            <span class="help-block">{* lang rewrite_info *}</span>

            {* if config.ajax == '1' *}
            {* tpl default/com_input_yesno name=ajax label=ajax_full *}
            {* else config.ajax *}
            {* tpl default/com_input_noyes name=ajax label=ajax_full *}
            {* endif config.ajax *}

            <span class="help-block">{* lang ajax_info *}</span>

            {* tpl default/com_submit_btn caption=default.save *}

        </form><!--END form-->

    </div><!--END panel-body-->
</div><!--END panel-->