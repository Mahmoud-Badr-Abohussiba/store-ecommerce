<div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

            <li class="nav-item active"><a href=""><i class="la la-mouse-pointer"></i><span
                        class="menu-title" data-i18n="nav.add_on_drag_drop.main">الرئيسية </span></a>
            </li>

{{--            <li class="nav-item  open ">--}}
{{--                <a href=""><i class="la la-home"></i>--}}
{{--                    <span class="menu-title" data-i18n="nav.dash.main">لغات الموقع </span>--}}
{{--                    <span--}}
{{--                        class="badge badge badge-info badge-pill float-right mr-2"></span>--}}
{{--                </a>--}}
{{--                <ul class="menu-content">--}}
{{--                    <li class="active"><a class="menu-item" href=""--}}
{{--                                          data-i18n="nav.dash.ecommerce"> عرض الكل </a>--}}
{{--                    </li>--}}
{{--                    <li><a class="menu-item" href="" data-i18n="nav.dash.crypto">أضافة--}}
{{--                            لغة جديده </a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </li>--}}


            <li class="nav-item"><a href=""><i class="la la-group"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">الاقسام </span>
                    <span
                        class="badge badge badge-danger badge-pill float-right mr-2">{{\App\Models\Category::all()->count()}}</span>
                </a>
                <ul class="menu-content">
                    <li class=""><a class="menu-item" href="{{route('admin.categories','all')}}"
                                          data-i18n="nav.dash.ecommerce"> عرض الكل </a>
                    </li>
                    <li class=""><a class="menu-item" href="{{route('admin.categories','main')}}"
                                          data-i18n="nav.dash.ecommerce"> عرض الاقسام الرئيسيه </a>

                    </li>
                    <li class=""><a class="menu-item" href="{{route('admin.categories','sub')}}"
                                          data-i18n="nav.dash.ecommerce"> عرض الاقسام الفرعيه </a>
                    </li>
                    <li><a class="menu-item" href="{{route('admin.categories.create')}}" data-i18n="nav.dash.crypto">أضافة
                             قسم جديد </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item"><a href=""><i class="la la-group"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">الماركات التجاريه </span>
                    <span
                        class="badge badge badge-danger badge-pill float-right mr-2">{{\App\Models\Brand::all()->count()}}</span>
                </a>
                <ul class="menu-content">
                    <li class=""><a class="menu-item" href="{{route('admin.brands')}}"
                                          data-i18n="nav.dash.ecommerce"> عرض الكل </a>
                    </li>
                    <li><a class="menu-item" href="{{route('admin.brands.create')}}" data-i18n="nav.dash.crypto">أضافة ماركة جديد </a>
                    </li>
                </ul>
            </li>


            <li class="nav-item"><a href=""><i class="la la-group"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">المنتجات </span>
                    <span
                        class="badge badge badge-danger badge-pill float-right mr-2">{{\App\Models\Product::all()->count()}}</span>
                </a>
                <ul class="menu-content">
                    <li class=""><a class="menu-item" href="{{route('admin.products')}}"
                                          data-i18n="nav.dash.ecommerce"> عرض الكل </a>
                    </li>
                    <li><a class="menu-item" href="{{route('admin.products.create.general')}}" data-i18n="nav.dash.crypto">أضافة منتج جديد </a>
                    </li>
                    <li><a class="menu-item" href="{{route('admin.product.attributes')}}" data-i18n="nav.dash.crypto">خصائص المنتجات </a>
                    </li>
                    <li><a class="menu-item" href="{{route('admin.product.attributes.create')}}" data-i18n="nav.dash.crypto">اضافة خاصيه جديده </a>
                    </li>
                    <li><a class="menu-item" href="{{route('options.index')}}" data-i18n="nav.dash.crypto">اختيارات خصائص المنتجات</a>
                    </li>
                    <li><a class="menu-item" href="{{route('options.create')}}" data-i18n="nav.dash.crypto">اضافة اختيار جديد لخاصيه </a>
                    </li>
                </ul>
            </li>


            <li class="nav-item"><a href=""><i class="la la-group"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">الشعارات </span>
                    <span
                        class="badge badge badge-danger badge-pill float-right mr-2">{{\App\Models\Tag::all()->count()}}</span>
                </a>
                <ul class="menu-content">
                    <li class=""><a class="menu-item" href="{{route('admin.tags')}}"
                                          data-i18n="nav.dash.ecommerce"> عرض الكل </a>
                    </li>
                    <li><a class="menu-item" href="{{route('admin.tags.create')}}" data-i18n="nav.dash.crypto">أضافة شعار جديد </a>
                    </li>
                </ul>
            </li>


            <li class=" nav-item"><a href="#"><i class="la la-television"></i><span class="menu-title"
                                                                                    data-i18n="nav.templates.main">{{__('dashboard/sidebar.setting')}}</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="#" data-i18n="nav.templates.vert.main">{{__('dashboard/sidebar.shipping-methods')}}</a>
                        <ul class="menu-content">
                            <li><a class="menu-item" href="{{route('edit.shipping.method', 'free')}}"
                                   data-i18n="nav.templates.vert.classic_menu">{{__('dashboard/sidebar.free-shipping')}}</a>
                            </li>
                            <li><a class="menu-item" href="{{route('edit.shipping.method', 'inner')}}">{{__('dashboard/sidebar.local-shipping')}}</a>
                            </li>
                            <li><a class="menu-item" href="{{route('edit.shipping.method', 'outer')}}"
                                   data-i18n="nav.templates.vert.compact_menu">{{__('dashboard/sidebar.outer-shipping')}}</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
