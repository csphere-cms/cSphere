<div class="main_content_div">

Database content for plugin: {* var plugin *}
<br /><br />
Tables:
<br /><br />
{* foreach tables *}
<ul>
<li>Name: {* var tables.name *}</li>
<li>Columns:
<ul>
{* foreach tables.columns *}
<li>{* var columns.name *} - {* var columns.datatype *}
{* if columns.max != '0' *} ({* var columns.max *}){* endif columns.max *}
{* if columns.default != '' *}- default {* var columns.default *}{* endif columns.default *}
</li>
{* endforeach tables.columns *}
</ul>
</li>

<li>Primary:
<ul>
{* foreach tables.primary *}
<li>{* var primary.name *}</li>
{* endforeach tables.primary *}
</ul>
</li>

<li>Uniques:
<ul>
{* foreach tables.uniques *}
<li>Name: {* var uniques.name *}</li>
<ul>
{* foreach uniques.column *}
<li>{* var column.name *}</li>
{* endforeach uniques.column *}
</ul>
{* endforeach tables.uniques *}
</ul>
</li>

<li>Indexes:
<ul>
{* foreach tables.indexes *}
<li>Name: {* var indexes.name *}</li>
<ul>
{* foreach indexes.column *}
<li>{* var column.name *}</li>
{* endforeach indexes.column *}
</ul>
{* endforeach tables.indexes *}
</ul>
</li>

<li>Foreigns:
<ul>
{* foreach tables.foreigns *}
<li>Name: {* var foreigns.table *}</li>
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
No tables found
{* endforeach tables *}
Data:
<br /><br />
{* foreach data *}
<ul>
<li>Inserts:
<ul>
{* foreach data.insert *}
<li>Table: {* var insert.table *}</li>
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
<li>Updates:
<ul>
{* foreach data.update *}
<li>Table: {* var update.table *}</li>
<ul>
{* foreach update.column *}
<li>{* var column.name *} = {* var column.value *}</li>
{* endforeach update.column *}
</ul>
<li>Where:</li>
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
<li>Deletes:
<ul>
{* foreach data.delete *}
<li>Table: {* var delete.table *}</li>
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
{* else data *}
No data found
{* endforeach data *}

</div>