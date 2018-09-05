<a class="c-notification dropdown-toggle" href="javascript:;" id="dropdownMenuAlerts" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="c-notification__icon">
        <i class="fa fa-share-alt"></i>
    </span>
</a>

<style type="text/css">
.c-avatar--xsmall .c-avatar__img {
    width: 27px;
    height: 27px;
}    
</style>

<div class="c-dropdown__menu c-dropdown__menu--large dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuAlerts">
    <a href="whatsapp://send?text=<?= $settings['desc']." - ".$baseurl ?>" class="c-dropdown__item dropdown-item o-media">
        <span class="o-media__img u-mr-xsmall">
            <span class="c-avatar c-avatar--xsmall">
                <span class="c-avatar__img u-bg-success u-flex u-justify-center u-align-items-center">
                <i class="fa fa-whatsapp u-text-large u-color-white"></i>
                </span>
            </span>

        </span>
        <div class="o-media__body">
            <h6 class="u-mb-zero">Share to WhatsApp</h6>          
        </div>
    </a>
    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $baseurl ?>" class="c-dropdown__item dropdown-item o-media">
        <span class="o-media__img u-mr-xsmall">
            <span class="c-avatar c-avatar--xsmall">
                <span class="c-avatar__img u-bg-info u-flex u-justify-center u-align-items-center">
                    <i class="fa fa-facebook u-text-large u-color-white"></i>
                </span>
            </span>

        </span>
        <div class="o-media__body">
            <h6 class="u-mb-zero">Share to Facebook</h6>          
        </div>
    </a>
    <a href="http://plus.google.com/share?url=<?= $baseurl ?>" class="c-dropdown__item dropdown-item o-media">
        <span class="o-media__img u-mr-xsmall">
            <span class="c-avatar c-avatar--xsmall">
                <span class="c-avatar__img u-bg-warning u-flex u-justify-center u-align-items-center">
                    <i class="fa fa-google-plus u-text-large u-color-white"></i>
                </span>
            </span>

        </span>
        <div class="o-media__body">
            <h6 class="u-mb-zero">Share to Google Plus</h6>          
        </div>
    </a>
</div>