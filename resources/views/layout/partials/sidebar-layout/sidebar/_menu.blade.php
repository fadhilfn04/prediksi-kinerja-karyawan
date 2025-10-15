<!--begin::sidebar menu-->
<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
	<!--begin::Menu wrapper-->
	<div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5"
		data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto"
		data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
		data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">

		<!--begin::Menu-->
		<div class="menu menu-column menu-rounded menu-sub-indention px-3 fw-semibold fs-6" id="#kt_app_sidebar_menu"
			data-kt-menu="true" data-kt-menu-expand="false">

			<!--begin:Dashboard-->
			<div class="menu-item">
				<a class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
					<span class="menu-icon">{!! getIcon('element-11', 'fs-2') !!}</span>
					<span class="menu-title">Dashboard</span>
				</a>
			</div>
			<!--end:Dashboard-->

			<!--begin:Master Data section-->
			<div class="menu-item pt-5">
				<div class="menu-content">
					<span class="menu-heading fw-bold text-uppercase fs-7">Master Data & Model</span>
				</div>
			</div>

			<!--begin:Karyawan (Menu Input Data)-->
			<div class="menu-item">
				<a class="menu-link {{ request()->routeIs('karyawan.*') ? 'active' : '' }}" href="{{ route('karyawan.index') }}">
					<span class="menu-icon">{!! getIcon('people', 'fs-2') !!}</span>
					<span class="menu-title">Data Karyawan</span>
				</a>
			</div>
			<!--end:Karyawan-->

			<!--begin: Training Model-->
			<div class="menu-item">
				<a class="menu-link {{ request()->routeIs('training.*') ? 'active' : '' }}" href="{{ route('training.index') }}">
					<span class="menu-icon">{!! getIcon('chart-line', 'fs-2') !!}</span>
					<span class="menu-title">Training Model</span>
				</a>
			</div>
			<!--end: Training Model-->
		</div>
		<!--end::Menu-->
	</div>
	<!--end::Menu wrapper-->
</div>
<!--end::sidebar menu-->