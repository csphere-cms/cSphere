<div class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header">
                <h3>
                    {* lang plugins *} - {* lang xml.plugin *}: {* var name *}
                </h3><!--END header page-header headline-->
            </section><!--END header page-header-->
        </header><!--END header-->

        <br />

        <dl class="dl-horizontal">
            <dt>{* lang xml.vendor *}:</dt>
            <dd>{* var vendor *}</dd>

            <dt>{* lang xml.version *}:</dt>
            <dd>{* var version *}</dd>

            <dt>{* lang xml.published *}:</dt>
            <dd>{* var published *}</dd>

            <dt>{* lang xml.copyright *}:</dt>
            <dd>{* var copyright *}</dd>

            <dt>{* lang xml.license *}:</dt>
            <dd>{* var license *}</dd>

            <dt>{* lang default.info *}:</dt>
            <dd>{* var info *}</dd>
        </dl><!--END dl-horizontal-->

        <dl class="dl-horizontal">
            <dt>{* lang xml.engine *}:</dt>
            <dd>
                {* var engine.name *} {* var engine.version_min *}{* if engine.version_max != '' *} up to {* var engine.version_max *}{* endif engine.version_max *}
            </dd>
            <dt>{* lang xml.icon *}:</dt>
            <dd>
                {* if icon.type == 'fontawesome' *} <i class="fa fa-2x fa-fw {* var icon.value *}"></i>{* endif icon.type *} {* var icon.value *}
            </dd>
        </dl><!--END dl-horizontal-->

        <dl class="dl-horizontal">
            <dt>{* lang xml.authors_current *}:</dt>
            {* foreach authors.current *}
            <dd>{* var current.value *}</dd>
            {* endforeach authors.current *}

            <dt>{* lang xml.authors_past *}:</dt>
            {* foreach authors.past *}
            <dd>{* var past.value *}</dd>
            {* endforeach authors.past *}

            <dt>{* lang xml.contact_email *}:</dt>
            {* foreach contact.email *}
            <dd>{* var email.adress *}</dd>
            {* endforeach contact.email *}

            <dt>{* lang xml.contact_web *}:</dt>
            {* foreach contact.web *}
            <dd><a href="{* var web.url *}">{* var web.url *}</a></dd>
            {* endforeach contact.web *}
        </dl><!--END dl-horizontal-->

        <dl class="dl-horizontal">
            <dt>{* lang xml.php_required *}:</dt>
            <dd>
                {* var required.php *}
            </dd>
        </dl><!--END dl-horizontal-->

        <dl class="dl-horizontal">
            <dt>{* lang xml.entries *}:</dt>
            {* foreach entries.target *}
            <dd>
                <strong>{* lang xml.plugin *}:</strong> {* var target.plugin *}  - <strong>{* lang xml.action *}:</strong> {* var target.action *}
            </dd>
            {* endforeach entries.target *}
        </dl><!--END dl-horizontal-->

        {* foreach environment *}
        <dl class="dl-horizontal">
            <dt>{* lang xml.environment_needed *}:</dt>
            {* foreach environment.needed *}
            <dd>
                <strong>{* lang xml.plugin *}:</strong> {* var needed.plugin *} - <strong>{* lang xml.version *}:</strong> {* var needed.version_min *}{* if needed.version_max != '' *} {* lang xml.until *} {* var needed.version_max *}{* endif needed.version_max *}
            </dd>
            {* endforeach environment.needed *}
        </dl><!--END dl-horizontal-->

        <dl class="dl-horizontal">
            <dt>{* lang xml.environment_extends *}:</dt>
            {* foreach environment.extend *}
            <dd>
                {* lang xml.plugin *} {* var extend.plugin *} {* lang xml.version *} {* var extend.version_min *}{* if extend.version_max != '' *} {* lang xml.until *} {* var extend.version_max *}{* endif extend.version_max *}
            </dd>
            {* endforeach environment.extend *}
        </dl><!--END dl-horizontal-->
        {* endforeach environment *}

        <dl class="dl-horizontal clear">
            <dt>{* lang xml.php_extensions *}:</dt>
            {* foreach required.extension *}
            <dd>
                {* var extension.value *}
            </dd>
            {* endforeach required.extension *}
        </dl><!--END dl-horizontal-->

        <br /><br />

    </div><!--END panel-body-->
</div><!--END panel-->