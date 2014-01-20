{* lang xml.plugin *}: {* var name *}
<br /><br />
{* lang xml.engine *}: {* var engine.name *} {* var engine.version_min *}
{* if engine.version_max != '' *} {* lang xml.until *} {* var engine.version_max *}{* endif engine.version_max *}
<br /><br />
{* lang xml.icon *}:
{* if icon.type == 'fontawesome' *} <i class="fa fa-2x fa-fw {* var icon.value *}"></i>{* endif icon.type *}
{* var icon.value *}
<br /><br />
<ul>
<li>{* lang xml.vendor *}: {* var vendor *}</li>
<li>{* lang xml.version *}: {* var version *}</li>
<li>{* lang xml.published *}: {* var published *}</li>
<li>{* lang xml.copyright *}: {* var copyright *}</li>
<li>{* lang xml.license *}: {* var license *}</li>
<li>{* lang default.info *}: {* var info *}</li>
<li>{* lang xml.authors_current *}:
{* foreach authors.current *}
<ul>
<li>{* var current.value *}</li>
{* endforeach authors.current *}
</ul>
</li>
<li>{* lang xml.authors_past *}:
{* foreach authors.past *}
<ul>
<li>{* var past.value *}</li>
{* endforeach authors.past *}
</ul>
</li>
<li>{* lang xml.contact_email *}:
{* foreach contact.email *}
<ul>
<li>{* var email.adress *}</li>
{* endforeach contact.email *}
</ul>
</li>
<li>{* lang xml.contact_web *}:
{* foreach contact.web *}
<ul>
<li>{* var web.url *}</li>
{* endforeach contact.web *}
</ul>
</li>
<li>{* lang xml.php_required *}: {* var required.php *}</li>
<li>{* lang xml.php_extensions *}:
<ul>
{* foreach required.extension *}
<li>{* var extension.value *}</li>
{* endforeach required.extension *}
</ul>
</li>
{* foreach environment *}
<li>{* lang xml.environment_needed *}:
<ul>
{* foreach environment.needed *}
<li>{* lang xml.plugin *} {* var needed.plugin *} {* lang xml.version *} {* var needed.version_min *}
{* if needed.version_max != '' *} {* lang xml.until *} {* var needed.version_max *}{* endif needed.version_max *}
</li>
{* endforeach environment.needed *}
</ul>
</li>
<li>{* lang xml.environment_extends *}:
<ul>
{* foreach environment.extend *}
<li>{* lang xml.plugin *} {* var extend.plugin *} {* lang xml.version *} {* var extend.version_min *}
{* if extend.version_max != '' *} {* lang xml.until *} {* var extend.version_max *}{* endif extend.version_max *}
</li>
{* endforeach environment.extend *}
</ul>
</li>
{* endforeach environment *}
<li>{* lang xml.entries *}:
<ul>
{* foreach entries.target *}
<li>{* lang xml.plugin *}: {* var target.plugin *}  - {* lang xml.action *}: {* var target.action *}</li>
{* endforeach entries.target *}
</ul>
</li>
</ul>