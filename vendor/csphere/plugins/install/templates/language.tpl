<div id="install-language" class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header">
                <h3>
                    {* lang install *} - {* lang language *}
                </h3><!--END header page-header headline-->
            </section><!--END header page-header-->
        </header><!--END header-->

        <br />

        <div>

        <ul>
            {* foreach languages *}

            <li>
                <img src="{* raw languages.icon_url *}" alt="{* var languages.icon *}" /> &nbsp;
                <a href="{* link install/language/lang/$languages.short$ *}">{* var languages.name *}</a>
            </li>

            {* endforeach languages *}

        </ul>

        </div>

    </div><!--END panel panel-body-->
</div><!--END panel-->