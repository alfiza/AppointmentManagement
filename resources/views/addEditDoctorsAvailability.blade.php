@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><span id='action_title'>{{(isset($doctor_details))?"Edit":"Add"}}</span>{{ " Doctor's Availability" }} </div>
                <div class="card-body">
                    @if (session('status'))
                        <div id='alert_div' class="alert alert-{{ session('status') }}" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif
                    <?php
                    $available_days = array();
                    if(isset($doctor_details))
                    {
                        $available_days = array_keys($doctor_details);
                    }   
                    ?>
                    <form method="post" action="{{ (isset($doctor_details)) ? url('DoctorsAvailability').'/'.$doctor_id : url('DoctorsAvailability') }}" id="doctorsAvailability">
                        <input name="_token" value="{{ csrf_token() }}" type="hidden">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="daySearch">Doctors</label>
                                    <select class="form-control"  class="daysBox" data-sr-no='1' name="doctor_id" id="doctor_id" onchange="fetchDocDetail(this.value)">
                                        <option value="">select</option>
                                        @if(isset($doctors))
                                            @foreach($doctors as $key=>$val)
                                                <option value="{{$val->id}}" {{(isset($doctor_id) && $val->id==$doctor_id)?"selected":""}} >{{$val->name}}</option>    
                                            @endforeach
                                        @endif
                                    </select>
                            </div>
                            <table class="table" width="100%" >
                                <thead>
                                    <tr>
                                        <th scope="col" width="25%">Time Availability</th>
                                        <th scope="col" width="15%">Day</th>
                                        <th scope="col" width="30%">Start Time</th>
                                        <th scope="col" width="30%">End Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @php $week_array = array("1"=>"Monday", "2"=>"Tuesday", "3"=>"Wednesday", "4"=>"Thursday", "5"=>"Friday", "6"=>"Saturday", "7"=>"Sunday"); @endphp
                                    @foreach($week_array as $key=>$val)
                                        <tr>
                                            <td></td>
                                            <td>
                                                <input type="checkbox" class="daysBox" id="days{{$key}}" name="days" value="{{$key}}" {{(in_array($key,$available_days) && $doctor_details[$key]['open_status']==1)?"checked":""}}> {{$val}} 
                                            </td>
                                            <td>
                                                <input type="text" data-id="{{$key}}" id="startTime{{$key}}" name="startTime[{{$key}}]" class="form-control start_timepicker" value="{{(in_array($key,$available_days))?$doctor_details[$key]['start_time']:''}}" {{(in_array($key,$available_days))?'':'readonly'}}
                                                {{(in_array($key,$available_days) && $doctor_details[$key]['open_status']==1)?"":"readonly"}}  autocomplete="off">
                                            </td>
                                            <td>
                                                <input type="text" data-id="{{$key}}" id="endTime{{$key}}" name="endTime[{{$key}}]" class="form-control end_timepicker"  value="{{(in_array($key,$available_days))?$doctor_details[$key]['end_time']:''}}" {{(in_array($key,$available_days))?'':'readonly'}}
                                                {{(in_array($key,$available_days) && $doctor_details[$key]['open_status']==1)?"":"readonly"}}  autocomplete="off">
                                            </td>
                                        </tr>
                                    @endforeach
                                <tbody>
                            </table>

                            <div class="form-group">
                                <label for="search">&nbsp;</label>
                                <button type="button" id="submitbtn" title="Add appointment" class=" btn btn-primary">
                                    {{(isset($doctor_details))?"Update":"Save"}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    $('.start_timepicker').timepicker({
        showLeadingZero: true,
        onSelect: function( time, endTimePickerInst ) {
            id=$(this).data('id');
            checkReadonly(id);
            $('#endTime'+id).timepicker('option', {
                minTime: {
                    hour: endTimePickerInst.hours,
                    minute: endTimePickerInst.minutes
                }
            });
        },
        maxTime: {
            hour: 17, minute: 30
        }
    });
    $('.end_timepicker').timepicker({
        showLeadingZero: true,
        onSelect: function tpEndSelect( time, startTimePickerInst ) {
            id=$(this).data('id');
            checkReadonly(id);
            $('#startTime'+id).timepicker('option', {
                maxTime: {
                    hour: startTimePickerInst.hours,
                    minute: startTimePickerInst.minutes
                }
            });
        },
        minTime: {
            hour: 9, minute: 00
        }
    });

    $("#submitbtn").click(function(){
        var valid = true;
        
        if($("#doctor").val()=='')
        {
            $("#doctor").addClass("validate_td");
            valid = false;
        }
        if(valid==true)
        {
            $("#doctorsAvailability").submit();
        }
    });
    $(".daysBox").click(function(){
        var id = $(this).val();
        if($(this).is(':checked'))
        {
            $("#startTime"+id+", #endTime"+id).removeAttr("readonly");
        }
        else
        {
            $("#startTime"+id+", #endTime"+id).val("");
            $("#startTime"+id+", #endTime"+id).attr("readonly","readonly");            
        }
    });
    doc_id="{{isset($doctor_id)?$doctor_id:""}}";
    if(doc_id!='')
    {
        fetchDocDetail(doc_id);
    }
    setTimeout(function() { 
        $("#alert_div").fadeOut();
    }, 5000);
});

function fetchDocDetail(doctorId)
{
    $(".daysBox").prop('checked', false);
    $(".start_timepicker,.end_timepicker").val("").attr("readonly","readonly");
    $.ajax({
            type: "get",
            url: "{{URL('/getDoctorsDetails')}}/",
            data: {
                doctorId: doctorId
            },
            success: function (response) {
                if(response.length>0)                
                {
                    $.each(response, function( index, value ) {
                        id=value.days;
                        if(value.open_status==1)
                        {
                            $("#days"+id).prop('checked', true);
                            $("#startTime"+id).val(value.start_time).removeAttr("readonly");
                            $("#endTime"+id).val(value.end_time).removeAttr("readonly");
                        }
                        
                        
                        console.log(value.days);
                    });
                    $("#doctorsAvailability").attr("action","{{ url('DoctorsAvailability') }}/"+doctorId);
                    $("#action_title").html("Edit");
                    $("#submitbtn").html("Update");
                }
                else
                {
                    
                    
                    $("#doctorsAvailability").attr("action","{{ url('DoctorsAvailability') }}");
                    $("#action_title").html("Add");
                    $("#submitbtn").html("Save");
                }
                
            }               
    });
}
function checkReadonly(id)
{
    if($("#startTime"+id).attr('readonly')=='readonly')
    {
        $("#startTime"+id).val(""); 
    }
    if($("#endTime"+id).attr('readonly')=='readonly')
    {
        $("#endTime"+id).val(""); 
    }
}
</script>
@endsection
