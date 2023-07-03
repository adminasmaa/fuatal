@extends('layouts.admin')

@section('content')

<style>
    .alert.alert-success a {
        color: black;
        font-weight: bold;
    }
</style>
<section class="section">
    <div class="container-fluid">
        <div class="card no-box-shadow-mobile">
            <header class="card-header">
                <h1 class="py-5"> {{ 'Winners Settings' }}
                    <br>
                    <p<span style="color: red; font-size: 14px;">*</span>Please select the number of winners out of the participants with respect to time:</p>

                </h1>
            </header>
            <div class="card-content" style="padding-bottom: 2rem;">
                <div class="container-fluid">
                    <div id="winner-section" class="row mt-5">
                    </div>
                </div>
            </div>
        </div>
</section>
<!-- Modal -->
<div class="modal fade" id="assignTimes" tabindex="-1" aria-labelledby="assignTimesLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignTimesLabel">Winner Setting</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="assign-times-section"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">
    function getWinnerSettings() {
        $('#winner-section').html('<p style="color: red;" class="text-bold text-center">Loading...</p>');
        $.ajax({
            type: "GET",
            url: "{{ url('admin/settings/winners/ajax') }}",
            data: {},
            success: function(data) {
                $('#winner-section').html(data);
            }
        });
    }

    function saveWinnerSettings(start_date = '', end_date = '') {
        $('#winner-section').html('<p style="color: red;" class="text-bold text-center">Loading...</p>');
        $.ajax({
            type: "GET",
            url: "{{ url('admin/settings/winners/save') }}",
            data: {
                start_date: start_date,
                end_date: end_date,
            },
            success: function(data) {
                $('#winner-section').html(data);
            }
        });
    }
    $(document).ready(function() {
        getWinnerSettings();
    });
    $(document).on('click', '#add-setting', function() {
        saveWinnerSettings($('#start_date').val(), $('#end_date').val());
    });
    $(document).on('click', '.delete-setting', function() {
        $('#winner-section').html('<p style="color: red;" class="text-bold text-center">Loading...</p>');
        $.ajax({
            type: "GET",
            url: "{{ url('admin/settings/winners/delete') }}",
            data: {
                id: $(this).attr('data-id')
            },
            success: function(data) {
                $('#winner-section').html(data);
            }
        });
    });
    $(document).on('click', '.assign-times', function() {
        $('#assign-times-section').html('<p style="color: red;" class="text-bold text-center">Loading...</p>');
        $.ajax({
            type: "GET",
            url: "{{ url('admin/setting/assign-times') }}",
            data: {
                id: $(this).attr('data-id')
            },
            success: function(data) {
                $('#assign-times-section').html(data);
            }
        });
    });
    $(document).on('click', '.add-time', function() {
        console.log('here');
        var id = $(this).attr('data-id');
        var no_winners = $('#no_winners_' + id).val();
        var winner_out_of = $('#winner_out_of_' + id).val();
        var start_time = $('#start_time_' + id).val();
        var end_time = $('#end_time_' + id).val();
        console.log($('#no_winners_' + id).val());
        console.log($(this).attr('data-id'));
        $('#time-item-section').html('<p style="color: red;" class="text-bold text-center">Loading...</p>');
        $.ajax({
            type: "GET",
            url: "{{ url('admin/setting/add-time') }}",
            data: {
                id: id,
                no_winners: no_winners,
                winner_out_of: winner_out_of,
                start_time: start_time,
                end_time: end_time,
            },
            success: function(data) {
                $('#time-item-section').html(data);
            }
        });
    });
    $(document).on('click', '.delete-time', function() {
        var id = $(this).attr('data-id');
        console.log(id);
        $('#time-item-section').html('<p style="color: red;" class="text-bold text-center">Loading...</p>');
        $.ajax({
            type: "GET",
            url: "{{ url('admin/settings/time/delete') }}",
            data: {
                id: id
            },
            success: function(data) {
                $('#time-item-section').html(data);
            }
        });
    });
</script>
@endsection