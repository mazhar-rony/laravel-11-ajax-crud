@extends('layouts.app')

@section('title', 'Cities')

@push('css')
    
@endpush

@section('content')

{{-- Add Modal --}}
<div class="modal fade" id="AddCityModal" tabindex="-1" aria-labelledby="AddCityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AddCityLabel">Add City</h5>
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
                    <label for="">Select State</label>
                    <select id="stateSelectAdd" class="form-select form-select-sm" aria-label=".form-select-sm example">
                        
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="">City Name</label>
                    <input type="text" required class="name form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary add_city">Save</button>
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
                <h5 class="modal-title" id="editModalLabel">Edit City</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <ul class="rounded-2 fw-bold" id="update_msgList"></ul>

                <input type="hidden" id="city_id" />

                <div class="form-group mb-3">
                    <label for="">Select Country</label>
                    <select id="countrySelectEdit" class="form-select form-select-sm" aria-label=".form-select-sm example">
                        
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="">Select State</label>
                    <select id="stateSelectEdit" class="form-select form-select-sm" aria-label=".form-select-sm example">
                        
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="">State Name</label>
                    <input type="text" id="name" required class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary update_city">Update</button>
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
                <h5 class="modal-title" id="deleteModalLabel">Delete City</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>Are you sure ?</h4>
                <h6 class="mt-2">You won't be able to revert this!</h6>
                <input type="hidden" id="city_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger delete_city">Yes, Delete it</button>
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
                        <h5 class="dashboard__card__header__title">Cities</h5>
                    </div>
                    <div class="dashboard__inner__header__right">
                        <div class="dashboard__inner__item__right recent_activities">
                            <div class="btn-wrapper">
                                <a href="javascript:void(0)" class="cmn_btn btn_small radius-5" id="Addbtn" data-bs-toggle="modal" data-bs-target="#AddCityModal">Add New City</a>
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
                                    <th>City</th>
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

            fetchCities();

            function fetchCities() 
            {
                $.ajax({
                    type: "GET",
                    url: "/fetch-cities",
                    dataType: "json",
                    success: function (response) {
                        $('tbody').html("");

                        if (Array.isArray(response.cities) && response.cities.length === 0) {
                            $('tbody').append(
                                `<tr>
                                    <td colspan="5">No Record Found.</td>
                                </tr>`
                            );
                        } 

                        $.each(response.cities, function (key, item) {
                            
                            $('tbody').append(
                                `<tr>
                                    <td>${key+1}</td>
                                    <td>${item.name}</td>
                                    <td>${item.state.name}</td>
                                    <td>${item.state.country.name}</td>
                                    <td>
                                        <div class="action__icon d-flex">
                                            <div class="action__icon__item">
                                                <div class="btn-group">
                                                    <a href="javascript:void(0)" class="icon" data-bs-toggle="dropdown"> <i class="material-symbols-outlined">more_vert</i></a>
                                                    <ul class="dropdown-menu">
                                                        <li class="single-item"><button value="${item.id}" class="dropdown-item editBtn" href="javascript:void(0)"><i class="material-symbols-outlined">edit</i> Edit City</button></li>
                                                        <li class="single-item"><button value="${item.id}" class="dropdown-item delete deleteBtn" href="javascript:void(0)"><i class="material-symbols-outlined">delete</i> Delete City</button></li>
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

            // stateSelectAdd Depend on countrySelectAdd
            $(document).on('change', '#countrySelectAdd', function () {
                
                $('#stateSelectAdd').empty();

                var countryId = parseInt($('#countrySelectAdd').find(":selected").val());

                $.ajax({
                    type: "GET",
                    url: "/fetch-states/" + countryId,
                    success: function (response) {   
                            $('#stateSelectAdd').append(
                                `<option selected disabled>Please select one</option>`
                            );             
                            $.each(response.states, function(key, state) {
                                $('#stateSelectAdd').append(
                                    `<option value="${state.id}">${state.name}</option>`
                                );
                            });
                        }
                    });
            });

            

            // Store City
            $(document).on('click', '.add_city', function (e) {
                e.preventDefault();

                $(this).text('Saving...');

                var data = {
                    'name': $('.name').val(),
                    'state_id': parseInt($('#stateSelectAdd').find(":selected").val()),
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "/cities",
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
                            $('#AddCityModal').find('input').val('');
                            $('.add_city').text('Save');
                            $('#AddCityModal').modal('hide');
                            $('#countrySelectAdd').empty();
                            $('#stateSelectAdd').empty();
                            fetchCities();
                        }
                    }
                });
            });

            // Edit City
            $(document).on('click', '.editBtn', function (e) {
                e.preventDefault();

                var city_id = $(this).val();
                
                $('#editModal').modal('show');
                
                $.ajax({
                    type: "GET",
                    url: "/cities/" + city_id + "/edit",
                    success: function (response) {
                        if (response.status == 404) {
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('#editModal').modal('hide');
                        } else {
                            $('#name').val(response.city.name);
                            $('#city_id').val(city_id);
                            $.each(response.countries, function(key, country) {
                                $('#countrySelectEdit').append(
                                    `<option value="${country.id}" ${response.city.state.country_id == country.id ? 'selected' : ''}>${country.name}</option>`
                                );
                            });
                            $.each(response.states, function(key, state) {
                                $('#stateSelectEdit').append(
                                    `<option value="${state.id}" ${response.city.state_id == state.id ? 'selected' : ''}>${state.name}</option>`
                                );
                            });
                        }
                    }
                });
                $('.btn-close').find('input').val('');
                $('#countrySelectEdit').empty();
                $('#stateSelectEdit').empty();
            });

            // stateSelectEdit Depend on countrySelectEdit
            $(document).on('change', '#countrySelectEdit', function () {
                
                $('#stateSelectEdit').empty();

                var countryId = parseInt($('#countrySelectEdit').find(":selected").val());

                $.ajax({
                    type: "GET",
                    url: "/fetch-states/" + countryId,
                    success: function (response) {   
                            $('#stateSelectEdit').append(
                                `<option selected disabled>Please select one</option>`
                            );             
                            $.each(response.states, function(key, state) {
                                $('#stateSelectEdit').append(
                                    `<option value="${state.id}">${state.name}</option>`
                                );
                            });
                        }
                    });
            });

            // Update City
            $(document).on('click', '.update_city', function (e) {
                e.preventDefault();

                $(this).text('Updating...');
                var id = $('#city_id').val();

                var data = {
                    'name': $('#name').val(),
                    'state_id': parseInt($('#stateSelectEdit').find(":selected").val()),
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "PUT",
                    url: "/cities/" + id,
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
                            $('.update_city').text('Update');
                            $('#editModal').modal('hide');
                            $('#countrySelectAdd').empty();
                            $('#stateSelectAdd').empty();
                            fetchCities();
                        }
                    }
                });

            });

            // Delete State
            $(document).on('click', '.deleteBtn', function () {
                
                var city_id = $(this).val();

                $('#deleteModal').modal('show');
                $('#city_id').val(city_id);
            });

            $(document).on('click', '.delete_city', function (e) {
                e.preventDefault();

                $(this).text('Deleting...');
                var id = $('#city_id').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "DELETE",
                    url: "/cities/" + id,
                    dataType: "json",
                    success: function (response) {
                        if (response.status == 404) {
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('.delete_city').text('Yes, Delete it');
                        } else {
                            $('#success_message').html("");
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('.delete_city').text('Yes, Delete it');
                            $('#deleteModal').modal('hide');
                            $('#countrySelectAdd').empty();
                            $('#stateSelectAdd').empty();
                            fetchCities();
                        }
                    }
                });
            });


        });
    </script>
@endpush

