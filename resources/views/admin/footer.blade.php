<style>
/* ══════════════════════════════════════
   GLOBAL PAGE & CONTENT AREA STYLES
   (applied here so they take effect
   regardless of which page is loaded)
══════════════════════════════════════ */
body {
    background: #f1f2f4;
    font-family: 'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
}

/* Content area padding normalisation */
.app-content { padding: 0; }
.content.container-fluid { padding: 0; }

/* ── Admin footer bar ── */
.admin-footer-bar {
    margin-left: 0;
    padding: 12px 28px;
    background: #fff;
    border-top: 1px solid #e3e5e8;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 8px;
    font-family: 'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
}
.admin-footer-bar .footer-left {
    font-size: 12px;
    color: #8c9196;
    display: flex;
    align-items: center;
    gap: 6px;
}
.admin-footer-bar .footer-left strong { color: #303d89; font-weight: 600; }
.admin-footer-bar .footer-right {
    font-size: 12px;
    color: #8c9196;
    display: flex;
    align-items: center;
    gap: 6px;
}
.admin-footer-bar .footer-heart { color: #ef4444; font-size: 11px; }
.admin-footer-bar a { color: #303d89; text-decoration: none; font-weight: 500; }
.admin-footer-bar a:hover { text-decoration: underline; }
</style>

<!-- Footer bar -->
<div class="admin-footer-bar">
    <div class="footer-left">
        <i class="fa-solid fa-shield-halved" style="color:#303d89;font-size:11px"></i>
        &copy; {{ date('Y') }} <strong>Web Mingo E-Commerce Admin</strong> — All rights reserved
    </div>
    <div class="footer-right">
        Crafted with <span class="footer-heart"><i class="fa-solid fa-heart"></i></span> by
        <a href="#" target="_blank">Webmingo</a>
        &nbsp;·&nbsp;
        <span style="color:#babec3">v1.0.0</span>
    </div>
</div>

<!-- ═══════════════ SCRIPTS ═══════════════ -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js" type="text/javascript"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.0.4/popper.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{ URL::asset('admin/js/jquery-ui.min.js') }}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.10.4/sweetalert2.min.js"></script>
<script src="{{ URL::asset('admin/js/datatable.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('admin/custom/js/header.js') }}" type="text/javascript"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

</body>
</html>