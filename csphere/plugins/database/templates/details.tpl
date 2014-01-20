<div class="main_content_div">

<a href="{* link database/install/dir/$dir$ *}">{* lang install *}</a>
- <a href="{* link database/uninstall/dir/$dir$ *}">{* lang uninstall *}</a>
<br /><br />

{* lang xml.plugin *}: {* var plugin *}
<br /><br />
{* lang tables *}:
<br /><br />
{* foreach tables *}
<ul>
<li>{* lang name *}: {* var tables.name *}</li>
<li>{* lang columns *}:
<ul>
{* foreach tables.columns *}
<li>{* var columns.name *} - {* var columns.datatype *}
{* if columns.max != '0' *} ({* var columns.max *}){* endif columns.max *}
{* if columns.default != '' *}- default {* var columns.default *}{* endif columns.default *}
</li>
{* endforeach tables.columns *}
</ul>
</li>

<li>{* lang primary *}:
<ul>
{* foreach tables.primary *}
<li>{* var primary.name *}</li>
{* endforeach tables.primary *}
</ul>
</li>

<li>{* lang uniques *}:
<ul>
{* foreach tables.uniques *}
<li>{* lang name *}: {* var uniques.name *}</li>
<ul>
{* foreach uniques.column *}
<li>{* var column.name *}</li>
{* endforeach uniques.column *}
</ul>
{* endforeach tables.uniques *}
</ul>
</li>

<li>{* lang indexes *}:
<ul>
{* foreach tables.indexes *}
<li>{* lang name *}: {* var indexes.name *}</li>
<ul>
{* foreach indexes.column *}
<li>{* var column.name *}</li>
{* endforeach indexes.column *}
</ul>
{* endforeach tables.indexes *}
</ul>
</li>

<li>{* lang foreigns *}:
<ul>
{* foreach tables.foreigns *}
<li>{* lang name *}: {* var foreigns.table *}</li>
<ul>
{* foreach foreigns.column *}
<li>{* var column.name *} -&gt; {* var column.target *}</li>
{* endforeach foreigns.column *}
</ul>
{* endforeach tables.foreigns *}
</ul>
</li>
</ul>
<br /><br />
{* else tables *}
{* lang no_table_found *}
{* endforeach tables *}
{* lang data *}:
<br /><br />

<ul>
<li>{* lang inserts *}:
<ul>
{* foreach data.insert *}
<li>{* lang table *}: {* var insert.table *}</li>
<ul>
{* foreach insert.column *}
<li>{* var column.name *} = {* var column.value *}</li>
{* endforeach insert.column *}
</ul>
{* endforeach data.insert *}
</ul>
</li>
</ul>
<ul>
<li>{* lang updates *}:
<ul>
{* foreach data.update *}
<li>{* lang table *}: {* var update.table *}</li>
<ul>
{* foreach update.column *}
<li>{* var column.name *} = {* var column.value *}</li>
{* endforeach update.column *}
</ul>
<li>{* lang where *}:</li>
<ul>
{* foreach update.where *}
<li>{* var where.column *} == {* var where.value *}</li>
{* endforeach update.where *}
</ul>
{* endforeach data.update *}
</ul>
</li>
</ul>
<ul>
<li>{* lang deletes *}:
<ul>
{* foreach data.delete *}
<li>{* lang table *}: {* var delete.table *}</li>
<ul>
{* foreach delete.where *}
<li>{* var where.column *} == {* var where.value *}</li>
{* endforeach delete.where *}
</ul>
{* endforeach data.delete *}
</ul>
</li>
</ul>
<br /><br />

</div>