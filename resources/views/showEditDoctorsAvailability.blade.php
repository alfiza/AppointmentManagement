<table class="table">
    <thead>
        <tr>
            <th scope="col" width="20%">Day</th>
            <th scope="col" width="60%">Start Time</th>
            <th scope="col" width="20%">End Time</th>
        </tr>
    </thead>
    <tbody>
        <?php //dd($doctors);
        ?>
        @php $week_array = array("1"=>"Monday", "2"=>"Tuesday", "3"=>"Wednesday", "4"=>"Thursday", "5"=>"Friday", "6"=>"Saturday", "7"=>"Sunday"); @endphp
        @if(isset($doctors) && count($doctors)>0)
            @foreach($doctors as $val)
            <tr>
                <td>{{$week_array[$val->days]}}</a></td>
                <td>{{$val->start_time}}</td>
                <td>{{$val->end_time}}</td>
            </tr>
            @endforeach
        @else
        <tr>
            <td colspan='3' class="text-center">No data found</td>
        </tr>
        @endif
    </tbody>
</table>