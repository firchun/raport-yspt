@push('js')
    <!-- JS DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.1.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script>
        $(function() {
            $('#datatable-customers').DataTable({
                processing: true,
                serverSide: true,
                responsive: false,
                ajax: '{{ url('santri-datatable') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },

                    {
                        data: 'qr_code',
                        name: 'qr_code'
                    },

                    {
                        data: 'nama',
                        name: 'nama',
                        render: function(data, type, row, meta) {
                            return '<strong>' + row.nama + '</strong><br><small>' + row.alamat +
                                '</small>';
                        }
                    },
                    {
                        data: 'kamar',
                        name: 'kamar'
                    },
                    {
                        data: 'kelas',
                        name: 'kelas'
                    },
                    {
                        data: 'status_sekolah',
                        name: 'status_sekolah',
                        render: function(data, type, row, meta) {
                            return '<span class="badge badge-primary">' + row.status_sekolah +
                                '</span>';

                        },
                    },

                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'pdf',
                        text: '<i class="bi bi-file-pdf"></i> PDF',
                        className: 'btn-danger mx-3',
                        orientation: 'landscape',
                        title: '{{ $title . date('d-m-y H:i:s') }}',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        },
                        customize: function(doc) {
                            doc.defaultStyle.fontSize = 8;
                            doc.styles.tableHeader.fontSize = 8;
                            doc.styles.tableHeader.fillColor = '#2a6908';
                        },
                        header: true,

                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="bi bi-file-excel"></i> Excel',
                        title: '{{ $title . date('d-m-y H:i:s') }}',
                        className: 'btn-success',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
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
                    url: '/santri/edit/' + id,
                    success: function(response) {
                        $('#formCustomerId').val(response.id);
                        $('#formCustomerNama').val(response.nama);
                        $('#formCustomerAlamat').val(response.alamat);
                        $('#formCustomerKamar').val(response.kamar);
                        $('#formCustomerKelas').val(response.kelas);
                        // Update tombol Data Lengkap
                        $('#btnDataLengkap').attr('href', '/santri/edit-view/' + response.id);
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
                    url: '/santri/store',
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
                    url: '/santri/store',
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
                if (confirm('Apakah Anda yakin ingin menghapus santri ini?')) {
                    $.ajax({
                        type: 'DELETE',
                        url: '/santri/delete/' + id,
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
        });
    </script>
@endpush
