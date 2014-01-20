<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=users.users action=users.settings *}

        <br />

        <form class="form-horizontal" role="form" action="{* link users/settings *}" method="POST">

            {* if users.user_invisible == '1' *}
            {* tpl default/com_input_yesno name=user_invisible label=users.invisible *}
            {* else users.user_invisible *}
            {* tpl default/com_input_noyes name=user_invisible label=users.invisible *}
            {* endif users.user_invisible *}

            <div class="form-group">
                <label for="user_lang" class="col-sm-2 control-label">{* lang languages.language *}</label>
                <div class="col-sm-10">
                    <select class="form-control" id="user_lang" name="user_lang">
                    {* foreach users.languages *}
                    {* if languages.active == 'yes' *}
                        <option value="{* var languages.short *}" selected="selected">{* var languages.name *}</option>
                    {* else languages.active *}
                        <option value="{* var languages.short *}">{* var languages.name *}</option>
                    {* endif languages.active *}
                    {* endforeach users.languages *}
                    </select>
                </div>
            </div><!--END form form-group user_lang-->

            {* tpl default/com_submit_btn caption=default.save *}

        </form><!--END form-->

    </div><!--END panel-body-->
</div><!--END panel-->