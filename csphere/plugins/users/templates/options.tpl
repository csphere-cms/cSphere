<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=users.users action=default.options *}

        <br />

        <form class="form-horizontal" role="form" action="{* link users/options *}" method="POST">

            <div class="form-group">
                <label for="force_https" class="col-sm-3 control-label">{* lang users.force_https *}</label>
                <div class="col-sm-9">

                    <label class="radio-inline">
                        {* if options.force_https != '1' *}
                        <input type="radio" name="force_https" value="0" checked="checked" /> {* lang default.no *}
                        {* else options.force_https *}
                        <input type="radio" name="force_https" value="0" /> {* lang default.no *}
                        {* endif options.force_https *}
                    </label>

                    <label class="radio-inline">
                        {* if options.force_https == '1' *}
                        <input type="radio" name="force_https" value="1" checked="checked" /> {* lang default.yes *}
                        {* else options.force_https *}
                        <input type="radio" name="force_https" value="1" /> {* lang default.yes *}
                        {* endif options.force_https *}
                    </label>

                </div>
            </div><!--END form form-group force_https-->

            {* tpl default/com_submit_btn caption=default.save *}

        </form><!--END form-->

    </div><!--END panel-body-->
</div><!--END panel-->