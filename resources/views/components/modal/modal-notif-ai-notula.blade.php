<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalAINotulaTitle">Info Update Terbaru !</h5>
        </div>
        <div class="modal-body text-center">
            <p>
                Yeeee.... {{ env('APP_NAME') }} kini telah terintegrasi dengan <b>Model AI (Artificial Intelligence
                    /Kecerdasan Buatan)</b>, sekarang kamu dapat menggunakan bantuan AI untuk memperbaiki catatan dan
                kesimpulan pada notula rapat kamu yah !
            </p>
            <p>
                Klik tombol<b> berwarna biru dibawah editor catatan dan kesimpulan pada notula</b>, untuk menggunakan
                AI.
            </p>
            <hr>
            <p>
                Jika ada kendala atau pertanyaan mengenai aplikasi, silahkan hubungi
                <strong>{{ env('APP_AUTHOR') }}</strong>
                Selaku <strong>Developer</strong> Pengembang Sistem Informasi.
            </p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>
