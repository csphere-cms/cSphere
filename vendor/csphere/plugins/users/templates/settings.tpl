<div id="users-settings" class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header">
                <h3>
                    {* lang users *} - {* lang settings *}
                </h3><!--END header page-header headline-->
            </section><!--END header page-header-->
        </header><!--END header-->

        <br />

        <form class="form-horizontal" role="form" action="{* link users/settings *}" method="POST">

            <div class="form-group">
                <label for="inputUserInvisible" class="col-sm-2 control-label">{* lang invisible *}</label>
                <div class="col-sm-10">

                    <label class="checkbox-inline">
                        {* if users.user_invisible != '1' *}
                        <input type="radio" name="user_invisible" value="0" checked="checked" /> {* lang default.no *}
                        {* else users.user_invisible *}
                        <input type="radio" name="user_invisible" value="0" /> {* lang default.no *}
                        {* endif users.user_invisible *}
                    </label>

                    <label class="checkbox-inline">
                        {* if users.user_invisible == '1' *}
                        <input type="radio" name="user_invisible" value="1" checked="checked" /> {* lang default.yes *}
                        {* else users.user_invisible *}
                        <input type="radio" name="user_invisible" value="1" /> {* lang default.yes *}
                        {* endif users.user_invisible *}
                    </label>

                </div>
            </div><!--END form form-group inputUserInvisible-->

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

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button class="btn btn-primary" type="submit">{* lang default.save *}</button>
                </div>
            </div><!--END form form-group submit-->

        </form><!--END form-->

    </div><!--END panel panel-body-->
</div><!--END panel-->