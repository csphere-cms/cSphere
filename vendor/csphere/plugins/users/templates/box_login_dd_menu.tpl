<ul id="users-login-menu-box" class="nav navbar-nav navbar-right">
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" id="dropdownUsermenu" data-toggle="dropdown">{* var user_name *}  <b class="caret"></b></a>

        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownUsermenu">
            <li role="presentation"><a href="{* link users/view/id/$user_id$ *}" role="menuitem" tabindex="-1">{* var user_name *}</a></li>
            <li role="presentation" class="divider"></li>
            <li role="presentation"><a href="{* link users/home *}" role="menuitem" tabindex="-1">{* lang home *}</a></li>
            <li role="presentation"><a href="{* link users/visits *}" role="menuitem" tabindex="-1">{* lang visits *}</a></li>
            <li role="presentation"><a href="{* link users/settings *}" role="menuitem" tabindex="-1">{* lang settings *}</a></li>
            <li role="presentation"><a href="{* link users/profile *}" role="menuitem" tabindex="-1">{* lang profile *}</a></li>
            <li role="presentation" class="divider"></li>
            <li role="presentation"><a href="{* link users/logout *}" role="menuitem" tabindex="-1">{* lang logout *}</a></li>
        </ul>
    </li>
</ul><!--END users-login-menu-box-->