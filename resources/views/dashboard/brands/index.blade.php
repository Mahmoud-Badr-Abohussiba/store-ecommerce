@extends('layouts.admin')
@section('content')

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">جميع الماركات التجاريه </h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">الرئيسية</a>
                                </li>
                                <li class="breadcrumb-item active">الماركات التجاريه
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- DOM - jQuery events table -->
                <section id="dom">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">الماركات التجاريه</h4>
                                    <a class="heading-elements-toggle"><i
                                            class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>

                                @include('dashboard.includes.alerts.success')
                                @include('dashboard.includes.alerts.errors')

                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                        @isset($brands)
                                            @if($brands->count() > 0)
                                                <table
                                                    class="table display nowrap table-striped table-bordered">
                                                    <thead class="">
                                                    <tr>
                                                        <th>الاسم</th>
                                                        <th>الحالة</th>
                                                        <th>صوره الماركه</th>
                                                        <th>الإجراءات</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($brands as $brand)
                                                        <tr>
                                                            <td style="width: 200px">{{$brand -> name}}</td>
                                                            <td style="width: 160px">{{$brand -> getActive()}}</td>
                                                            <td style="width: 160px"><img
                                                                    style="width: 150px; height: 100px;"
                                                                    src="{{asset('assets/images/brands/'.$brand->photo)}}">
                                                            </td>
                                                            <td style="width: 300px">
                                                                <div class="btn-group" role="group"
                                                                     aria-label="Basic example">
                                                                    <a href="{{route('admin.brands.edit',$brand -> id)}}"
                                                                       class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">تعديل</a>

                                                                    <a href="{{route('admin.brands.delete',$brand -> id)}}"
                                                                       class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">حذف</a>

                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    @else
                                                        <div class="row">
                                                            <div class="col-6"></div>
                                                            <div class="col-6"><h4 class="align-content-center"> لا يوجد
                                                                    ماركات تجاريه </h4></div>

                                                        </div>
                                                        <div class="row">
                                                            <button class="btn btn-primary">
                                                                <i class="la la-check-square-o"></i><a
                                                                    href="{{route('admin.brands.create')}}"
                                                                    style="color: black">اضافة ماركه جديده</a>
                                                            </button>
                                                        </div>
                                                    @endif
                                                    @endisset
                                                    </tbody>
                                                </table>
                                                <div class="justify-content-center d-flex">

                                                </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="justify-content-center d-flex">{!! $brands -> links() !!}</div>
                </section>
            </div>
        </div>
    </div>

@stop
