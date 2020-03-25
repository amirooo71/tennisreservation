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
            <li class="kt-menu__item  kt-menu__item--submenu {{request()->is('admin/clubs*')  ? 'kt-menu__item--open' : ''}}"
                aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-icon">
                        <i class="fas fa-warehouse"></i>
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
                                <span class="kt-menu__link-text">لیست</span>
                            </a>
                        </li>
                        <li class="kt-menu__item {{Route::currentRouteName() === 'admin.clubs.create' ? 'kt-menu__item--active' : ''}}"
                            aria-haspopup="true">
                            <a href="{{route('admin.clubs.create')}}" class="kt-menu__link ">
                                <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="kt-menu__link-text">اضافه کردن</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @if(auth()->user()->clubs->count())
                <li class="kt-menu__item  kt-menu__item--submenu {{\request()->segment(4) === 'courts' ? 'kt-menu__item--open' : ''}}"
                    aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                    <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-icon">
                        <i class="fas fa-warehouse"></i>
                    </span>
                        <span class="kt-menu__link-text">زمین ها</span>
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
            @endif
        </ul>
    </div>
</div>

<!-- end:: Aside Menu -->