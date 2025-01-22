<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalNotificationTitle">Perhatian !</h5>
        </div>
        <div class="modal-body text-center">
            <p>
                Selamat datang di aplikasi {{ env('APP_NAME') }}. Aplikasi ini digunakan untuk
                <strong>Memudahkan Penataan Dokumen Rapat, Pengawasan, Laporan Monitoring dan Evaluasi Serta
                    Arsip Surat Keputusan</strong>. Silahkan gunakan
                aplikasi ini dengan bijak dan sebaik mungkin.
            </p>
            @if (\App\Helpers\ViewUser::jabatan() == \App\Enum\JabatanEnum::HAKIM->value)
                <hr>
                <div class="alert alert-warning" role="alert">
                    Himbauan Bagi <strong>Hakim Pengawas</strong> agar menginput kunjungan pengawasan pada
                    menu <strong>Pengawasan
                        Bidang
                        > Kunjungan Pengawasan</strong> atau <a href="{{ route('kunjungan.index') }}"
                        class="text-secondary">Klik
                        Disini !</a>
                </div>
            @endif
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
