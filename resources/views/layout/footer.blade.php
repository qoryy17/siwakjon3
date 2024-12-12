<!-- Required Js -->
<script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/fonts/custom-font.js') }} "></script>
<script src="{{ asset('assets/js/pcoded.js') }} "></script>
<script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
<script>
    layout_change('light');
</script>
<script>
    layout_sidebar_change('light');
</script>
<script>
    change_box_container('false');
</script>
<script>
    layout_caption_change('true');
</script>
<script>
    layout_rtl_change('false');
</script>
<script>
    preset_change("preset-8");
</script>

<div class="offcanvas border-0 pct-offcanvas offcanvas-end" tabindex="-1" id="offcanvas_pc_layout">
    <div class="offcanvas-header justify-content-between">
        <h5 class="offcanvas-title">Settings</h5>
        <button type="button" class="btn btn-icon btn-link-danger" data-bs-dismiss="offcanvas" aria-label="Close"><i
                class="ti ti-x"></i></button>
    </div>
    <div class="pct-body customizer-body">
        <div class="offcanvas-body py-0">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="pc-dark">
                        <h6 class="mb-1">Theme Mode</h6>
                        <p class="text-muted text-sm">Choose light or dark mode or Auto</p>
                        <div class="row theme-color theme-layout">
                            <div class="col-4">
                                <div class="d-grid">
                                    <button class="preset-btn btn active" data-value="true"
                                        onclick="layout_change('light');">
                                        <span class="btn-label">Light</span>
                                        <span
                                            class="pc-lay-icon"><span></span><span></span><span></span><span></span></span>
                                    </button>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="d-grid">
                                    <button class="preset-btn btn" data-value="false" onclick="layout_change('dark');">
                                        <span class="btn-label">Dark</span>
                                        <span
                                            class="pc-lay-icon"><span></span><span></span><span></span><span></span></span>
                                    </button>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="d-grid">
                                    <button class="preset-btn btn" data-value="default"
                                        onclick="layout_change_default();" data-bs-toggle="tooltip"
                                        title="Automatically sets the theme based on user's operating system's color scheme.">
                                        <span class="btn-label">Default</span>
                                        <span class="pc-lay-icon d-flex align-items-center justify-content-center">
                                            <i class="ph-duotone ph-cpu"></i>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <h6 class="mb-1">Sidebar Theme</h6>
                    <p class="text-muted text-sm">Choose Sidebar Theme</p>
                    <div class="row theme-color theme-sidebar-color">
                        <div class="col-6">
                            <div class="d-grid">
                                <button class="preset-btn btn" data-value="true"
                                    onclick="layout_sidebar_change('dark');">
                                    <span class="btn-label">Dark</span>
                                    <span
                                        class="pc-lay-icon"><span></span><span></span><span></span><span></span></span>
                                </button>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-grid">
                                <button class="preset-btn btn active" data-value="false"
                                    onclick="layout_sidebar_change('light');">
                                    <span class="btn-label">Light</span>
                                    <span
                                        class="pc-lay-icon"><span></span><span></span><span></span><span></span></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <h6 class="mb-1">Accent color</h6>
                    <p class="text-muted text-sm">Choose your primary theme color</p>
                    <div class="theme-color preset-color">
                        <a href="#!" data-value="preset-1"><i class="ti ti-check"></i></a>
                        <a href="#!" data-value="preset-2"><i class="ti ti-check"></i></a>
                        <a href="#!" data-value="preset-3"><i class="ti ti-check"></i></a>
                        <a href="#!" data-value="preset-4"><i class="ti ti-check"></i></a>
                        <a href="#!" data-value="preset-5"><i class="ti ti-check"></i></a>
                        <a href="#!" data-value="preset-6"><i class="ti ti-check"></i></a>
                        <a href="#!" data-value="preset-7"><i class="ti ti-check"></i></a>
                        <a href="#!" class="active" data-value="preset-8"><i class="ti ti-check"></i></a>
                        <a href="#!" data-value="preset-9"><i class="ti ti-check"></i></a>
                        <a href="#!" data-value="preset-10"><i class="ti ti-check"></i></a>
                    </div>
                </li>
                <li class="list-group-item">
                    <h6 class="mb-1">Sidebar Caption</h6>
                    <p class="text-muted text-sm">Sidebar Caption Hide/Show</p>
                    <div class="row theme-color theme-nav-caption">
                        <div class="col-6">
                            <div class="d-grid">
                                <button class="preset-btn btn active" data-value="true"
                                    onclick="layout_caption_change('true');">
                                    <span class="btn-label">Caption Show</span>
                                    <span
                                        class="pc-lay-icon"><span></span><span></span><span><span></span><span></span></span><span></span></span>
                                </button>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-grid">
                                <button class="preset-btn btn" data-value="false"
                                    onclick="layout_caption_change('false');">
                                    <span class="btn-label">Caption Hide</span>
                                    <span
                                        class="pc-lay-icon"><span></span><span></span><span><span></span><span></span></span><span></span></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="pc-rtl">
                        <h6 class="mb-1">Theme Layout</h6>
                        <p class="text-muted text-sm">LTR/RTL</p>
                        <div class="row theme-color theme-direction">
                            <div class="col-6">
                                <div class="d-grid">
                                    <button class="preset-btn btn active" data-value="false"
                                        onclick="layout_rtl_change('false');">
                                        <span class="btn-label">LTR</span>
                                        <span
                                            class="pc-lay-icon"><span></span><span></span><span></span><span></span></span>
                                    </button>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-grid">
                                    <button class="preset-btn btn" data-value="true"
                                        onclick="layout_rtl_change('true');">
                                        <span class="btn-label">RTL</span>
                                        <span
                                            class="pc-lay-icon"><span></span><span></span><span></span><span></span></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item pc-box-width">
                    <div class="pc-container-width">
                        <h6 class="mb-1">Layout Width</h6>
                        <p class="text-muted text-sm">Choose Full or Container Layout</p>
                        <div class="row theme-color theme-container">
                            <div class="col-6">
                                <div class="d-grid">
                                    <button class="preset-btn btn active" data-value="false"
                                        onclick="change_box_container('false')">
                                        <span class="btn-label">Full Width</span>
                                        <span
                                            class="pc-lay-icon"><span></span><span></span><span></span><span><span></span></span></span>
                                    </button>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-grid">
                                    <button class="preset-btn btn" data-value="true"
                                        onclick="change_box_container('true')">
                                        <span class="btn-label">Fixed Width</span>
                                        <span
                                            class="pc-lay-icon"><span></span><span></span><span></span><span><span></span></span></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="d-grid">
                        <button class="btn btn-light-danger" id="layoutreset">Reset Layout</button>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- datatable Js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('assets/js/plugins/dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/dataTables.bootstrap5.min.js') }}"></script>
<!-- tagify -->
<script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>
<!-- [Page Specific JS] start -->
<script src="{{ asset('assets/js/plugins/simplemde.min.js') }}"></script>
<!-- bootstrap-datepicker -->
<script src="{{ asset('assets/js/plugins/datepicker-full.min.js') }}"></script>
<script src="{{ asset('assets/js/siwakjon.js') }}"></script>
<script src="{{ asset('assets/js/clock.js') }}"></script>
</body>
<!-- [Body] end -->

</html>
