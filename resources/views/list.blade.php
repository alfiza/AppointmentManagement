@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ 'Doctors' }} 
                    <a href="{{ url('DoctorsAvailability') }}"><button type="button" id="editAppointment" title="Add appointment" class="btn btn-primary pull-right">
                        Add Appointment Time
                    </button></a>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" id='alert_div' role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="daySearch">Days</label>
                            <select class="form-control"  id="daySearch" >
                                <option value="">select</option>
                                <option value="1">Monday</option>
                                <option value="2">Tuesday</option>
                                <option value="3">Wednesday</option>
                                <option value="4">Thursday</option>
                                <option value="5">Friday</option>
                                <option value="6">Saturday</option>
                                <option value="7">Sunday</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="startTimeSearch">Start Time</label>
                            <input type="text" id="startTimeSearch" class="form-control timepicker" >
                            
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="endTimeSearch">End Time</label>
                            <input type="text" id="endTimeSearch" class="form-control timepicker">
                        </div>
                    </div>                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="doctorSearch">Doctor</label>
                            <input type="text" id="doctorSearch" class="form-control timepicker">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="search">&nbsp;</label>
                            <button type="button" id="search" title="Search" class="form-control btn btn-primary">
                                Search
                            </button>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="search">&nbsp;</label>
                            <button type="button" id="reset" title="Search" class="form-control btn btn-primary" onclick="window.location.reload(true)">
                                reset
                            </button>
                        </div>
                    </div>
                    <br/><br/><br/><br/><hr><br/>
                    <table class="table" id="doctorListTable">
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    $('#startTimeSearch').timepicker({
        showLeadingZero: true,
        onSelect: function( time, endTimePickerInst ) {
            $('#endTimeSearch').timepicker('option', {
                minTime: {
                    hour: endTimePickerInst.hours,
                    minute: endTimePickerInst.minutes
                }
            });
        },
        maxTime: {
            hour: 16, minute: 30
        }
    });
    $('#endTimeSearch').timepicker({
        showLeadingZero: true,
        onSelect: function( time, startTimePickerInst ) {
            $('#startTimeSearch').timepicker('option', {
                maxTime: {
                    hour: startTimePickerInst.hours,
                    minute: startTimePickerInst.minutes
                }
            });
        },
        minTime: {
            hour: 9, minute: 15
        }
    });

    $(document).on('click','.delete_appointment',function(){
        id = $(this).data('id');
        $("#module_title").html($("#docotrName"+id+" a").html());
        $("#delete-btn-conf").attr('onclick',"deleteAppointment("+id+")");
        $('#delete_confirm_div').show();
    });
    $(document).on('click','#search',function(){
        if($("#startTimeSearch").val()!='' && $("#endTimeSearch").val()=='')
        {
            $("#endTimeSearch").addClass("validate_td");
            return false;
        }
        if($("#startTimeSearch").val()=='' && $("#endTimeSearch").val()!='')
        {
            $("#startTimeSearch").addClass("validate_td");
            return false;
        }
        else
        {
            $(".validate_td").removeClass("validate_td");
        }
        $.ajax({
               type: "GET",
               url: "{{URL('/getDoctorsList')}}/",
               data: {
                    daySearch: $("#daySearch").val(),
                    startTimeSearch: $("#startTimeSearch").val(),
                    endTimeSearch: $("#endTimeSearch").val(),
                    doctorSearch: $("#doctorSearch").val(),
                    search: true
                },
               success: function (data) {
                    $("#doctorListTable").html(data);
                }               
        });
    });
    $("#search").trigger("click");
    
    setTimeout(function() { 
        $("#alert_div").fadeOut();
    }, 5000);
});
function deleteAppointment(doctor_id)
{ 
    $("#delete_confirm_div").hide();
    $.ajax({
               type: "GET",
               url: "{{URL('/DeleteDoctorsAvailability')}}/"+doctor_id,
               success: function (data) {
               if(data['status']=='success')
               {    
                    $("#info_div_title").html("Info");
                    $("#info_msg").html(data['message']);
                    $("#info_div").show();
                    $("#search").trigger("click");
               }
           }               
        }); 
}
function showDetails(doctor_id,doctor)
{ 
    $("#delete_confirm_div").hide();
    $.ajax({
               type: "GET",
               url: "{{URL('/ShowDoctorsAvailability')}}/"+doctor_id,
               success: function (data) {
               
                    $("#info_msg").html(data);
                    $("#info_div_title").html(doctor);
                    $("#info_div").show();
               
           }               
        }); 
}


</script>
@endsection
