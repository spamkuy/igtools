 <div class="c-dropdown dropdown u-ml-small">
    <a  class="c-avatar c-avatar--xsmall has-dropdown dropdown-toggle" href="#" id="dropdwonMenuAvatar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <img class="c-avatar__img" src="<?= $_SESSION['picture'] ?>" alt="User's Profile Picture">
    </a>

    <div class="c-dropdown__menu dropdown-menu dropdown-menu-right" aria-labelledby="dropdwonMenuAvatar">
        <a class="c-dropdown__item dropdown-item" href="?module=userinfo"> <i class="fa fa-user-o"></i> 
            User Info
        </a>
        <a class="c-dropdown__item dropdown-item" href="./keluar"> <i class="fa fa-sign-out"></i> 
            LogOut
        </a>
    </div>
</div>