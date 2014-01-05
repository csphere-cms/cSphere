<div class="panel panel-default panel-body">

    <header>
        <section class="page-header">
            <h3>
                {* lang themes *} - {* lang theme *}: {* var name *}
            </h3><!--END header page-header headline-->
        </section><!--END header page-header-->
    </header><!--END header-->

    <br />

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
            {* if icon.type == 'fontawesome' *} <i class="fa fa-2x fa-fw {* var icon.value *}"></i>{* endif icon.type *} {* var icon.value *}
        </dd>
    </dl><!--END dl-horizontal engine-->

    <dl class="dl-horizontal">
        <dt>{* lang contains_designs *}:</dt>
        <dd>{* lang admin *}: <strong>{* var contains.admin *}</strong></dd>
        <dd>{* lang install *}: <strong>{* var contains.install *}</strong></dd>
        <dd>{* lang layout *}: <strong>{* var contains.layout *}</strong></dd>
        <dd>{* lang mobile *}: <strong>{* var contains.mobile *}</strong></dd>
    </dl><!--END dl-horizontal contains_designs-->

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

    <dl class="dl-horizontal">
        <dt>{* lang media *}:</dt>
        {* foreach media.preview *}
        <dd>{* lang preview *}: <strong>{* var preview.value *}</strong></dd>
        {* endforeach media.preview *}

        {* foreach media.thumb *}
        <dd>{* lang thumb *}: <strong>{* var thumb.value *}</strong></dd>
        {* endforeach media.thumb *}
    </dl><!--END dl-horizontal media-->

    {* foreach environment *}
    <dl class="dl-horizontal">
        <dt>{* lang environment_needed *}:</dt>
        {* foreach environment.needed *}
        <dd>
            <strong>{* lang plugin *}:</strong> {* var needed.plugin *} - <strong>{* lang version *}:</strong> {* var needed.version_min *}{* if needed.version_max != '' *} {* lang until *} {* var needed.version_max *}{* endif needed.version_max *}
        </dd>
        {* endforeach environment.needed *}
    </dl><!--END dl-horizontal environment_needed-->

    <dl class="dl-horizontal">
        <dt>{* lang environment_extends *}:</dt>
        {* foreach environment.extend *}
        <dd>
            {* lang plugin *} {* var extend.plugin *} {* lang version *} {* var extend.version_min *}{* if extend.version_max != '' *} {* lang until *} {* var extend.version_max *}{* endif extend.version_max *}
        </dd>
        {* endforeach environment.extend *}
    </dl><!--END dl-horizontal environment_extends-->
    {* endforeach environment *}

    <br /><br />

</div><!--END panel-->