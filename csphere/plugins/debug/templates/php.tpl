<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=debug action=php_details *}

        <ul class="nav nav-tabs nav-justified">
            <li><a href="{* link debug/control *}">{* lang default.control *}</a></li>
            <li class="active"><a href="{* link debug/php *}">{* lang php_details *}</a></li>
            <li><a href="{* link debug/space *}">{* lang disk_space *}</a></li>
        </ul><!--END nav-tabs-->

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>{* lang php_setting *}</th>
                    <th>{* lang name *}</th>
                    <th class="text-center">{* lang value *}</th>
                </tr>
            </thead><!--END table thead-->

            <tbody>
                <tr>
                    <td>{* lang short_open_tag *}</td>
                    <td>short_open_tag</td>
                    <td class="text-center">{* var short_open_tag *}</td>
                </tr>
                <tr>
                    <td>{* lang open_basedir *}</td>
                    <td>open_basedir</td>
                    <td class="text-center">{* var open_basedir *}</td>
                </tr>
                <tr>
                    <td>{* lang file_uploads *}</td>
                    <td>file_uploads</td>
                    <td class="text-center">{* var file_uploads *}</td>
                </tr>
                <tr>
                    <td>{* lang allow_url_fopen *}</td>
                    <td>allow_url_fopen</td>
                    <td class="text-center">{* var allow_url_fopen *}</td>
                </tr>
                <tr>
                    <td>{* lang allow_url_include *}</td>
                    <td>allow_url_include</td>
                    <td class="text-center">{* var allow_url_include *}</td>
                </tr>
                <tr>
                    <td>{* lang post_max_size *}</td>
                    <td>post_max_size</td>
                    <td class="text-center">{* var post_max_size *}</td>
                </tr>
                <tr>
                    <td>{* lang upload_max_filesize *}</td>
                    <td>upload_max_filesize</td>
                    <td class="text-center">{* var upload_max_filesize *}</td>
                </tr>
                <tr>
                    <td>{* lang memory_limit *}</td>
                    <td>memory_limit</td>
                    <td class="text-center">{* var memory_limit *}</td>
                </tr>
                <tr>
                    <td>{* lang max_input_time *}</td>
                    <td>max_input_time</td>
                    <td class="text-center">{* var max_input_time *}</td>
                </tr>
                <tr>
                    <td>{* lang max_execution_time *}</td>
                    <td>max_execution_time</td>
                    <td class="text-center">{* var max_execution_time *}</td>
                </tr>
            </tbody><!--END table tbody-->
        </table><!--END table-->

        <div class="well text-center">
            <h4>{* lang php_extensions *}:</h4>

            <br />

            {* foreach extensions *}
                {* raw extensions.name *} &nbsp;&nbsp;
            {* endforeach extensions *}
        </div><!--END well-->

    </div><!--END panel-body-->
</div><!--END panel-->