<div id="users-settings" class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=users action=settings *}

        <br />

        <form class="form-horizontal" role="form" action="{* link users/settings *}" method="POST">

            {* if users.user_invisible == '1' *}
            {* tpl default/com_input_yesno name=user_invisible label=invisible *}
            {* else users.user_invisible *}
            {* tpl default/com_input_noyes name=user_invisible label=invisible *}
            {* endif users.user_invisible *}

            <div class="form-group">
                <label for="inputUserLang" class="col-sm-2 control-label">{* lang language *}</label>
                <div class="col-sm-10">
                    <select class="form-control" id="inputUserLang" name="user_lang">
                    {* foreach users.languages *}
                    {* if languages.active == 'yes' *}
                        <option value="{* var languages.short *}" selected="selected">{* var languages.name *}</option>
                    {* else languages.active *}
                        <option value="{* var languages.short *}">{* var languages.name *}</option>
                    {* endif languages.active *}
                    {* endforeach users.languages *}
                    </select>
                </div>
            </div><!--END form form-group inputUserLang-->

            {* tpl default/com_submit_btn caption=default.save *}

        </form><!--END form-->

    </div><!--END panel panel-body-->
</div><!--END panel-->