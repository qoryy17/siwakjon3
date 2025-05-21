 <!-- This form for make a report -->
 <form action="{{ route('pengawasan.simpan-laporan') }}" method="POST">
     <div class="modal fade modal-animate" id="animateModalLaporan" tabindex="-1" aria-hidden="true">
         <div class="modal-dialog modal-xl">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title">{{ $pengawasan ? 'Edit' : 'Tambah' }} Pengawasan</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                 </div>
                 <div class="modal-body">
                     @csrf
                     @method('POST')
                     <div class="mb-3" hidden>
                         <label for="id">
                             ID
                             <span class="text-danger">*</span>
                         </label>
                         <input type="text" class="form-control" required value="{{ Crypt::encrypt($rapat->id) }}"
                             readonly id="id" name="id">
                     </div>
                     <div class="mb-3" hidden>
                         <label for="kodePengawasan">
                             Kode Pengawasan
                             <span class="text-danger">*</span>
                         </label>
                         <input type="text" class="form-control" required value="{{ $kodePengawasan }}" readonly
                             id="kodePengawasan" name="kodePengawasan">
                     </div>
                     <div class="mb-3" hidden>
                         <input type="text" class="form-control" name="param" readonly
                             value="{{ Crypt::encrypt('save') }}">
                     </div>
                     <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                         <li class="nav-item">
                             <a class="nav-link active" id="pills-tab1-tab" data-bs-toggle="pill" href="#pills-tab1"
                                 role="tab" aria-controls="pills-tab1" aria-selected="true">Objek/Unit
                                 Pengawasan
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" id="pills-tab2-tab" data-bs-toggle="pill" href="#pills-tab2"
                                 role="tab" aria-controls="pills-tab2" aria-selected="false">Deskripsi
                                 Ruang Lingkup Pengawasan
                             </a>
                         </li>
                     </ul>
                     <div class="tab-content" id="pills-tabContent">
                         <div class="tab-pane fade show active" id="pills-tab1" role="tabpanel"
                             aria-labelledby="pills-home-tab">
                             <div class="mb-3">
                                 <label class="form-label" for="unitKerja">Objek/Unit Pengawasan
                                     <span class="text-danger">*</span>
                                 </label>
                                 <select class="form-control" data-trigger name="unitKerja" id="unitKerja" required>
                                     <option value="">Pilih Objek/Unit Pengawasan</option>
                                     @foreach ($unitKerja as $objek)
                                         <option value="{{ $objek->id }}"
                                             @if (old('unitKerja') == $objek->unit_kerja) selected @elseif($pengawasan && $pengawasan->objek_pengawasan == $objek->unit_kerja) selected @endif>
                                             {{ $objek->unit_kerja }}
                                         </option>
                                     @endforeach
                                 </select>
                                 @error('unitKerja')
                                     <small class="text-danger mt-1">* {{ $message }}</small>
                                 @enderror
                             </div>
                             <div class="mb-3">
                                 <label class="form-label" for="dasarHukum">Dasar Hukum
                                     <span class="text-danger">*</span>
                                 </label>
                                 <textarea name="dasarHukum" id="dasarHukum" class="form-control" style="max-height: 10%;"
                                     placeholder="Dasar Hukum... Cth: Undang-Undang Nomor: 48 Tahun 2009 Tentang Kekuasaan Kehakiman;">{!! $pengawasan ? $pengawasan->dasar_hukum : '' !!}</textarea>
                                 @error('dasarHukum')
                                     <small class="text-danger mt-1">* {{ $message }}</small>
                                 @enderror
                             </div>
                         </div>
                         <div class="tab-pane fade" id="pills-tab2" role="tabpanel" aria-labelledby="pills-tab2-tab">
                             <div class="mb-3">
                                 <label class="form-label" for="deskripsiPengawasan">Deskripsi Ruang Lingkup Pengawasan
                                     <span class="text-danger">*</span>
                                 </label>
                                 <textarea name="deskripsiPengawasan" id="deskripsiPengawasan" class="form-control"
                                     placeholder="Deskripsi Pengawasan... Cth: Disiplin Pegawai, Tata Kelola BMN">{!! $pengawasan ? $pengawasan->deskripsi_pengawasan : old('deskripsiPengawasan') !!}</textarea>
                                 @error('deskripsiPengawasan')
                                     <small class="text-danger mt-1">* {{ $message }}</small>
                                 @enderror
                             </div>
                         </div>
                     </div>

                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                     <button type="submit" class="btn btn-primary">Simpan</button>
                 </div>
             </div>
         </div>
     </div>
 </form>
