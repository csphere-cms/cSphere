<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=contact.contact action=default.view *}

        <br>

        <table class="table table-striped table-hover">
            <tr>
                <th>
                    {* lang default.name *}
                </th>
                <td>
                    {* var contact.contact_name *}
                </td>
            </tr>
            <tr>
                <th>
                    {* lang default.date *}
                </th>
                <td>
                    {* date contact.contact_date *}
                </td>
            </tr>
            <tr>
                <th>
                    {* lang default.contact_email *}
                </th>
                <td>
                    {* var contact.contact_mail *}
                </td>
            </tr>
            <tr>
                <th>
                    {* lang contact.message *}
                </th>
                <td>
                    {* var contact.contact_message *}
                </td>
            </tr>
            {* if contact.contact_reply != '' *}
                <tr>
                    <th>{* lang contact.reply *}</th>
                    <td>{* var contact.contact_reply *}</td>
                </tr>
                <tr>
                    <th>{* lang contact.replyDate *}</th>
                    <td>{* date contact.contact_reply_date *}</td>
                </tr>
            {* endif contact.contact_reply *}
        </table><!--END table-->

        <br>
        {* if contact.contact_reply == '' *}
            <form class="form" id="reply" role="form" action="{* link contact/reply/id/$contact.contact_id *}" method="POST">

                {* tpl default/com_textarea rows=4 name=contact_reply label=contact.reply value=contact.contact_reply holder=contact.reply *}

                {* tpl default/com_submit_btn caption=default.send *}

            </form>
        {* endif contact.contact_reply *}
    </div><!--END panel-body-->
</div><!--END panel-->
