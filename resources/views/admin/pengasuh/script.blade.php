@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function() {
            $('#datatable-customers').DataTable({
                processing: true,
                serverSide: true,
                responsive: false,
                ajax: '{{ url('pengasuh-datatable') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },

                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'disabled',
                        name: 'disabled',
                        render: function(data, type, row, meta) {
                            return data ? '<span class="badge badge-danger">Disabled</span>' :
                                '<span class="badge badge-success">Aktif</span>';
                        }
                    }, {
                        data: 'nama',
                        name: 'nama'
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
                    url: '/pengasuh/edit/' + id,
                    success: function(response) {
                        $('#formCustomerId').val(response.id);
                        $('#formCustomerNama').val(response.nama);
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
                    url: '/pengasuh/store',
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
                    url: '/pengasuh/store',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);
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
                if (confirm('Apakah Anda yakin ingin menghapus pengasuh ini?')) {
                    $.ajax({
                        type: 'DELETE',
                        url: '/pengasuh/delete/' + id,
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

            window.accountCustomer = function(pengasuhId) {
                if (!confirm('Buat akun untuk pengasuh ini?')) return;

                $.ajax({
                    url: '/admin/create-user-from-pengasuh',
                    method: 'POST',
                    data: {
                        id: pengasuhId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert(response.message);
                    },
                    error: function(xhr) {
                        if (xhr.status === 400 && xhr.responseJSON.user) {
                            const user = xhr.responseJSON.user;
                            const html = `
                    <div style="text-align:left">
                        <p><strong>Email:</strong> ${user.email}</p>
                        <p><strong>Username:</strong> ${user.name}</p>
                        <button class="btn btn-sm btn-danger" onclick="resetPassword(${user.id})">Reset Password</button>
                    </div>
                `;
                            Swal.fire({
                                icon: 'info',
                                title: 'Akun Sudah Ada',
                                html: html
                            });
                        } else {
                            alert(xhr.responseJSON.message);
                        }
                    }
                });
            };

            window.resetPassword = function(userId) {
                $.ajax({
                    url: '/admin/reset-user-password',
                    method: 'POST',
                    data: {
                        id: userId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: xhr.responseJSON.message
                        });
                    }
                });
            };
        });
    </script>
@endpush
