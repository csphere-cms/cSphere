{* lang plugin *}: {* var name *}
<br /><br />
{* lang engine *}: {* var engine.name *} {* var engine.version_min *}
{* if engine.version_max != '' *} {* lang until *} {* var engine.version_max *}{* endif engine.version_max *}
<br /><br />
{* lang icon *}:
{* if icon.type == 'fontawesome' *} <i class="fa fa-2x fa-fw {* var icon.value *}"></i>{* endif icon.type *}
{* var icon.value *}
<br /><br />
<ul>
<li>{* lang vendor *}: {* var vendor *}</li>
<li>{* lang version *}: {* var version *}</li>
<li>{* lang published *}: {* var published *}</li>
<li>{* lang copyright *}: {* var copyright *}</li>
<li>{* lang license *}: {* var license *}</li>
<li>{* lang info *}: {* var info *}</li>
<li>{* lang authors_current *}:
{* foreach authors.current *}
<ul>
<li>{* var current.value *}</li>
{* endforeach authors.current *}
</ul>
</li>
<li>{* lang authors_past *}:
{* foreach authors.past *}
<ul>
<li>{* var past.value *}</li>
{* endforeach authors.past *}
</ul>
</li>
<li>{* lang contact_email *}:
{* foreach contact.email *}
<ul>
<li>{* var email.adress *}</li>
{* endforeach contact.email *}
</ul>
</li>
<li>{* lang contact_web *}:
{* foreach contact.web *}
<ul>
<li>{* var web.url *}</li>
{* endforeach contact.web *}
</ul>
</li>
<li>{* lang php_required *}: {* var required.php *}</li>
<li>{* lang php_extensions *}:
<ul>
{* foreach required.extension *}
<li>{* var extension.value *}</li>
{* endforeach required.extension *}
</ul>
</li>
{* foreach environment *}
<li>{* lang environment_needed *}:
<ul>
{* foreach environment.needed *}
<li>{* lang plugin *} {* var needed.plugin *} {* lang version *} {* var needed.version_min *}
{* if needed.version_max != '' *} {* lang until *} {* var needed.version_max *}{* endif needed.version_max *}
</li>
{* endforeach environment.needed *}
</ul>
</li>
<li>{* lang environment_extends *}:
<ul>
{* foreach environment.extend *}
<li>{* lang plugin *} {* var extend.plugin *} {* lang version *} {* var extend.version_min *}
{* if extend.version_max != '' *} {* lang until *} {* var extend.version_max *}{* endif extend.version_max *}
</li>
{* endforeach environment.extend *}
</ul>
</li>
{* endforeach environment *}
<li>{* lang entries *}:
<ul>
{* foreach entries.target *}
<li>{* lang plugin *}: {* var target.plugin *}  - {* lang action *}: {* var target.action *}</li>
{* endforeach entries.target *}
</ul>
</li>
</ul>