@push('js')
    <script>
        $(function() {
            $('#datatable-customers').DataTable({
                processing: true,
                serverSide: true,
                responsive: false,
                ajax: '{{ url('tahun-datatable') }}',
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
                        data: 'action_all_report',
                        name: 'action_all_report'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });
            $('.create-new').click(function() {
                $('#create').modal('show');
            });
            $('.refresh').click(function() {
                $('#datatable-customers').DataTable().ajax.reload();
            });
            window.editCustomer = function(id) {
                $.ajax({
                    type: 'GET',
                    url: '/tahun/edit/' + id,
                    success: function(response) {
                        $('#formCustomerId').val(response.id);
                        $('#formCustomerNama').val(response.nama);
                        $('#formCustomerAlamat').val(response.alamat);
                        $('#customersModal').modal('show');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            };
            $('#saveCustomerBtn').click(function() {
                var formData = $('#userForm').serialize();

                $.ajax({
                    type: 'POST',
                    url: '/tahun/store',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);
                        // Refresh DataTable setelah menyimpan perubahan
                        $('#datatable-customers').DataTable().ajax.reload();
                        $('#customersModal').modal('hide');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });
            $('#createCustomerBtn').click(function() {
                var formData = $('#createUserForm').serialize();

                $.ajax({
                    type: 'POST',
                    url: '/tahun/store',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);
                        $('#customersModalLabel').text('Edit Customer');
                        $('#formCustomerName').val('');
                        $('#datatable-customers').DataTable().ajax.reload();
                        $('#create').modal('hide');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });
            window.deleteCustomers = function(id) {
                if (confirm('Apakah Anda yakin ingin menghapus tahun ajaran ini?')) {
                    $.ajax({
                        type: 'DELETE',
                        url: '/tahun/delete/' + id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            // alert(response.message);
                            $('#datatable-customers').DataTable().ajax.reload();
                        },
                        error: function(xhr) {
                            alert('Terjadi kesalahan: ' + xhr.responseText);
                        }
                    });
                }
            };
            window.printCustomer = function(id_tahun_ajaran, id_santri) {
                // Membuat URL untuk membuka PDF di tab baru
                const url = '/penilaian/print?id_tahun_ajaran=' + id_tahun_ajaran;

                // Membuka URL di tab baru
                window.open(url, '_blank');
            };
        });
    </script>
@endpush
