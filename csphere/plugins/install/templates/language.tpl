<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=install action=language *}

        <br />

        <ul>
            {* foreach languages *}
            <li>
                <img src="{* raw languages.icon_url *}" alt="{* var languages.icon *}" /> &nbsp;
                <a href="{* link install/language/lang/$languages.short$ *}">{* var languages.name *}</a>
            </li>
            {* endforeach languages *}
        </ul>

    </div><!--END panel-body-->
</div><!--END panel-->