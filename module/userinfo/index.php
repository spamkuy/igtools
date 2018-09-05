<div class="col-md-12">
    <div class="c-card u-p-medium u-mb-medium">

        <div class="u-text-center">
            <div class="c-avatar c-avatar--large u-mb-small u-inline-flex">
                <img class="c-avatar__img" src="<?= $_SESSION['picture'] ?>" alt="Adam's Face">
            </div>
        </div>

        <table class="c-table u-text-left u-pv-small u-mt-medium u-border-right-zero u-border-left-zero">
            <tr>
                <td style="width:20%">User ID</td>
                <td style="width: 1%">:</td>
                <td style="padding: 5px;"><input onclick="this.select()" readonly="" class="c-input" type="text" value="<?= $_SESSION['userid']; ?>"></td>
            </tr>   
            <tr>
                <td style="width:20%">Username</td>
                <td style="width: 1%">:</td>
                <td style="padding: 5px;"><input onclick="this.select()" readonly="" class="c-input" type="text" value="@<?= $_SESSION['username']; ?>"></td>
            </tr>   
            <tr>
                <td style="width:20%">Cookies</td>
                <td style="width: 1%">:</td>
                <td style="padding: 5px;"><input onclick="this.select()" readonly="" class="c-input" type="text" value="<?= $_SESSION['cookies']; ?>"></td>
            </tr>   
            <tr>
                <td style="width:20%">Kode Untuk Masuk Kembali</td>
                <td style="width: 1%">:</td>
                <td style="padding: 5px;"><input onclick="this.select()" readonly="" class="c-input" type="text" value="<?= $_SESSION['device_id']; ?>"></td>
            </tr>   
        </table>

        <div class="u-pt-medium u-text-center">
            <a target="_blank" class="u-text-mute u-text-small" href="https://instagram.com/<?= $_SESSION['username'] ?>">
                <i class="fa fa-globe u-mr-xsmall"></i>https://instagram.com/<?= $_SESSION['username'] ?>
            </a>
        </div>
    </div>
</div>