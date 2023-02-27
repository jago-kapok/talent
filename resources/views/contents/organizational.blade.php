@extends('layouts.app')

@section('content')

<style>
.department {
    white-space: pre-wrap;
    width: 325px;
    padding: 5px;
    color: #424242;
    font-weight: normal;
}
.units{
    white-space:pre-wrap;
    width:120px;
    height:200px;
    color:#212121;
    font-weight:normal;
    text-align:center;
    font-size:10px;
}
.units li{
    list-style-type:none;
    padding:5px;
    margin:4px 0;
    border-radius:5px;
}
.units ul{  padding:0;}
.units hr{
    border:none;
    background:white;
    width:40px;
    height:1px;
}

.cascading-right {
    margin-right: -50px;
}

@media (max-width: 991.98px) {
    .cascading-right {
        margin-right: 0;
    }
}

.bg-place {
    position: relative;
    z-index: 1;
}

.bg-body {
    background-color: #E5E5E5;
    left: 2.5em;
    width: 215px;
    text-align: left;
}

.tx-body {
    margin-left: 25px;
}

.bg-title {
    color: white;
    width: 190px;
    margin-left: 2em;
    margin-top: 1em;
    text-align: left;
    padding: .2em 1em .2em 2em;
    border-top-right-radius: 25px;
}
</style>

<div class="container-fluid" data-aos="fade-in">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background-color: #b0ecff">
            <li class="breadcrumb-item"><i class="bi-house-door-fill"></i>&nbsp;<a href="{{ route('home') }}"> Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Stuktur Organisasi</li>
        </ol>
    </nav>
    
    <div class="card border-top border-3 border-info p-4" style="height: 1200px">
        <div class="row">
            <div style="width:100%" id="chartDiv"/>
        </div>
	</div>
</div>

<script>
/* Struktur Organisasi Konfig
/* ======================================================== */

// JS 
var config = { 
    type: 'organizational down', 
    defaultPoint: { 
        outline_width: 0, 
        connectorLine: { width: 2, color: '#aaa6a4' }, 
        annotation: { 
          asHTML: true, 
          label_text:
            '<div class="department">' +
                '<div class="d-flex bd-highlight">' +
                    '<div class="cascading-right bg-place">' +
                        '<img src="{{ asset("img") }}/%avatar" alt="Avatar" class="img-fluid rounded-circle" width="120" style="border: 5px solid %color">' +
                    '</div>' +
                    '<div>' +
                        '<div class="bg-title" style="background-color: %color">' +
                            '<div><a href="{{ route("employee") }}"><b>%name</b></a></div>' +
                        '</div>' +
                        '<div class="card bg-body p-1">' +
                            '<div class="tx-body">' +
                                '<a href="{{ route("department") }}"><b>%position</b></a>' +
                                '<h5 class="my-1">' +
                                    '<span class="badge bg-secondary px-2 py-1">PG : %pg</span>&nbsp;' +
                                    '<span class="badge bg-secondary px-2 py-1">JG : %jg</span>&nbsp;' +
                                    '<span class="badge bg-secondary px-2 py-1">JF : %jf</span>' +
                                '</h5>' +
                                '<h6 class="text-success fw-bold mb-0 mt-1"><a href="{{ route("evaluation") }}">%talent</a></h6>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</div>'
        } 
    },
    defaultPoint_label_style_fontFamily: 'Poppins',
    defaultSeries_mouseTracking_enabled: false,
    series: [
        {
            points: [
                @foreach ($department as $data)
                {
                    name: '{{ ucwords(strtolower($data->employee_name)) }}', 
                    id: '{{ $data->department_id }}',
                    parent: '{{ $data->department_head }}',
                    attributes: { 
                        position: '{{ strtoupper(substr($data->department_name, 0, 22)) }}<br>', 
                        talent: 'STAR',
                        role: '{{ strtoupper($data->position_desc) }}',
                        pg: '{{ $data->employee_person_grade }}',
                        jg: '{{ $data->employee_job_grade }}',
                        jf: '{{ $data->employee_job_family }}',
                        avatar: '{{ $data->employee_name != "" ? "user.png" : "user-empty.png" }}'
                    }, 
                    label_style_fontSize: 12, 
                    color: '{{ $data->department_color }}'
                },
                @endforeach
            ]
        }
    ]
};
  
// config.series[0].points.forEach(function(point) { 
//   point.attributes.talent = point.attributes.talent.replace( 
//     /<li>/g, 
//     '<li style="background-color: %color;">' 
//   ); 
// }); 
  
var chart = JSC.chart('chartDiv', config); 
</script>

@endsection
