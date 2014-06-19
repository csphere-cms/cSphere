<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=contact.contact action=default.create *}

        <br>

        <form class="form-horizontal" role="form" action="{* link contact/create *}" method="POST">

            {* tpl default/com_input name=contact_name label=default.name value=contact.contact_name *}

            {* tpl default/com_input name=contact_mail label=default.contact_email value=contact.contact_mail *}

            {* tpl default/com_input name=contact_url label=default.contact_web value=contact.contact_url *}

            {* tpl default/com_input name=contact_subject label=contact.subject value=contact.contact_subject *}

            {* tpl default/com_textarea rows=4 name=contact_message label=contact.message value=contact.contact_message *}

            {* tpl default/com_submit_btn caption=default.save *}

        </form><!--END form-->

    </div><!--END panel-body-->
</div><!--END panel-->
