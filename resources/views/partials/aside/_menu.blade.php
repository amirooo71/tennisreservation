<!-- begin:: Aside Menu -->
<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
    <div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1"
         data-ktmenu-dropdown-timeout="500">
        <ul class="kt-menu__nav ">
            <li class="kt-menu__item  {{Route::currentRouteName() === 'admin.dashboard.index' ? 'kt-menu__item--active' : ''}}"
                aria-haspopup="true">
                <a href="{{route('admin.dashboard.index')}}" class="kt-menu__link ">
                    <span class="kt-menu__link-icon">
                        <i class="fas fa-layer-group"></i>
					</span>
                    <span class="kt-menu__link-text">داشبورد</span>
                </a>
            </li>
            <li class="kt-menu__item  kt-menu__item--submenu {{in_array(Route::currentRouteName(),['admin.clubs.index','admin.clubs.create','admin.clubs.edit']) ? 'kt-menu__item--open' : ''}}"
                aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-icon">
                        <i class="fas fa-baseball-ball"></i>
                    </span>
                    <span class="kt-menu__link-text">کلاب</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu ">
                    <span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item {{Route::currentRouteName() === 'admin.clubs.index' ? 'kt-menu__item--active' : ''}}"
                            aria-haspopup="true">
                            <a href="{{route('admin.clubs.index')}}" class="kt-menu__link ">
                                <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="kt-menu__link-text">اطلاعات</span>
                            </a>
                        </li>
                        @if(!auth()->user()->club())
                            <li class="kt-menu__item {{Route::currentRouteName() === 'admin.clubs.create' ? 'kt-menu__item--active' : ''}}"
                                aria-haspopup="true">
                                <a href="{{route('admin.clubs.create')}}" class="kt-menu__link ">
                                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                        <span></span>
                                    </i>
                                    <span class="kt-menu__link-text">اضافه کردن</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </li>
            @if(auth()->user()->clubs->count())
                <li class="kt-menu__item  kt-menu__item--submenu {{in_array(Route::currentRouteName(),['admin.courts.index','admin.courts.create','admin.courts.edit']) ? 'kt-menu__item--open' : ''}}"
                    aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                    <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-icon">
                        <i class="fas fa-square"></i>
                    </span>
                        <span class="kt-menu__link-text">کورت</span>
                        <i class="kt-menu__ver-arrow la la-angle-right"></i>
                    </a>
                    <div class="kt-menu__submenu ">
                        <span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item {{Route::currentRouteName() === 'admin.courts.index' ? 'kt-menu__item--active' : ''}}"
                                aria-haspopup="true">
                                <a href="{{route('admin.courts.index',auth()->user()->clubs->first())}}"
                                   class="kt-menu__link ">
                                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                        <span></span>
                                    </i>
                                    <span class="kt-menu__link-text">لیست</span>
                                </a>
                            </li>
                            <li class="kt-menu__item {{Route::currentRouteName() === 'admin.courts.create' ? 'kt-menu__item--active' : ''}}"
                                aria-haspopup="true">
                                <a href="{{route('admin.courts.create',auth()->user()->clubs->first())}}"
                                   class="kt-menu__link ">
                                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                        <span></span>
                                    </i>
                                    <span class="kt-menu__link-text">اضافه کردن</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="kt-menu__item  kt-menu__item--submenu {{in_array(Route::currentRouteName(),['admin.bookings.index','admin.group_bookings.index','admin.bookings.canceled']) ? 'kt-menu__item--open' : ''}}"
                    aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                    <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-icon">
                        <i class="far fa-clipboard"></i>
                    </span>
                        <span class="kt-menu__link-text">رزرو</span>
                        <i class="kt-menu__ver-arrow la la-angle-right"></i>
                    </a>
                    <div class="kt-menu__submenu ">
                        <span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item {{Route::currentRouteName() === 'admin.bookings.index' ? 'kt-menu__item--active' : ''}}"
                                aria-haspopup="true">
                                <a href="{{route('admin.bookings.index')}}"
                                   class="kt-menu__link ">
                                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                        <span></span>
                                    </i>
                                    <span class="kt-menu__link-text">لیست</span>
                                </a>
                            </li>
                            <li class="kt-menu__item {{Route::currentRouteName() === 'admin.group_bookings.index' ? 'kt-menu__item--active' : ''}}"
                                aria-haspopup="true">
                                <a href="{{route('admin.group_bookings.index')}}"
                                   class="kt-menu__link ">
                                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                        <span></span>
                                    </i>
                                    <span class="kt-menu__link-text">رزرو گروهی</span>
                                </a>
                            </li>
                            <li class="kt-menu__item {{Route::currentRouteName() === 'admin.bookings.canceled' ? 'kt-menu__item--active' : ''}}"
                                aria-haspopup="true">
                                <a href="{{route('admin.bookings.canceled')}}"
                                   class="kt-menu__link ">
                                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                        <span></span>
                                    </i>
                                    <span class="kt-menu__link-text">کنسلی ها</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="kt-menu__item  kt-menu__item--submenu {{in_array(Route::currentRouteName(),['admin.coaches.index','admin.coaches.create']) ? 'kt-menu__item--open' : ''}}"
                    aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                    <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-icon">
                        <i class="fas fa-running"></i>
                    </span>
                        <span class="kt-menu__link-text">مربی</span>
                        <i class="kt-menu__ver-arrow la la-angle-right"></i>
                    </a>
                    <div class="kt-menu__submenu ">
                        <span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item {{Route::currentRouteName() === 'admin.coaches.index' ? 'kt-menu__item--active' : ''}}"
                                aria-haspopup="true">
                                <a href="{{route('admin.coaches.index')}}"
                                   class="kt-menu__link ">
                                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                        <span></span>
                                    </i>
                                    <span class="kt-menu__link-text">لیست</span>
                                </a>
                            </li>
                            <li class="kt-menu__item {{Route::currentRouteName() === 'admin.coaches.create' ? 'kt-menu__item--active' : ''}}"
                                aria-haspopup="true">
                                <a href="{{route('admin.coaches.create')}}"
                                   class="kt-menu__link ">
                                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                        <span></span>
                                    </i>
                                    <span class="kt-menu__link-text">اضافه کردن</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>


                <li class="kt-menu__item  kt-menu__item--submenu {{in_array(Route::currentRouteName(),['aadmin.bookings.index','aadmin.group_bookings.index']) ? 'kt-menu__item--open' : ''}}"
                    aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                    <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-icon">
                        <i class="fas fa-chart-pie"></i>
                    </span>
                        <span class="kt-menu__link-text">آمار</span>
                        <i class="kt-menu__ver-arrow la la-angle-right"></i>
                    </a>
                    <div class="kt-menu__submenu ">
                        <span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item {{Route::currentRouteName() === 'aadmin.bookings.index' ? 'kt-menu__item--active' : ''}}"
                                aria-haspopup="true">
                                <a href="#"
                                   class="kt-menu__link ">
                                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                        <span></span>
                                    </i>
                                    <span class="kt-menu__link-text">لیست</span>
                                </a>
                            </li>
                            <li class="kt-menu__item {{Route::currentRouteName() === 'aadmin.group_bookings.index' ? 'kt-menu__item--active' : ''}}"
                                aria-haspopup="true">
                                <a href="#"
                                   class="kt-menu__link ">
                                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                        <span></span>
                                    </i>
                                    <span class="kt-menu__link-text">اضافه کردن</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="kt-menu__item  kt-menu__item--submenu {{in_array(Route::currentRouteName(),['admin.creditors.index','admin.debtors.index','admin.payments.index']) ? 'kt-menu__item--open' : ''}}"
                    aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                    <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-icon">
                        <i class="fas fa-coins"></i>
                    </span>
                        <span class="kt-menu__link-text">مالی</span>
                        <i class="kt-menu__ver-arrow la la-angle-right"></i>
                    </a>
                    <div class="kt-menu__submenu ">
                        <span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item {{Route::currentRouteName() === 'admin.creditors.index' ? 'kt-menu__item--active' : ''}}"
                                aria-haspopup="true">
                                <a href="{{route('admin.creditors.index')}}"
                                   class="kt-menu__link ">
                                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                        <span></span>
                                    </i>
                                    <span class="kt-menu__link-text">بستانکاران</span>
                                </a>
                            </li>
                            <li class="kt-menu__item {{Route::currentRouteName() === 'admin.debtors.index' ? 'kt-menu__item--active' : ''}}"
                                aria-haspopup="true">
                                <a href="{{route('admin.debtors.index')}}"
                                   class="kt-menu__link ">
                                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                        <span></span>
                                    </i>
                                    <span class="kt-menu__link-text">بدهکاران</span>
                                </a>
                            </li>
                            </li>
                            <li class="kt-menu__item {{Route::currentRouteName() === 'admin.payments.index' ? 'kt-menu__item--active' : ''}}"
                                aria-haspopup="true">
                                <a href="{{route('admin.payments.index')}}"
                                   class="kt-menu__link ">
                                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                        <span></span>
                                    </i>
                                    <span class="kt-menu__link-text">پرداختی ها</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

            @endif
        </ul>
    </div>
</div>

<!-- end:: Aside Menu -->