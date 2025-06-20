@extends('layouts.backend.admin')

@section('content')
    @include('layouts.backend.alert')
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card-box mb-30">
                <div class="card-body">
                    <form action="{{ route('santri.store') }}" method="POST">
                        @csrf
                        @method('POST')
                        <input type="hidde" name="id" value="{{ $santri->id }}">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control" value="{{ $santri->nama }}" required>
                        </div>
                        <div class="form-group">
                            <label>Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control"
                                value="{{ $santri->tempat_lahir }}">
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control"
                                value="{{ $santri->tanggal_lahir }}">
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-control">
                                <option value="Laki-laki" {{ $santri->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki</option>
                                <option value="Perempuan" {{ $santri->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Hobi</label>
                            <input type="text" name="hobi" class="form-control" value="{{ $santri->hobi }}">
                        </div>
                        <div class="form-group">
                            <label>Cita-cita</label>
                            <input type="text" name="cita_cita" class="form-control" value="{{ $santri->cita_cita }}">
                        </div>
                        <div class="form-group">
                            <label>Golongan Darah</label>
                            <input type="text" name="golongan_darah" class="form-control"
                                value="{{ $santri->golongan_darah }}">
                        </div>
                        <div class="form-group">
                            <label>No. Telp</label>
                            <input type="text" name="no_telp" class="form-control" value="{{ $santri->no_telp }}">
                        </div>
                        <div class="form-group">
                            <label>Status Rumah</label>
                            <input type="text" name="status_rumah" class="form-control"
                                value="{{ $santri->status_rumah }}">
                        </div>
                        <div class="form-group">
                            <label>Alamat Rumah</label>
                            <textarea name="alamat_rumah" class="form-control">{{ $santri->alamat_rumah }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>No KK</label>
                            <input type="text" name="no_kk" class="form-control" value="{{ $santri->no_kk }}">
                        </div>
                        <div class="form-group">
                            <label>NIK Siswa</label>
                            <input type="text" name="nik_siswa" class="form-control" value="{{ $santri->nik_siswa }}">
                        </div>
                        <div class="form-group">
                            <label>NISN</label>
                            <input type="text" name="nisn" class="form-control" value="{{ $santri->nisn }}">
                        </div>
                        <div class="form-group">
                            <label>No Induk</label>
                            <input type="text" name="no_induk" class="form-control" value="{{ $santri->no_induk }}">
                        </div>
                        <hr>
                        <h5>Data Ayah</h5>
                        <div class="form-group">
                            <label>Nama Ayah</label>
                            <input type="text" name="nama_ayah" class="form-control" value="{{ $santri->nama_ayah }}">
                        </div>
                        <div class="form-group">
                            <label>Pekerjaan Ayah</label>
                            <input type="text" name="pekerjaan_ayah" class="form-control"
                                value="{{ $santri->pekerjaan_ayah }}">
                        </div>
                        <div class="form-group">
                            <label>No HP Ayah</label>
                            <input type="text" name="no_hp_ayah" class="form-control" value="{{ $santri->no_hp_ayah }}">
                        </div>
                        <hr>
                        <h5>Data Ibu</h5>
                        <div class="form-group">
                            <label>Nama Ibu</label>
                            <input type="text" name="nama_ibu" class="form-control" value="{{ $santri->nama_ibu }}">
                        </div>
                        <div class="form-group">
                            <label>Pekerjaan Ibu</label>
                            <input type="text" name="pekerjaan_ibu" class="form-control"
                                value="{{ $santri->pekerjaan_ibu }}">
                        </div>
                        <div class="form-group">
                            <label>No HP Ibu</label>
                            <input type="text" name="no_hp_ibu" class="form-control"
                                value="{{ $santri->no_hp_ibu }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('santri') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script>
        $(document).ready(function() {
            $('#formSantri').on('submit', function(e) {
                e.preventDefault(); // stop default form submit

                let form = $(this);
                let url = form.attr('action');
                let data = form.serialize();

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: data,
                    success: function(response) {
                        // tampilkan pesan sukses
                        alert('Data berhasil disimpan');
                        // bisa juga redirect:
                        window.location.href = "{{ route('santri') }}";
                    },
                    error: function(xhr, status, error) {
                        // tampilkan pesan error
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
