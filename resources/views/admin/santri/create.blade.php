@extends('layouts.backend.admin')

@section('content')
    @include('layouts.backend.alert')
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card-box mb-30">
                <div class="card-body">
                    <form action="{{ route('santri.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control" ired>
                        </div>

                        <div class="form-group">
                            <label>Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-control">
                                <option value="Laki-laki">
                                    Laki-laki</option>
                                <option value="Perempuan"s>
                                    Perempuan</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Hobi</label>
                            <input type="text" name="hobi" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Cita-cita</label>
                            <input type="text" name="cita_cita" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Golongan Darah</label>
                            <input type="text" name="golongan_darah" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>No. Telp</label>
                            <input type="text" name="no_telp" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Status Rumah</label>
                            <input type="text" name="status_rumah" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Alamat Rumah</label>
                            <textarea name="alamat_rumah" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <label>No KK</label>
                            <input type="text" name="no_kk" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>NIK Siswa</label>
                            <input type="text" name="nik_siswa" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>NISN</label>
                            <input type="text" name="nisn" class="form-control" </div>

                            <div class="form-group">
                                <label>No Induk</label>
                                <input type="text" name="no_induk" class="form-control" . </div>

                                <hr>

                                <h5>Data Ayah</h5>

                                <div class="form-group">
                                    <label>Nama Ayah</label>
                                    <input type="text" name="nama_ayah" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Pekerjaan Ayah</label>
                                    <input type="text" name="pekerjaan_ayah" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>No HP Ayah</label>
                                    <input type="text" name="no_hp_ayah" class="form-control">
                                </div>

                                <hr>

                                <h5>Data Ibu</h5>

                                <div class="form-group">
                                    <label>Nama Ibu</label>
                                    <input type="text" name="nama_ibu" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Pekerjaan Ibu</label>
                                    <input type="text" name="pekerjaan_ibu" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>No HP Ibu</label>
                                    <input type="text" name="no_hp_ibu" class="form-control">
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('santri') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
