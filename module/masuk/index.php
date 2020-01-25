<div class="col-md-6">
    <div class="c-card c-card--responsive u-mb-medium">
        <div class="c-card__header c-card__header--transparent o-line">            
            <h5 class="c-card__title">Masuk Menggunakan Private Kode</h5>
        </div>
        <div class="c-card__body">
            <form method="POST">
                <div class="c-field u-mb-small">
                    <textarea name="code" class="c-input" placeholder="Masukan Kode..."></textarea>
                </div>
                <input class="c-btn c-btn--info c-btn--fullwidth" name="bycode" type="submit" value="Submit"/>
            </form>
        </div>
    </div>
</div>

<div class="col-md-6">
    <div class="c-card c-card--responsive u-mb-medium">
        <div class="c-card__header c-card__header--transparent o-line">            
            <h5 class="c-card__title">Masuk Menggunakan Cookies Instagram</h5>
        </div>
        <div class="c-card__body">
            <form method="POST">
                <div class="c-field u-mb-small">
                  <textarea name="cookies" class="c-input" placeholder="Masukan Cookies..."></textarea>
              </div>
              <input class="c-btn c-btn--info c-btn--fullwidth" name="bycookies" type="submit" value="Submit"/>
          </form>
      </div>
  </div>
</div>


<div class="col-md-6">
    <div class="c-card c-card--responsive u-mb-medium">
        <div class="c-card__header c-card__header--transparent o-line">            
            <h5 class="c-card__title">Masuk Menggunakan Akun Instagram</h5>
        </div>
        <div class="c-card__body">
            <form method="POST">
                <div class="c-field u-mb-small">
                    <input name="username" class="c-input" type="text" placeholder="username"> 
                </div>
                <div class="c-field u-mb-small">
                    <input name="password" class="c-input" type="password"" placeholder="Password"> 
                </div>
                <input class="c-btn c-btn--info c-btn--fullwidth" name="byaccount" type="submit" value="Submit"/>
            </form>
        </div>
    </div>
</div>

<div class="col-md-6">
    <div class="c-card c-card--responsive u-mb-medium">
        <div class="c-card__header c-card__header--transparent o-line">            
            <h5 class="c-card__title">Masuk Menggunakan Facebook</h5>
        </div>
        <div class="c-card__body">
            <form method="POST">
                <div class="c-field u-mb-small">
                    <textarea name="token" class="c-input" placeholder="Insert Token..."></textarea>
                </div>
                <input class="c-btn c-btn--info" name="bytoken" type="submit" value="Submit"/>
                <button type="button" class="c-btn c-btn--success" data-toggle="modal" data-target="#modal-gettoken">
                    Cara Mendapatkan Token
                </button>

                <!-- Modal -->
                <div class="c-modal modal fade" id="modal-gettoken" tabindex="-1" role="dialog" aria-labelledby="modal-gettoken" data-backdrop="static">
                    <div class="c-modal__dialog modal-dialog" role="document">
                        <div class="c-modal__content">

                            <div class="c-modal__header">
                                <h3 class="c-modal__title">Intruksi Mendapatkan Token</h3>

                                <span class="c-modal__close" data-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-close"></i>
                                </span>
                            </div>

                            <div class="c-modal__subheader">
                            <i class="c-alert__icon fa fa-check-circle"></i> Pastikan anda Sudah Login Facebook dan Instagram Terhubung dengan facebook !
                            </div>

                            <div class="c-modal__body">
                                <p><b>Pertama Kunjungi Link dibawah ini Menggunakan Browser Google Chrome</b></p><br>
                                <input readonly="" value="view-source:https://goo.gl/qDkyYg" class="c-input" onClick="this.select();">
                                <br><p><b>Setelah itu anda Copy Hasil URLnya</b></p><br>
                                <a href="assets/img/gettoken.png" target="_blank"><img src="assets/img/gettoken.png"/></a>
                                <br><p><b>Masukan URL yang telah dicopy kedalam Form Masuk Menggunakan Facebook</b></p><br>
                                <a href="assets/img/gettoken_pasteurl.png" target="_blank"><img src="assets/img/gettoken_pasteurl.png"/></a>
                            </div>

                        </div><!-- // .c-modal__content -->
                    </div><!-- // .c-modal__dialog -->
                </div><!-- // .c-modal -->
            </div>

        </form>
    </div>
</div>
</div>

<?php  
include "execute.php";
?>