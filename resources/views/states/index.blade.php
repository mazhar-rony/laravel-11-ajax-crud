@extends('layouts.app')

@section('title', 'States')

@push('css')
    
@endpush

@section('content')

{{-- Add Modal --}}
<div class="modal fade" id="AddStateModal" tabindex="-1" aria-labelledby="AddStateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AddStateLabel">Add State</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div>
                    <ul class="rounded-2 fw-bold" id="save_msgList"></ul>
                </div>

                <div class="form-group mb-3">
                    <label for="">Select Country</label>
                    <select id="countrySelectAdd" class="form-select form-select-sm" aria-label=".form-select-sm example">
                        
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="">State Name</label>
                    <input type="text" required class="name form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary add_state">Save</button>
            </div>

        </div>
    </div>
</div>
{{-- End Add Modal --}}

{{-- Edit Modal --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit State</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <ul class="rounded-2 fw-bold" id="update_msgList"></ul>

                <input type="hidden" id="state_id" />

                <div class="form-group mb-3">
                    <label for="">Select Country</label>
                    <select id="countrySelectEdit" class="form-select form-select-sm" aria-label=".form-select-sm example">
                        
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="">State Name</label>
                    <input type="text" id="name" required class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary update_state">Update</button>
            </div>

        </div>
    </div>
</div>
{{-- End Edit Modal --}}

{{-- Delete Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete State</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>Are you sure ?</h4>
                <h6 class="mt-2">You won't be able to revert this!</h6>
                <input type="hidden" id="state_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger delete_state">Yes, Delete it</button>
            </div>
        </div>
    </div>
</div>
{{-- End Delete Modal --}}

<div class="dashboard__inner__item__left bodyItemPadding">
    <div class="row g-4">
        <div class="col-lg-12">
            <div class="dashboard__card bg__white padding-20 radius-10">
                <div class="dashboard__inner__header__flex">
                    <div class="dashboard__inner__header__left">
                        <h5 class="dashboard__card__header__title">States</h5>
                    </div>
                    <div class="dashboard__inner__header__right">
                        <div class="dashboard__inner__item__right recent_activities">
                            <div class="btn-wrapper">
                                <a href="javascript:void(0)" class="cmn_btn btn_small radius-5" id="Addbtn" data-bs-toggle="modal" data-bs-target="#AddStateModal">Add New State</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dashboard__card__inner border_top_1">
                    <div class="dashboard__inventory__table custom_table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>State</th>
                                    <th>Country</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('js')
    <script>
        $(document).ready(function () {

            fetchStates();

            function fetchStates() 
            {
                $.ajax({
                    type: "GET",
                    url: "/fetch-states",
                    dataType: "json",
                    success: function (response) {
                        $('tbody').html("");

                        if (Array.isArray(response.states) && response.states.length === 0) {
                            $('tbody').append(
                                `<tr>
                                    <td colspan="4">No Record Found.</td>
                                </tr>`
                            );
                        } 

                        $.each(response.states, function (key, item) {
                            
                            $('tbody').append(
                                `<tr>
                                    <td>${key+1}</td>
                                    <td>${item.name}</td>
                                    <td>${item.country.name}</td>
                                    <td>
                                        <div class="action__icon d-flex">
                                            <div class="action__icon__item">
                                                <div class="btn-group">
                                                    <a href="javascript:void(0)" class="icon" data-bs-toggle="dropdown"> <i class="material-symbols-outlined">more_vert</i></a>
                                                    <ul class="dropdown-menu">
                                                        <li class="single-item"><button value="${item.id}" class="dropdown-item editBtn" href="javascript:void(0)"><i class="material-symbols-outlined">edit</i> Edit State</button></li>
                                                        <li class="single-item"><button value="${item.id}" class="dropdown-item delete deleteBtn" href="javascript:void(0)"><i class="material-symbols-outlined">delete</i> Delete State</button></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>`
                            );
                        });
                    }
                });

                $.ajax({
                    type: "GET",
                    url: "/fetch-countries",
                    success: function (response) {   
                            $('#countrySelectAdd').append(
                                `<option selected disabled>Please select one</option>`
                            );             
                            $.each(response.countries, function(key, country) {
                                $('#countrySelectAdd').append(
                                    `<option value="${country.id}">${country.name}</option>`
                                );
                            });
                        }
                });
            }

            

            // Store State
            $(document).on('click', '.add_state', function (e) {
                e.preventDefault();

                $(this).text('Saving...');

                var data = {
                    'name': $('.name').val(),
                    'country_id': parseInt($('#countrySelectAdd').find(":selected").val()),
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "/states",
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        if (response.status == 400) {
                            $('#save_msgList').html("");
                            $('#save_msgList').addClass('alert alert-danger');
                            $.each(response.errors, function (key, err_value) {
                                $('#save_msgList').append(`<li>${err_value}</li>`);
                            });
                            $('.add_state').text('Save');
                        } else {
                            $('#save_msgList').html("");
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('#AddStateModal').find('input').val('');
                            $('.add_state').text('Save');
                            $('#AddStateModal').modal('hide');
                            $('#countrySelectAdd').empty();
                            fetchStates();
                        }
                    }
                });
            });

            // Edit State
            $(document).on('click', '.editBtn', function (e) {
                e.preventDefault();

                var state_id = $(this).val();
                
                $('#editModal').modal('show');
                
                $.ajax({
                    type: "GET",
                    url: "/states/" + state_id + "/edit",
                    success: function (response) {
                        if (response.status == 404) {
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('#editModal').modal('hide');
                        } else {
                            $('#name').val(response.state.name);
                            $('#state_id').val(state_id);
                            $.each(response.countries, function(key, country) {
                                $('#countrySelectEdit').append(
                                    `<option value="${country.id}" ${response.state.country_id == country.id ? 'selected' : ''}>${country.name}</option>`
                                );
                            });
                        }
                    }
                });
                $('.btn-close').find('input').val('');
            });

            // Update State
            $(document).on('click', '.update_state', function (e) {
                e.preventDefault();

                $(this).text('Updating...');
                var id = $('#state_id').val();

                var data = {
                    'name': $('#name').val(),
                    'country_id': parseInt($('#countrySelectEdit').find(":selected").val()),
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "PUT",
                    url: "/states/" + id,
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        if (response.status == 400) {
                            $('#update_msgList').html("");
                            $('#update_msgList').addClass('alert alert-danger');
                            $.each(response.errors, function (key, err_value) {
                                $('#update_msgList').append(`<li>${err_value}</li>`);
                            });
                            $('.update_state').text('Update');
                        } else {
                            $('#update_msgList').html("");

                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('#editModal').find('input').val('');
                            $('.update_state').text('Update');
                            $('#editModal').modal('hide');
                            $('#countrySelectAdd').empty();
                            fetchStates();
                        }
                    }
                });

            });

            // Delete State
            $(document).on('click', '.deleteBtn', function () {
                
                var state_id = $(this).val();

                $('#deleteModal').modal('show');
                $('#state_id').val(state_id);
            });

            $(document).on('click', '.delete_state', function (e) {
                e.preventDefault();

                $(this).text('Deleting...');
                var id = $('#state_id').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "DELETE",
                    url: "/states/" + id,
                    dataType: "json",
                    success: function (response) {
                        if (response.status == 404) {
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('.delete_state').text('Yes, Delete it');
                        } else {
                            $('#success_message').html("");
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('.delete_state').text('Yes, Delete it');
                            $('#deleteModal').modal('hide');
                            $('#countrySelectAdd').empty();
                            fetchStates();
                        }
                    }
                });
            });


        });
    </script>
@endpush

