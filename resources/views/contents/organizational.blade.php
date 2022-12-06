@extends('layouts.app')

@section('content')

<style>
.department {
    white-space: pre-wrap;
    width: 200px;
    padding: 5px;
    color: #424242;
    font-weight: normal;
}
.talent {
    white-space:pre-wrap;
    width:120px;
    height:200px;
    color:#212121;
    font-weight:normal;
    text-align:center;
    font-size:10px;
}
.talent li {
    list-style-type:none;
    padding:5px;
    margin:4px 0;
    border-radius:5px;
}
.talent ul { padding:0; }
.talent hr {
    border:none;
    background:white;
    width:40px;
    height:1px;
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
        connectorLine: { width: 2, color: '#e0e0e0' }, 
        annotation: { 
          asHTML: true, 
          label_text: 
            '<div class="department" style="border-bottom:5px solid %color">' +
                '<div class="d-flex">' +
                    '<div class="flex-shrink-0">' +
                        '<img src="..." alt="...">' +
                    '</div>' +
                    '<div class="flex-grow-1 ms-3">' +
                        '<b>%position</b>' +
                        '<span class="fs-5">%name</span><br>' +
                        '<span class="text-primary"><i><b>%role</b></i></span><br>' +
                        '<h5 class="m-1">' +
                            '<span class="badge bg-secondary px-2 py-1">PG : </span>&nbsp;' +
                            '<span class="badge bg-secondary px-2 py-1">JG : </span>&nbsp;' +
                            '<span class="badge bg-secondary px-2 py-1">JF : </span>' +
                        '</h5>' +
                    '</div>' +
                '</div>' +                
                '<h4><span class="badge rounded-pill bg-info px-2 py-1 mt-1">%talent</span></h4>' +
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
                    name: 'Lorem Ipsum', 
                    id: '{{ $data->department_id }}',
                    parent: '{{ $data->department_head }}',
                    attributes: { 
                        position: '{{ strtoupper($data->department_name) }}<br>', 
                        talent: 'STAR',
                        role: 'VICE PRESIDENT'
                    }, 
                    label_style_fontSize: 12, 
                    color: 'white'
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
