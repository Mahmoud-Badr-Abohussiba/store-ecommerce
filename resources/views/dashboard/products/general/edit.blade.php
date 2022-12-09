@extends('layouts.admin')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">الرئيسية </a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{route('admin.categories','main')}}"> الاقسام
                                        الرئيسية </a>
                                </li>
                                <li class="breadcrumb-item active"> تعديل - {{$category -> name}}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form"> تعديل بيانات القسم </h4>
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
                                    <div class="card-body">
                                        <form class="form"
                                              action="{{route('admin.categories.update', $category->slug)}}"
                                              method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')

                                            <input name="id" value="{{$category->id}}" type="hidden">
                                            @if($category->parent_id == null)
                                                <input class="hidden" name="type" value="main">
                                            @else
                                                <input class="hidden" name="type" value="sub">
                                            @endif

                                            <div class="form-group">
                                                <div class="text-center">
                                                    <img src="{{asset('assets/images/categories/'.$category->photo)}}"
                                                         class="rounded-circle height-150"
                                                         alt="صورة القسم">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>صورة القسم</label>
                                                <label id="projectinput7" class="file center-block">
                                                    <input type="file" id="file" name="photo">
                                                    <span class="file-custom"></span>
                                                </label>
                                                @error('photo')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                            <div class="form-body">

                                                <h4 class="form-section"><i class="ft-home"></i>بيانات القسم</h4>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput1">الاسم</label>
                                                            <input type="text" value="{{$category-> name}}" id="name"
                                                                   class="form-control"
                                                                   placeholder=" {{$category-> name}}"
                                                                   name="name">
                                                            @error("name")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    @if(!($category->parent_id==null))
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="projectinput1">الاسم بالرابط </label>
                                                                <input type="text" value="{{$category->slug}}" id="slug"
                                                                       class="form-control"
                                                                       placeholder="{{$category->slug}}"
                                                                       name="slug">
                                                                @error("slug")
                                                                <span class="text-danger">{{$message}}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                </div>
                                                @endif
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group mt-1">
                                                            <input type="checkbox"
                                                                   value="{{$category->is_active}} "
                                                                   id="switcheryColor4"
                                                                   class="switchery" data-color="success"
                                                                   @if($category->is_active==1)checked @endif
                                                                   name="is_active"/>
                                                            <label for="switcheryColor4"
                                                                   class="card-title ml-1">الحاله</label>

                                                            @error("is_active")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        @if(!$category->parent_id == null)
                                                            <div class="form-group">
                                                                <label for="projectinput1">القسم الاساسى </label>
                                                                <select class="select2 form-control col-md-6"
                                                                        name="parent_id">
                                                                    <option value="" disabled selected>اختار القسم
                                                                        الرئيسى
                                                                    </option>

                                                                    @foreach($categories as $mainCategory)
                                                                        <option class="dropdown-item"
                                                                                value="{{$mainCategory->id}}"
                                                                                @if ($mainCategory->id == $category->parent_id) selected @endif>
                                                                            {{$mainCategory->name}}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            @error("parent_id")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="form-actions">
                                                <button type="button" class="btn btn-warning mr-1"
                                                        onclick="history.back();">
                                                    <i class="ft-x"></i> تراجع
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-check-square-o"></i> حفظ
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- // Basic form layout section end -->
            </div>
        </div>
    </div>
@endsection
