@extends('layouts.backend.admin')

@section('content')
    @include('layouts.backend.alert')

    <!-- Button trigger modal -->
    <div class="dt-action-buttons text-end pt-3 pt-md-0 mb-4">
        <div class=" btn-group " role="group">
            <button class="btn btn-secondary refresh btn-default" type="button">
                <span>
                    <i class="bi bi-arrow-clockwise me-sm-1"> </i>
                    <span class="d-none d-sm-inline-block">Refresh Data</span>
                </span>
            </button>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card-box mb-30 p-3">

                <table id="datatable-customers" class="table table-h0ver  display mb-3">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tahun</th>
                            <th>Semester</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Tahun</th>
                            <th>Semester</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="komentarModal" tabindex="-1" aria-labelledby="penilaianModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ url('penilaian/store-komentar') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="penilaianModalLabel">Tambah Komentar</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered table-sm">
                            <input type="hidden" name="id_santri" value="{{ $santri->id }}">
                            <input type="hidden" name="id_tahun_ajaran" id="idTahunAjaranKomen">
                            @foreach (App\Models\KategoriPenilaian::all() as $item)
                                <tr>
                                    <td colspan="2"><b>{{ $item->kategori }}</b></td>
                                </tr>
                                <tr>
                                    <td style="width: 150px;">Komentar : </td>
                                    <td>
                                        <input type="hidden" name="id_kategori[]" value="{{ $item->id }}">
                                        <textarea class="form-control" name="komentar[]" cols="2"></textarea>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="penilaianModal" tabindex="-1" aria-labelledby="penilaianModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ url('penilaian/store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="penilaianModalLabel">Tambah Penilaian</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Kategori Penilaian -->

                        <table class="table table-bordered table-sm">
                            <input type="hidden" name="id_tahun_ajaran" id="idTahunAjaran">
                            <input type="hidden" name="id_santri" value="{{ $santri->id }}">
                            @foreach (App\Models\KategoriPenilaian::all() as $item)
                                <tr>
                                    <td colspan="3"><b>{{ $item->kategori }}</b></td>
                                </tr>
                                @php
                                    $nomor = 1;
                                @endphp
                                <tr class="bg-warning">
                                    <td>No.</td>
                                    <td>Point</td>
                                    <td>Nilai</td>
                                </tr>
                                @foreach (App\Models\PointPenilaian::where('id_kategori', $item->id)->get() as $itemPoint)
                                    <tr>
                                        <td>{{ $nomor++ }}</td>
                                        <td>
                                            {{ $itemPoint->point }}
                                        </td>
                                        <td>
                                            <input type="hidden" name="id_kategori[]" value="{{ $item->id }}">
                                            <input type="hidden" name="id_point[]" value="{{ $itemPoint->id }}">
                                            <select name="nilai[]" id="nilai" class="form-control" required>
                                                <option value="1">Belum Tampak</option>
                                                <option value="2">Berkembang</option>
                                                <option value="3">Mandiri</option>
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </table>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(function() {
            const idSantri = {{ $santri->id }};
            $('#datatable-customers').DataTable({
                processing: true,
                serverSide: true,
                responsive: false,
                ajax: {
                    url: '{{ url('tahun-datatable') }}',
                    data: function(d) {
                        d.id_santri = idSantri;
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },

                    {
                        data: 'tahun',
                        name: 'tahun'
                    },
                    {
                        data: 'semester',
                        name: 'semester'
                    },

                    {
                        data: 'action_report',
                        name: 'action_report'
                    }
                ]
            });

            $('.refresh').click(function() {
                $('#datatable-customers').DataTable().ajax.reload();
            });
            window.editCustomer = function(id) {
                $.ajax({
                    type: 'GET',
                    url: '/tahun/edit/' + id,
                    success: function(response) {
                        $('#idTahunAjaran').val(response.id);
                        $('#penilaianModal').modal('show');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            };
            window.komentarCustomer = function(id) {
                $.ajax({
                    type: 'GET',
                    url: '/tahun/edit/' + id,
                    success: function(response) {
                        $('#idTahunAjaranKomen').val(response.id);
                        $('#komentarModal').modal('show');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            };
            window.printCustomer = function(id_tahun_ajaran, id_santri) {
                // Membuat URL untuk membuka PDF di tab baru
                const url = '/penilaian/print?id_santri=' + id_santri + '&id_tahun_ajaran=' + id_tahun_ajaran;

                // Membuka URL di tab baru
                window.open(url, '_blank');
            };

        });
    </script>
@endpush
