<div class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header">
                <h3>
                    {* lang languages *} - {* lang details *}
                    <small>
                        {* lang language *}: {* var short *} - {* if type == 'theme' *}{* lang theme *}{* else type *}{* lang plugin *}{* endif type *}: {* var dir *}
                    </small>
                </h3><!--END header page-header headline-->
            </section><!--END header page-header-->
        </header><!--END header-->

        <br />

        {* if error != '' *}
        <div class="alert alert-danger text-center">
            <strong>{* var error *}</strong>
        </div>

        <br />
        {* endif error *}

        <dl class="dl-horizontal">
            <dt>{* lang vendor *}:</dt>
            <dd>{* var vendor *}</dd>

            <dt>{* lang version *}:</dt>
            <dd>{* var version *}</dd>

            <dt>{* lang published *}:</dt>
            <dd>{* var published *}</dd>

            <dt>{* lang copyright *}:</dt>
            <dd>{* var copyright *}</dd>

            <dt>{* lang license *}:</dt>
            <dd>{* var license *}</dd>

            <dt>{* lang info *}:</dt>
            <dd>{* var info *}</dd>
        </dl><!--END dl-horizontal theme_id-->

        <dl class="dl-horizontal">
            <dt>{* lang engine *}:</dt>
            <dd>
                {* var engine.name *} {* var engine.version_min *}{* if engine.version_max != '' *} up to {* var engine.version_max *}{* endif engine.version_max *}
            </dd>
            <dt>{* lang icon *}:</dt>
            <dd>
                {* if icon.type == 'famfamfam' *} <img src="{* raw icon.url *}" alt="{* var icon.value *}" />{* endif icon.type *} {* var icon.value *}
            </dd>
        </dl><!--END dl-horizontal engine-->

        <dl class="dl-horizontal">
            <dt>{* lang authors_current *}:</dt>
            {* foreach authors.current *}
            <dd>{* var current.value *}</dd>
            {* endforeach authors.current *}

            <dt>{* lang authors_past *}:</dt>
            {* foreach authors.past *}
            <dd>{* var past.value *}</dd>
            {* endforeach authors.past *}

            <dt>{* lang contact_email *}:</dt>
            {* foreach contact.email *}
            <dd>{* var email.adress *}</dd>
            {* endforeach contact.email *}

            <dt>{* lang contact_web *}:</dt>
            {* foreach contact.web *}
            <dd><a href="{* var web.url *}">{* var web.url *}</a></dd>
            {* endforeach contact.web *}
        </dl><!--END dl-horizontal authors_current-->

        <br /><br />

    </div><!--END panel-body-->
</div><!--END panel-->