@extends('layout')
@section('content')

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Quản lý</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Quản lý</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Home</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-30">
        <div class="pd-20 card-box height-100-p">
            <h3 style="color: #a683eb" class="text-center">Tổng số sinh viên</h3>
            <div class="progress-box text-center">
                 <input type="text" class="knob dial5" value="{{$sinhvien}}" data-width="220" data-height="220" data-thickness="0.08" data-fgColor="#a683eb" data-cursor="true">
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-30">
        <div class="pd-20 card-box height-100-p">
            <h3 style="color: #f56767" class="text-center">Tổng môn học</h3>
            <div class="progress-box text-center">
                 <input type="text" class="knob dial5" value="{{$monhoc}}" data-width="220" data-height="220" data-thickness="0.08" data-fgColor="#f56767" data-angleOffset="" data-linecap="round">
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-30">
        <div class="pd-20 card-box height-100-p">
            <h3 style="color: #f56767" class="text-center">lớp</h3>
            <div class="progress-box text-center">
                 <input type="text" class="knob dial5" value="{{$lop}}" data-width="220" data-height="220" data-thickness="0.02" data-fgColor="#f56767" data-skin="tron" data-angleOffset="180">
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-30">
        <div class="pd-20 card-box height-100-p">
            <h3 style="color: #0099ff" class="text-center">hình thức đào tạo</h3>
            <div class="progress-box text-center">
                 <input type="text" class="knob dial5" value="{{$htdt}}" data-width="220" data-height="220" data-thickness="0.08" data-fgColor="#0099ff" data-angleOffset="-125" data-angleArc="250" data-rotation="anticlockwise">
            </div>
        </div>
    </div>
</div>

<div class="min-height-200px">
    <div class="pd-20 card-box mb-30">
        <div class="calendar-wrap">
            <div id='calendar'></div>
        </div>
        <!-- calendar modal -->
        <div id="modal-view-event" class="modal modal-top fade calendar-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <h4 class="h4"><span class="event-icon weight-400 mr-3"></span><span class="event-title"></span></h4>
                        <div class="event-body"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="modal-view-event-add" class="modal modal-top fade calendar-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="add-event">
                        <div class="modal-body">
                            <h4 class="text-blue h4 mb-10">Add Event Detail</h4>
                            <div class="form-group">
                                <label>Event name</label>
                                <input type="text" class="form-control" name="ename">
                            </div>
                            <div class="form-group">
                                <label>Event Date</label>
                                <input type='text' class="datetimepicker form-control" name="edate">
                            </div>
                            <div class="form-group">
                                <label>Event Description</label>
                                <textarea class="form-control" name="edesc"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Event Color</label>
                                <select class="form-control" name="ecolor">
                                    <option value="fc-bg-default">fc-bg-default</option>
                                    <option value="fc-bg-blue">fc-bg-blue</option>
                                    <option value="fc-bg-lightgreen">fc-bg-lightgreen</option>
                                    <option value="fc-bg-pinkred">fc-bg-pinkred</option>
                                    <option value="fc-bg-deepskyblue">fc-bg-deepskyblue</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Event Icon</label>
                                <select class="form-control" name="eicon">
                                    <option value="circle">circle</option>
                                    <option value="cog">cog</option>
                                    <option value="group">group</option>
                                    <option value="suitcase">suitcase</option>
                                    <option value="calendar">calendar</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('public/src/plugins/fullcalendar/fullcalendar.min.js')}}"></script>
<script src="{{asset('public/vendors/scripts/calendar-setting.js')}}"></script>

@endsection