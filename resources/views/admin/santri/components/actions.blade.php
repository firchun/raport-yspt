<div class="btn-group">
    <button class="btn btn-sm btn-primary" onclick="editCustomer({{ $Santri->id }})">Edit</button>
    @if (Auth::user()->role == 'Admin')
        <button class="btn btn-sm btn-danger " onclick="deleteCustomers({{ $Santri->id }})">Delete</button>
    @endif
</div>
