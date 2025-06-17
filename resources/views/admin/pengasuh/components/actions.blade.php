<div class="btn-group">
    <button class="btn btn-sm btn-primary" onclick="editCustomer({{ $Pengasuh->id }})">Edit</button>
    <button class="btn btn-sm btn-warning" onclick="accountCustomer({{ $Pengasuh->id }})">Account</button>
    <button class="btn btn-sm btn-secondary" onclick="disabledCustomer({{ $Pengasuh->id }})">Disabled</button>
    <button class="btn btn-sm btn-danger " onclick="deleteCustomers({{ $Pengasuh->id }})">Delete</button>
</div>
