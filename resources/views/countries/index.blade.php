@extends('layouts.app')

@section('title', 'Countries')

@push('css')
    
@endpush

@section('content')

{{-- Add Modal --}}
<div class="modal fade" id="AddCountryModal" tabindex="-1" aria-labelledby="AddCountryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AddCountryLabel">Add Country</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div>
                    <ul class="rounded-2 fw-bold" id="save_msgList"></ul>
                </div>

                <div class="form-group mb-3">
                    <label for="">Country Name</label>
                    <input type="text" required class="name form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary add_country">Save</button>
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
                <h5 class="modal-title" id="editModalLabel">Edit Country</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <ul class="rounded-2 fw-bold" id="update_msgList"></ul>

                <input type="hidden" id="country_id" />

                <div class="form-group mb-3">
                    <label for="">Country Name</label>
                    <input type="text" id="name" required class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary update_country">Update</button>
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
                <h5 class="modal-title" id="deleteModalLabel">Delete Country</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>Are you sure ?</h4>
                <h6 class="mt-2">You won't be able to revert this!</h6>
                <input type="hidden" id="country_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger delete_country">Yes, Delete it</button>
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
                        <h5 class="dashboard__card__header__title">Countries</h5>
                    </div>
                    <div class="dashboard__inner__header__right">
                        <div class="dashboard__inner__item__right recent_activities">
                            <div class="btn-wrapper">
                                <a href="javascript:void(0)" class="cmn_btn btn_small radius-5" id="activity_btn" data-bs-toggle="modal" data-bs-target="#AddCountryModal">Add New Country</a>
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

            fetchCountries();

            function fetchCountries() 
            {
                $.ajax({
                    type: "GET",
                    url: "/fetch-countries",
                    dataType: "json",
                    success: function (response) {
                   
                        $('tbody').html("");

                        if (Array.isArray(response.countries) && response.countries.length === 0) {
                            $('tbody').append(
                                `<tr>
                                    <td colspan="3">No Record Found.</td>
                                </tr>`
                            );
                        } 

                        $.each(response.countries, function (key, item) {
                            
                            $('tbody').append(
                                `<tr>
                                    <td>${key+1}</td>
                                    <td>${item.name}</td>
                                    <td>
                                        <div class="action__icon d-flex">
                                            <div class="action__icon__item">
                                                <div class="btn-group">
                                                    <a href="javascript:void(0)" class="icon" data-bs-toggle="dropdown"> <i class="material-symbols-outlined">more_vert</i></a>
                                                    <ul class="dropdown-menu">
                                                        <li class="single-item"><button value="${item.id}" class="dropdown-item editBtn" href="javascript:void(0)"><i class="material-symbols-outlined">edit</i> Edit Country</button></li>
                                                        <li class="single-item"><button value="${item.id}" class="dropdown-item delete deleteBtn" href="javascript:void(0)"><i class="material-symbols-outlined">delete</i> Delete Country</button></li>
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
            }

            // Store Country
            $(document).on('click', '.add_country', function (e) {
                e.preventDefault();

                $(this).text('Saving...');

                var data = {
                    'name': $('.name').val(),
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "/countries",
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        if (response.status == 400) {
                            $('#save_msgList').html("");
                            $('#save_msgList').addClass('alert alert-danger');
                            $.each(response.errors, function (key, err_value) {
                                $('#save_msgList').append(`<li>${err_value}</li>`);
                            });
                            $('.add_country').text('Save');
                        } else {
                            $('#save_msgList').html("");
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('#AddCountryModal').find('input').val('');
                            $('.add_country').text('Save');
                            $('#AddCountryModal').modal('hide');
                            fetchCountries();
                        }
                    }
                });
            });

            // Edit Country
            $(document).on('click', '.editBtn', function (e) {
                e.preventDefault();

                var country_id = $(this).val();
                
                $('#editModal').modal('show');
                
                $.ajax({
                    type: "GET",
                    url: "/countries/" + country_id + "/edit",
                    success: function (response) {
                        if (response.status == 404) {
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('#editModal').modal('hide');
                        } else {
                            $('#name').val(response.country.name);
                            $('#country_id').val(country_id);
                        }
                    }
                });
                $('.btn-close').find('input').val('');
            });

            // Update Country
            $(document).on('click', '.update_country', function (e) {
                e.preventDefault();

                $(this).text('Updating...');
                var id = $('#country_id').val();

                var data = {
                    'name': $('#name').val(),
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "PUT",
                    url: "/countries/" + id,
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        if (response.status == 400) {
                            $('#update_msgList').html("");
                            $('#update_msgList').addClass('alert alert-danger');
                            $.each(response.errors, function (key, err_value) {
                                $('#update_msgList').append(`<li>${err_value}</li>`);
                            });
                            $('.update_country').text('Update');
                        } else {
                            $('#update_msgList').html("");

                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('#editModal').find('input').val('');
                            $('.update_country').text('Update');
                            $('#editModal').modal('hide');
                            fetchCountries();
                        }
                    }
                });

            });

            // Delete Country
            $(document).on('click', '.deleteBtn', function () {
                
                var country_id = $(this).val();

                $('#deleteModal').modal('show');
                $('#country_id').val(country_id);
            });

            $(document).on('click', '.delete_country', function (e) {
                e.preventDefault();

                $(this).text('Deleting...');
                var id = $('#country_id').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "DELETE",
                    url: "/countries/" + id,
                    dataType: "json",
                    success: function (response) {
                        if (response.status == 404) {
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('.delete_country').text('Yes, Delete it');
                        } else {
                            $('#success_message').html("");
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('.delete_country').text('Yes, Delete it');
                            $('#deleteModal').modal('hide');
                            fetchCountries();
                        }
                    }
                });
            });


        });
    </script>
@endpush

