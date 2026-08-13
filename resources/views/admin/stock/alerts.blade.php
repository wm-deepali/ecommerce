@include('admin.top-header')
<div class="main-section">
    @include('admin.header')

    <style>

        .main-section,
        .app-content,
        .alert-page,
        .main-layout,
        .kpi-strip {
            max-width: 100%;
            box-sizing: border-box;
        }

        /* ═══ Fix: grid columns default to min-width:auto, so wide table
   content pushes the whole grid (and the 300px sidebar with it)
   past the viewport instead of scrolling internally. ═══ */
        .main-layout {
            min-width: 0;
        }

        .main-layout>div {
            min-width: 0;
        }

        .section-card {
            min-width: 0;
        }

        /* Belt-and-suspenders: stop the whole page from ever scrolling
   horizontally, whatever the cause */
        html,
        body {
            overflow-x: hidden !important;
        }

        .table-wrap {
            overflow-x: auto;
        }

        /* 1. Force outer shell into a proper side-by-side flex row */
        .main-section {
            display: flex !important;
            flex-direction: row !important;
            align-items: stretch !important;
            min-height: 100vh !important;
            overflow: hidden !important;
        }

        /* 2. Sidebar: hard lock — never shrinks, never grows, sticky scroll */
        .main-section #cssmenu {
            flex-shrink: 0 !important;
            flex-grow: 0 !important;
            width: 280px !important;
            min-width: 280px !important;
            max-width: 280px !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            position: sticky !important;
            top: 0 !important;
            height: 100vh !important;
            align-self: flex-start !important;
        }

        /* 3. Content area: fills remaining space
   min-width: 0 is the KEY fix — without it, flex children
   can overflow their container and squeeze siblings */
        .main-section .app-content,
        .main-section .app-content.content.container-fluid {
            flex: 1 1 0% !important;
            min-width: 0 !important;
            max-width: 100% !important;
            overflow-x: auto !important;
            box-sizing: border-box !important;
        }

        :root {
            --bg: #f1f2f4;
            --surface: #ffffff;
            --border: #e3e5e8;
            --text-primary: #202223;
            --text-secondary: #6d7175;
            --text-hint: #8c9196;
            --accent: #303d89;
            --accent-light: #f0f1fc;
            --green: #007a5e;
            --green-bg: #e3f1ec;
            --red: #b22222;
            --red-bg: #fce8e8;
            --amber: #916a00;
            --amber-bg: #fff5cc;
            --amber-border: #f0d060;
            --blue: #0069d9;
            --blue-bg: #e8f2ff;
            --purple: #6d28d9;
            --purple-bg: #ede9fe;
            --radius-sm: 8px;
            --radius-md: 12px;
            --shadow-card: 0 1px 3px rgba(0, 0, 0, .08), 0 0 0 1px var(--border);
            --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }










        .alert-page {
            background: var(--bg);
            padding: 24px 28px;
            min-height: 100vh;
            font-family: var(--font);
            color: var(--text-primary);
        }

        .alert-page * {
            box-sizing: border-box;
        }

        /* ── Page header ───────────────────────────────────────── */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
        }

        .page-header h1 {
            font-size: 20px;
            font-weight: 650;
            color: var(--text-primary);
            margin: 0;
        }

        .crumb {
            font-size: 12.5px;
            color: var(--text-hint);
            margin-top: 3px;
        }

        .crumb a {
            color: var(--accent);
            text-decoration: none;
        }

        .crumb a:hover {
            text-decoration: underline;
        }

        .crumb span {
            margin: 0 5px;
        }

        /* ── Buttons ───────────────────────────────────────────── */
        .btn-primary-dash {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            font-family: var(--font);
            transition: background .15s;
            box-shadow: 0 1px 3px rgba(48, 61, 137, .25);
        }

        .btn-primary-dash:hover {
            background: #252f70;
            color: #fff;
        }

        .btn-secondary-dash {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--surface);
            color: var(--text-primary);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            font-family: var(--font);
            transition: background .15s;
            box-shadow: 0 1px 2px rgba(0, 0, 0, .04);
        }

        .btn-secondary-dash:hover {
            background: var(--bg);
            color: var(--text-primary);
        }

        .btn-danger-soft {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--red-bg);
            color: var(--red);
            border: 1px solid #f5c6c6;
            border-radius: var(--radius-sm);
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            font-family: var(--font);
            transition: all .15s;
        }

        .btn-danger-soft:hover {
            background: var(--red);
            color: #fff;
            border-color: var(--red);
        }

        /* ── KPI strip ─────────────────────────────────────────── */
        .kpi-strip {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 20px;
        }

        @media(max-width:900px) {
            .kpi-strip {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .kpi-tile {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 18px 20px;
            box-shadow: var(--shadow-card);
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .kpi-icon {
            width: 42px;
            height: 42px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .kpi-icon.red {
            background: var(--red-bg);
            color: var(--red);
        }

        .kpi-icon.amber {
            background: var(--amber-bg);
            color: var(--amber);
        }

        .kpi-icon.green {
            background: var(--green-bg);
            color: var(--green);
        }

        .kpi-icon.purple {
            background: var(--purple-bg);
            color: var(--purple);
        }

        .kpi-label {
            font-size: 11.5px;
            font-weight: 600;
            color: var(--text-hint);
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .kpi-value {
            font-size: 24px;
            font-weight: 750;
            color: var(--text-primary);
            line-height: 1.1;
            margin-top: 3px;
        }

        .kpi-sub {
            font-size: 11.5px;
            color: var(--text-hint);
            margin-top: 4px;
        }

        /* ── Top priority banner ───────────────────────────────── */
        .priority-banner {
            background: linear-gradient(135deg, #fff0f0 0%, #fff8f8 100%);
            border: 1px solid #f5c6c6;
            border-left: 4px solid var(--red);
            border-radius: var(--radius-md);
            padding: 16px 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            box-shadow: var(--shadow-card);
        }

        .priority-banner-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .priority-banner-icon {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-sm);
            background: var(--red-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: var(--red);
            flex-shrink: 0;
        }

        .priority-banner-title {
            font-size: 14px;
            font-weight: 650;
            color: var(--red);
        }

        .priority-banner-sub {
            font-size: 12.5px;
            color: var(--text-secondary);
            margin-top: 2px;
        }

        /* ── Main layout: table left + settings right ──────────── */
        .main-layout {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 20px;
            align-items: start;
        }

        @media(max-width:1024px) {
            .main-layout {
                grid-template-columns: 1fr;
            }
        }

        /* ── Section card ──────────────────────────────────────── */
        .section-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-card);
            overflow: hidden;
            margin-bottom: 16px;
        }

        .section-card:last-child {
            margin-bottom: 0;
        }

        .section-card-header {
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
            background: #fafafa;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .section-card-header h5 {
            font-size: 13px;
            font-weight: 650;
            color: var(--text-primary);
            margin: 0;
        }

        .section-card-body {
            padding: 20px;
        }

        /* ── Status tabs ───────────────────────────────────────── */
        .status-tabs {
            display: flex;
            border-bottom: 1px solid var(--border);
            background: var(--surface);
            padding: 0 20px;
            overflow-x: auto;
        }

        .status-tab {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 12px 16px;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-secondary);
            text-decoration: none;
            border-bottom: 2px solid transparent;
            white-space: nowrap;
            transition: color .15s;
            cursor: pointer;
        }

        .status-tab:hover {
            color: var(--text-primary);
        }

        .status-tab.active {
            color: var(--accent);
            border-bottom-color: var(--accent);
            font-weight: 600;
        }

        .tab-count {
            background: var(--bg);
            color: var(--text-hint);
            font-size: 11px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 20px;
        }

        .status-tab.active .tab-count {
            background: var(--accent-light);
            color: var(--accent);
        }

        .tab-count.red {
            background: var(--red-bg);
            color: var(--red);
        }

        .tab-count.amber {
            background: var(--amber-bg);
            color: var(--amber);
        }

        .tab-count.green {
            background: var(--green-bg);
            color: var(--green);
        }

        /* ── Filter bar ────────────────────────────────────────── */
        .filter-bar {
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
        }

        .filter-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: flex-end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .filter-group label {
            font-size: 11.5px;
            font-weight: 600;
            color: var(--text-secondary);
            letter-spacing: .03em;
            text-transform: uppercase;
        }

        .filter-control {
            height: 36px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 0 11px;
            font-size: 13px;
            color: var(--text-primary);
            background: var(--surface);
            outline: none;
            transition: border-color .15s;
            font-family: var(--font);
            min-width: 150px;
        }

        .filter-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(48, 61, 137, .12);
        }

        .btn-filter {
            height: 36px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            padding: 0 16px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            font-family: var(--font);
            transition: background .15s;
        }

        .btn-filter:hover {
            background: #252f70;
        }

        .btn-filter-reset {
            height: 36px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--surface);
            color: var(--text-primary);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 0 14px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            font-family: var(--font);
            transition: background .15s;
        }

        .btn-filter-reset:hover {
            background: var(--bg);
        }

        /* ── Alert table ───────────────────────────────────────── */
        .table-wrap {
            overflow-x: auto;
        }

        .alert-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            font-family: var(--font);
        }

        .alert-table thead th {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--text-hint);
            padding: 10px 16px;
            border-bottom: 1px solid var(--border);
            background: #fafafa;
            text-align: left;
            white-space: nowrap;
        }

        .alert-table tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background .1s;
        }

        .alert-table tbody tr:last-child {
            border-bottom: none;
        }

        .alert-table tbody tr:hover {
            background: #fafbfc;
        }

        .alert-table tbody tr.row-critical {
            background: #fff8f8;
        }

        .alert-table tbody tr.row-critical:hover {
            background: #fff0f0;
        }

        .alert-table tbody tr.row-low {
            background: #fffcf2;
        }

        .alert-table tbody tr.row-low:hover {
            background: #fff9e6;
        }

        .alert-table tbody td {
            padding: 13px 16px;
            vertical-align: middle;
        }

        /* ── ID chip ───────────────────────────────────────────── */
        .id-chip {
            display: inline-block;
            background: var(--bg);
            color: var(--text-secondary);
            font-size: 11px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 6px;
            font-family: 'SF Mono', 'Fira Code', monospace;
        }

        /* ── Product cell ──────────────────────────────────────── */
        .prod-thumb {
            width: 46px;
            height: 46px;
            border-radius: var(--radius-sm);
            object-fit: cover;
            border: 1px solid var(--border);
            flex-shrink: 0;
        }

        .prod-name {
            font-weight: 600;
            font-size: 13px;
            color: var(--text-primary);
        }

        .prod-meta {
            font-size: 11.5px;
            color: var(--text-hint);
            font-family: 'SF Mono', 'Fira Code', monospace;
            margin-top: 2px;
        }

        /* ── Category tag ──────────────────────────────────────── */
        .cat-tag {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: var(--accent-light);
            color: var(--accent);
            font-size: 11.5px;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 6px;
        }

        /* ── Stock gauge ───────────────────────────────────────── */
        .gauge-wrap {
            min-width: 100px;
        }

        .gauge-numbers {
            display: flex;
            align-items: baseline;
            gap: 4px;
        }

        .gauge-current {
            font-size: 18px;
            font-weight: 750;
            line-height: 1;
        }

        .gauge-divider {
            font-size: 12px;
            color: var(--text-hint);
        }

        .gauge-min {
            font-size: 12px;
            color: var(--text-hint);
        }

        .gauge-bar {
            height: 5px;
            border-radius: 10px;
            background: var(--bg);
            overflow: hidden;
            margin-top: 6px;
        }

        .gauge-fill {
            height: 100%;
            border-radius: 10px;
        }

        .gauge-label {
            font-size: 10.5px;
            color: var(--text-hint);
            margin-top: 3px;
        }

        /* ── Severity badge ────────────────────────────────────── */
        .severity {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11.5px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 6px;
        }

        .severity i {
            font-size: 10px;
        }

        .sev-critical {
            background: var(--red-bg);
            color: var(--red);
            border: 1px solid #f5c6c6;
        }

        .sev-low {
            background: var(--amber-bg);
            color: var(--amber);
            border: 1px solid var(--amber-border);
        }

        .sev-watch {
            background: var(--blue-bg);
            color: var(--blue);
            border: 1px solid #b8d4f5;
        }

        /* ── Pills ─────────────────────────────────────────────── */
        .pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11.5px;
            font-weight: 600;
            padding: 3px 9px;
            border-radius: 20px;
        }

        .pill::before {
            content: '';
            width: 5px;
            height: 5px;
            border-radius: 50%;
        }

        .pill-out {
            background: var(--red-bg);
            color: var(--red);
        }

        .pill-out::before {
            background: var(--red);
        }

        .pill-low {
            background: var(--amber-bg);
            color: var(--amber);
        }

        .pill-low::before {
            background: var(--amber);
        }

        .pill-watch {
            background: var(--blue-bg);
            color: var(--blue);
        }

        .pill-watch::before {
            background: var(--blue);
        }

        /* ── Restock input ─────────────────────────────────────── */
        .restock-input {
            width: 72px;
            height: 30px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 0 8px;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-primary);
            background: var(--surface);
            outline: none;
            font-family: var(--font);
            text-align: center;
            transition: border-color .15s;
        }

        .restock-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(48, 61, 137, .12);
        }

        .btn-restock {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            height: 30px;
            background: var(--green-bg);
            color: var(--green);
            border: 1px solid #b2d8cc;
            border-radius: var(--radius-sm);
            padding: 0 10px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            font-family: var(--font);
            transition: all .15s;
            white-space: nowrap;
        }

        .btn-restock:hover {
            background: var(--green);
            color: #fff;
            border-color: var(--green);
        }

        /* ── Action buttons ────────────────────────────────────── */
        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--text-secondary);
            font-size: 12px;
            cursor: pointer;
            transition: all .12s;
            text-decoration: none;
        }

        .action-btn:hover {
            background: var(--bg);
            color: var(--text-primary);
        }

        .action-btn-view:hover {
            background: var(--blue-bg);
            border-color: #b8d4f5;
            color: var(--blue);
        }

        .action-btn-edit:hover {
            background: var(--accent-light);
            border-color: #c7cdf5;
            color: var(--accent);
        }

        .action-btn-dismiss:hover {
            background: var(--green-bg);
            border-color: #b2d8cc;
            color: var(--green);
        }

        /* ── Tooltip ───────────────────────────────────────────── */
        .action-wrap {
            position: relative;
            display: inline-flex;
        }

        .action-wrap .tooltip-label {
            position: absolute;
            bottom: calc(100% + 6px);
            left: 50%;
            transform: translateX(-50%);
            background: #202223;
            color: #fff;
            font-size: 11px;
            white-space: nowrap;
            padding: 3px 8px;
            border-radius: 5px;
            pointer-events: none;
            opacity: 0;
            transition: opacity .15s;
            z-index: 10;
        }

        .action-wrap:hover .tooltip-label {
            opacity: 1;
        }

        /* ── Last alert time ───────────────────────────────────── */
        .time-cell {
            font-size: 12.5px;
            color: var(--text-secondary);
        }

        .time-cell small {
            display: block;
            font-size: 11.5px;
            color: var(--text-hint);
            margin-top: 1px;
        }

        /* ── Pagination ────────────────────────────────────────── */
        .pag-row {
            padding: 14px 20px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .pag-info {
            font-size: 12.5px;
            color: var(--text-hint);
        }

        /* ── Right sidebar ─────────────────────────────────────── */
        .stock-sidebar-section {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-card);
            overflow: hidden;
            margin-bottom: 16px;
        }

        .sidebar-section:last-child {
            margin-bottom: 0;
        }

        .sidebar-header {
            padding: 13px 18px;
            border-bottom: 1px solid var(--border);
            background: #fafafa;
        }

        .sidebar-header h5 {
            font-size: 13px;
            font-weight: 650;
            color: var(--text-primary);
            margin: 0;
        }

        .sidebar-body {
            padding: 16px 18px;
        }

        /* ── Threshold settings ────────────────────────────────── */
        .threshold-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid var(--bg);
        }

        .threshold-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .threshold-row:first-child {
            padding-top: 0;
        }

        .threshold-label {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-primary);
        }

        .threshold-sub {
            font-size: 11.5px;
            color: var(--text-hint);
            margin-top: 1px;
        }

        .threshold-input {
            width: 64px;
            height: 32px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 0 8px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            text-align: center;
            outline: none;
            font-family: var(--font);
            transition: border-color .15s;
        }

        .threshold-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(48, 61, 137, .12);
        }

        /* ── Notification toggles ──────────────────────────────── */
        .notif-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid var(--bg);
        }

        .notif-row:first-child {
            padding-top: 0;
        }

        .notif-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .notif-label {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-primary);
        }

        .notif-sub {
            font-size: 11.5px;
            color: var(--text-hint);
            margin-top: 1px;
        }

        /* Toggle switch */
        .toggle-switch {
            position: relative;
            width: 36px;
            height: 20px;
            flex-shrink: 0;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-track {
            position: absolute;
            inset: 0;
            background: var(--border);
            border-radius: 20px;
            cursor: pointer;
            transition: background .2s;
        }

        .toggle-track::after {
            content: '';
            position: absolute;
            left: 3px;
            top: 3px;
            width: 14px;
            height: 14px;
            background: #fff;
            border-radius: 50%;
            transition: transform .2s;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .15);
        }

        .toggle-switch input:checked+.toggle-track {
            background: var(--accent);
        }

        .toggle-switch input:checked+.toggle-track::after {
            transform: translateX(16px);
        }

        /* ── Top critical mini-list ────────────────────────────── */
        .critical-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 0;
            border-bottom: 1px solid var(--bg);
        }

        .critical-item:first-child {
            padding-top: 0;
        }

        .critical-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .critical-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .critical-name {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-primary);
            flex: 1;
        }

        .critical-stock {
            font-size: 13px;
            font-weight: 700;
            color: var(--red);
        }

        .critical-stock.amber {
            color: var(--amber);
        }

        /* ── Category breakdown ────────────────────────────────── */
        .cat-breakdown-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 9px 0;
            border-bottom: 1px solid var(--bg);
            font-size: 13px;
        }

        .cat-breakdown-row:first-child {
            padding-top: 0;
        }

        .cat-breakdown-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .cat-breakdown-name {
            color: var(--text-primary);
            font-weight: 500;
        }

        .cat-breakdown-count {
            display: flex;
            gap: 6px;
            align-items: center;
        }

        .mini-pill {
            display: inline-flex;
            align-items: center;
            font-size: 11px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 20px;
        }

        .mini-pill.red {
            background: var(--red-bg);
            color: var(--red);
        }

        .mini-pill.amber {
            background: var(--amber-bg);
            color: var(--amber);
        }

        @media(max-width:768px) {
            .alert-page {
                padding: 16px;
            }

            .filter-row {
                flex-direction: column;
            }

            .filter-control {
                min-width: 100%;
            }
        }
        /* SweetAlert2 customisation */
.swal-stock-popup { font-family: var(--font) !important; border-radius: var(--radius-md) !important; }
.swal2-validation-message { border-radius: var(--radius-sm) !important; font-size: 12.5px !important; }
.swal2-input:focus { border-color: var(--accent) !important; box-shadow: 0 0 0 3px rgba(48,61,137,.12) !important; }
    </style>

    <div class="app-content content container-fluid">
        <div class="alert-page">

            <!-- Page header -->
            <div class="page-header">
                <div>
                    <h1>Stock Alerts</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.stock.index') }}">Stock Management</a>
                        <span>›</span>
                        Stock Alerts
                    </div>
                </div>
                <div style="display:flex;gap:8px;flex-wrap:wrap">
                    <a href="{{ route('admin.stock.alerts.export', request()->query()) }}" class="btn-secondary-dash">
                        <i class="fa fa-download"></i> Export Report
                    </a>

                    <form id="restockAllForm" method="POST" action="{{ route('admin.stock.alerts.restock.all') }}"
                        style="display:inline">
                        @csrf
                        <input type="hidden" name="quantity" id="restockAllQty">

                        <button type="button" class="btn-primary-dash" onclick="restockAllCritical()">
                            <i class="fa fa-refresh"></i> Restock All Critical
                        </button>
                    </form>
                </div>
            </div>

            <!-- KPI strip -->
            <div class="kpi-strip">
                <div class="kpi-tile">
                    <div class="kpi-icon red"><i class="fa fa-times-circle"></i></div>
                    <div>
                        <div class="kpi-label">Out of Stock</div>
                        <div class="kpi-value" style="color:var(--red)">{{ number_format($kpi['critical']) }}</div>
                        <div class="kpi-sub">Needs immediate action</div>
                    </div>
                </div>
                <div class="kpi-tile">
                    <div class="kpi-icon amber"><i class="fa fa-exclamation-triangle"></i></div>
                    <div>
                        <div class="kpi-label">Low Stock</div>
                        <div class="kpi-value" style="color:var(--amber)">{{ number_format($kpi['low']) }}</div>
                        <div class="kpi-sub">Below threshold</div>
                    </div>
                </div>
                <div class="kpi-tile">
                    <div class="kpi-icon purple"><i class="fa fa-eye"></i></div>
                    <div>
                        <div class="kpi-label">Watch List</div>
                        <div class="kpi-value">{{ number_format($kpi['watch']) }}</div>
                        <div class="kpi-sub">Approaching threshold</div>
                    </div>
                </div>
                <div class="kpi-tile">
                    <div class="kpi-icon green"><i class="fa fa-check-circle"></i></div>
                    <div>
                        <div class="kpi-label">Total Alerts</div>
                        <div class="kpi-value" style="color:var(--green)">
                            {{ number_format($kpi['critical'] + $kpi['low'] + $kpi['watch']) }}
                        </div>
                        <div class="kpi-sub">Across all severities</div>
                    </div>
                </div>
            </div>

            <!-- Priority banner (only shown when critical products exist) -->
            @if($kpi['critical'] > 0)
                <div class="priority-banner">
                    <div class="priority-banner-left">
                        <div class="priority-banner-icon"><i class="fa fa-fire"></i></div>
                        <div>
                            <div class="priority-banner-title">
                                🔴 Critical: {{ $kpi['critical'] }} {{ Str::plural('item', $kpi['critical']) }}
                                {{ $kpi['critical'] === 1 ? 'is' : 'are' }} completely out of stock
                            </div>
                            <div class="priority-banner-sub">
                                These products (or specific variants) are live on your store and cannot be purchased.
                                Restock immediately to avoid lost sales.
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('admin.stock.alerts', ['severity' => 'critical']) }}" class="btn-danger-soft"
                        style="flex-shrink:0">
                        <i class="fa fa-bolt"></i> View Critical Only
                    </a>
                </div>
            @endif

            <!-- Main layout -->
            <div class="main-layout">

                <!-- ═══ LEFT: Alert Table ═══ -->
                <div>
                    <div class="section-card">

                        <!-- Status tabs -->
                        <div class="status-tabs">
                            @php
                                $allCount = $kpi['critical'] + $kpi['low'] + $kpi['watch'];
                                $currentSeverity = request('severity', '');
                            @endphp
                            <a href="{{ route('admin.stock.alerts', request()->except(['severity', 'page'])) }}"
                                class="status-tab {{ $currentSeverity === '' ? 'active' : '' }}">
                                All Alerts <span class="tab-count">{{ number_format($allCount) }}</span>
                            </a>
                            <a href="{{ route('admin.stock.alerts', array_merge(request()->except('page'), ['severity' => 'critical'])) }}"
                                class="status-tab {{ $currentSeverity === 'critical' ? 'active' : '' }}">
                                Out of Stock <span class="tab-count red">{{ number_format($kpi['critical']) }}</span>
                            </a>
                            <a href="{{ route('admin.stock.alerts', array_merge(request()->except('page'), ['severity' => 'low'])) }}"
                                class="status-tab {{ $currentSeverity === 'low' ? 'active' : '' }}">
                                Low Stock <span class="tab-count amber">{{ number_format($kpi['low']) }}</span>
                            </a>
                            <a href="{{ route('admin.stock.alerts', array_merge(request()->except('page'), ['severity' => 'watch'])) }}"
                                class="status-tab {{ $currentSeverity === 'watch' ? 'active' : '' }}">
                                Watch List <span class="tab-count">{{ number_format($kpi['watch']) }}</span>
                            </a>
                        </div>

                        <!-- Filter bar -->
                        <form method="GET" action="{{ route('admin.stock.alerts') }}" class="filter-bar">
                            @if(request('severity'))
                                <input type="hidden" name="severity" value="{{ request('severity') }}">
                            @endif
                            <div class="filter-row">
                                <div class="filter-group" style="flex:1">
                                    <label>Search</label>
                                    <input type="text" name="search" class="filter-control" style="min-width:200px"
                                        placeholder="Product name, SKU…" value="{{ request('search') }}">
                                </div>
                                <div class="filter-group">
                                    <label>Category</label>
                                    <select name="category_id" class="filter-control">
                                        <option value="">All Categories</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ (string) request('category_id') === (string) $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <label>Severity</label>
                                    <select name="severity" class="filter-control">
                                        <option value="">All Severities</option>
                                        <option value="critical" {{ request('severity') === 'critical' ? 'selected' : '' }}>Critical (Out of Stock)</option>
                                        <option value="low" {{ request('severity') === 'low' ? 'selected' : '' }}>Low
                                            Stock</option>
                                        <option value="watch" {{ request('severity') === 'watch' ? 'selected' : '' }}>
                                            Watch List</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <label>Sort By</label>
                                    <select name="sort" class="filter-control">
                                        <option value="severity" {{ request('sort', 'severity') === 'severity' ? 'selected' : '' }}>Severity: High First</option>
                                        <option value="stock_asc" {{ request('sort') === 'stock_asc' ? 'selected' : '' }}>
                                            Stock: Low to High</option>
                                        <option value="recent" {{ request('sort') === 'recent' ? 'selected' : '' }}>Most
                                            Recent Alert</option>
                                        <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>
                                            Product Name A–Z</option>
                                    </select>
                                </div>
                                <div style="display:flex;gap:8px;align-items:flex-end">
                                    <button type="submit" class="btn-filter"><i class="fa fa-search"></i>
                                        Filter</button>
                                    <a href="{{ route('admin.stock.alerts') }}" class="btn-filter-reset">
                                        <i class="fa fa-refresh"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </form>

                        <!-- Table -->
                        <div class="table-wrap">
                            <table class="alert-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product</th>
                                        <th>Category</th>
                                        <th>Stock vs Min</th>
                                        <th>Severity</th>
                                        <th>Last Updated</th>
                                        <th>Quick Restock</th>
                                        <th style="width:110px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($products as $line)
                                        @php
                                            $sev = $line['severity'];
                                            $isVariant = $line['kind'] === 'variant';

                                            $rowClass = match ($sev) { 'critical' => 'row-critical', 'low' => 'row-low', default => ''};
                                            $sevClass = match ($sev) { 'critical' => 'sev-critical', 'low' => 'sev-low', default => 'sev-watch'};
                                            $sevIcon = match ($sev) { 'critical' => 'fa-circle', 'low' => 'fa-exclamation-triangle', default => 'fa-eye'};
                                            $sevLabel = match ($sev) { 'critical' => 'Critical', 'low' => 'Low Stock', default => 'Watch'};
                                            $barColor = match ($sev) { 'critical' => 'var(--red)', 'low' => 'var(--amber)', default => 'var(--blue)'};
                                            $stockColor = $barColor;

                                            $threshold = match ($sev) { 'critical' => max($critical, 1), 'low' => $low, default => $watch};
                                            $barWidth = $threshold > 0
                                                ? min(100, round(($line['stock'] / $threshold) * 100))
                                                : 0;

                                            $gaugeLabel = match ($sev) {
                                                'critical' => '0% of threshold',
                                                'watch' => 'Slightly above threshold',
                                                default => round((1 - $line['stock'] / max($low, 1)) * 100) . '% depleted',
                                            };

                                            $restockUrl = $isVariant
                                                ? route('admin.stock.alerts.variant.restock', $line['variant'])
                                                : route('admin.stock.alerts.restock', $line['product']);
                                        @endphp
                                        <tr class="{{ $rowClass }}" data-product-id="{{ $line['id'] }}">
                                            <td><span class="id-chip">{{ $line['id'] }}</span></td>
                                            <td>
                                                <div style="display:flex;align-items:center;gap:10px">
                                                    <img src="{{ $line['image'] ?? 'https://placehold.co/46x46/e8f2ff/0069d9?text=P' }}"
                                                        class="prod-thumb" alt="">
                                                    <div>
                                                        <div class="prod-name">
                                                            {{ $line['display_name'] }}
                                                            @if($isVariant)
                                                                <span style="font-weight:500;color:var(--text-hint)"> — {{ $line['sub_label'] }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="prod-meta">
                                                            {{ $line['sku'] }} · CODE: {{ $line['product_code'] }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="cat-tag">
                                                    <i class="fa fa-folder-o" style="font-size:10px"></i>
                                                    {{ $line['category']->name ?? 'Uncategorized' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="gauge-wrap">
                                                    <div class="gauge-numbers">
                                                        <span class="gauge-current"
                                                            style="color:{{ $stockColor }}">{{ $line['stock'] }}</span>
                                                        <span class="gauge-divider">/</span>
                                                        <span class="gauge-min">{{ $line['min_qty'] }}</span>
                                                    </div>
                                                    <div class="gauge-bar">
                                                        <div class="gauge-fill"
                                                            style="width:{{ $barWidth }}%;background:{{ $barColor }}"></div>
                                                    </div>
                                                    <div class="gauge-label">{{ $gaugeLabel }}</div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="severity {{ $sevClass }}">
                                                    <i class="fa {{ $sevIcon }}"></i> {{ $sevLabel }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="time-cell">
                                                    {{ $line['updated_at']->format('d M Y') }}
                                                    <small>{{ $line['updated_at']->format('g:i A') }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div style="display:flex;gap:6px;align-items:center">
                                                    <input type="number" min="1" class="restock-input" placeholder="Qty"
                                                        value="10">
                                                    <button class="btn-restock"
                                                        data-action="{{ $restockUrl }}"
                                                        onclick="handleRestock(this)">
                                                        <i class="fa fa-plus"></i> Add
                                                    </button>
                                                </div>
                                            </td>
                                            <td>
                                                <div style="display:flex;gap:5px">
                                                    <div class="action-wrap">
                                                        <a href="{{ route('admin.products.edit', $line['product']->id) }}"
                                                            class="action-btn action-btn-view"><i class="fa fa-eye"></i></a>
                                                        <span class="tooltip-label">View Product</span>
                                                    </div>
                                                    <div class="action-wrap">
                                                        <a href="{{ route('admin.stock.index', ['search' => $line['sku']]) }}"
                                                            class="action-btn action-btn-edit">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                        <span class="tooltip-label">Edit Stock</span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" style="text-align:center;padding:40px;color:var(--text-hint)">
                                                <i class="fa fa-check-circle"
                                                    style="font-size:24px;color:var(--green);display:block;margin-bottom:8px"></i>
                                                No alerts match these filters.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="pag-row">
                            <div class="pag-info">
                                Showing {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}
                                of {{ number_format($products->total()) }} alerts
                            </div>
                            <nav>{{ $products->onEachSide(1)->links() }}</nav>
                        </div>

                    </div>
                </div>

                <!-- ═══ RIGHT: Sidebar ═══ -->
                <div>

                    <!-- Top Critical Items -->
                    <div class="sidebar-section">
                        <div class="sidebar-header">
                            <h5>🔴 Most Critical</h5>
                        </div>
                        <div class="sidebar-body">
                            @forelse($topCritical as $item)
                                @php $isCritical = $item['severity'] === 'critical'; @endphp
                                <div class="critical-item">
                                    <div class="critical-dot"
                                        style="background:{{ $isCritical ? 'var(--red)' : 'var(--amber)' }}"></div>
                                    <span class="critical-name">
                                        {{ Str::limit($item['display_name'] . ($item['sub_label'] ? ' — ' . $item['sub_label'] : ''), 22) }}
                                    </span>
                                    <span class="critical-stock {{ $isCritical ? '' : 'amber' }}">
                                        {{ $item['stock'] }} left
                                    </span>
                                </div>
                            @empty
                                <div style="font-size:13px;color:var(--text-hint);text-align:center;padding:10px 0">
                                    No critical items 🎉
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Alerts by Category -->
                    <div class="sidebar-section">
                        <div class="sidebar-header">
                            <h5>Alerts by Category</h5>
                        </div>
                        <div class="sidebar-body">
                            @forelse($byCategory as $cat)
                                <div class="cat-breakdown-row">
                                    <span class="cat-breakdown-name">{{ $cat->name }}</span>
                                    <div class="cat-breakdown-count">
                                        @if($cat->critical_count > 0)
                                            <span class="mini-pill red">{{ $cat->critical_count }} critical</span>
                                        @endif
                                        @if($cat->low_count > 0)
                                            <span class="mini-pill amber">{{ $cat->low_count }} low</span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div style="font-size:13px;color:var(--text-hint)">No category data.</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Alert Thresholds -->
                    <div class="sidebar-section">
                        <div class="sidebar-header">
                            <h5>Alert Thresholds</h5>
                        </div>
                        <div class="sidebar-body">
                            <form method="POST" action="{{ route('admin.stock.alerts.thresholds') }}"
                                id="thresholdForm">
                                @csrf
                                <div class="threshold-row">
                                    <div>
                                        <div class="threshold-label">Critical Threshold</div>
                                        <div class="threshold-sub">Immediate action needed</div>
                                    </div>
                                    <input type="number" name="critical_threshold" class="threshold-input"
                                        value="{{ $settings->critical_threshold }}" min="0">
                                </div>
                                <div class="threshold-row">
                                    <div>
                                        <div class="threshold-label">Low Stock Threshold</div>
                                        <div class="threshold-sub">Alert when stock falls below</div>
                                    </div>
                                    <input type="number" name="low_stock_threshold" class="threshold-input"
                                        value="{{ $settings->low_stock_threshold }}" min="0">
                                </div>
                                <div class="threshold-row">
                                    <div>
                                        <div class="threshold-label">Watch List Threshold</div>
                                        <div class="threshold-sub">Monitor when approaching</div>
                                    </div>
                                    <input type="number" name="watch_list_threshold" class="threshold-input"
                                        value="{{ $settings->watch_list_threshold }}" min="0">
                                </div>
                                <div style="margin-top:14px">
                                    <button type="submit" class="btn-primary-dash"
                                        style="width:100%;justify-content:center;font-size:13px" id="saveThresholdsBtn">
                                        <i class="fa fa-save"></i> Save Thresholds
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Notification Preferences -->
                    <div class="sidebar-section">
                        <div class="sidebar-header">
                            <h5>Notifications</h5>
                        </div>
                        <div class="sidebar-body">
                            <form method="POST" action="{{ route('admin.stock.alerts.notifications') }}" id="notifForm">
                                @csrf
                                <div class="notif-row">
                                    <div>
                                        <div class="notif-label">Email Alerts</div>
                                        <div class="notif-sub">Send to admin email</div>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="notify_email" value="1" {{ $settings->notify_email ? 'checked' : '' }} onchange="submitNotifForm()">
                                        <span class="toggle-track"></span>
                                    </label>
                                </div>
                                <div class="notif-row">
                                    <div>
                                        <div class="notif-label">Dashboard Banner</div>
                                        <div class="notif-sub">Show on admin dashboard</div>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="notify_dashboard" value="1" {{ $settings->notify_dashboard ? 'checked' : '' }}
                                            onchange="submitNotifForm()">
                                        <span class="toggle-track"></span>
                                    </label>
                                </div>
                                <div class="notif-row">
                                    <div>
                                        <div class="notif-label">Auto-Disable Listings</div>
                                        <div class="notif-sub">Hide product when out of stock</div>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="auto_disable_out_of_stock" value="1" {{ $settings->auto_disable_out_of_stock ? 'checked' : '' }}
                                            onchange="submitNotifForm()">
                                        <span class="toggle-track"></span>
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <!-- /right sidebar -->

            </div><!-- /main-layout -->

        </div>
    </div>
</div>

@include('admin.footer')

<script>
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content;

    // Quick restock — fetch() so row updates without reload
    async function handleRestock(btn) {
        const input = btn.closest('div').querySelector('.restock-input');
        const qty = parseInt(input.value);
        const row = btn.closest('tr');
        const action = btn.dataset.action;
        const orig = btn.innerHTML;

        if (!qty || qty < 1) {
            input.focus();
            return;
        }

        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
        btn.disabled = true;

        try {
            const res = await fetch(action, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify({ quantity: qty }),
            });

            if (!res.ok) throw new Error();
            const data = await res.json();

            btn.innerHTML = '<i class="fa fa-check"></i> Done!';
            btn.style.cssText = 'background:var(--green);color:#fff;border-color:var(--green)';

            // If product is now in stock, fade the row out of the alerts list
            if (data.severity === 'in_stock') {
                setTimeout(() => {
                    row.style.transition = 'opacity .5s, transform .5s';
                    row.style.opacity = '0';
                    row.style.transform = 'translateX(20px)';
                    setTimeout(() => row.remove(), 500);
                }, 800);
            }
        } catch {
            btn.innerHTML = '<i class="fa fa-times"></i> Failed';
            btn.style.cssText = 'background:var(--red-bg);color:var(--red);border-color:var(--red)';
        }

        setTimeout(() => {
            if (btn.isConnected) {
                btn.innerHTML = orig;
                btn.style.cssText = '';
                btn.disabled = false;
            }
        }, 2000);
    }

    // Notification toggles — auto-submit on change
    function submitNotifForm() {
        document.getElementById('notifForm').submit();
    }

    // Threshold form — visual feedback on success flash
    @if(session('success'))
        const saveBtn = document.getElementById('saveThresholdsBtn');
        if (saveBtn) {
            const orig = saveBtn.innerHTML;
            saveBtn.innerHTML = '<i class="fa fa-check"></i> Saved!';
            saveBtn.style.background = 'var(--green)';
            setTimeout(() => { saveBtn.innerHTML = orig; saveBtn.style.background = ''; }, 2000);
        }
    @endif
</script>
<script>
function restockAllCritical() {
    @if($kpi['critical'] === 0)
        Swal.fire({
            icon: 'success',
            title: 'All Clear!',
            text: 'There are no critical products to restock.',
            confirmButtonColor: '#303d89',
        });
        return;
    @endif

    Swal.fire({
        title: 'Restock All Critical',
        html: `
            <div style="text-align:left;font-family:'Inter',sans-serif">
                <div style="background:#fce8e8;border:1px solid #f5c6c6;border-radius:8px;padding:12px 14px;margin-bottom:16px;display:flex;align-items:center;gap:10px">
                    <i class="fa fa-exclamation-circle" style="color:#b22222;font-size:16px;flex-shrink:0"></i>
                    <div>
                        <div style="font-size:13px;font-weight:600;color:#b22222">{{ $kpi['critical'] }} critical {{ Str::plural('item', $kpi['critical']) }} will be restocked</div>
                        <div style="font-size:12px;color:#6d7175;margin-top:2px">Stock will be credited to each item immediately</div>
                    </div>
                </div>
                <label style="font-size:12px;font-weight:600;color:#6d7175;text-transform:uppercase;letter-spacing:.04em;display:block;margin-bottom:6px">
                    Units to add per item
                </label>
                <input id="swal-qty-input" type="number" min="1" value="10" class="swal2-input"
                    style="width:100%;margin:0;font-size:20px;font-weight:700;text-align:center;border-color:#e3e5e8;border-radius:8px">
                <div style="font-size:11.5px;color:#8c9196;margin-top:8px;text-align:center">
                    This quantity will be added on top of each item's current stock
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: '<i class="fa fa-refresh"></i> Restock Now',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#303d89',
        cancelButtonColor: '#e3e5e8',
        reverseButtons: true,
        focusConfirm: false,
        customClass: {
            cancelButton: 'swal-cancel-btn',
            popup: 'swal-stock-popup',
        },
        didOpen: () => {
            // Style the cancel button text dark since it has a light bg
            const cancelBtn = Swal.getCancelButton();
            if (cancelBtn) cancelBtn.style.color = '#202223';
        },
        preConfirm: () => {
            const val = parseInt(document.getElementById('swal-qty-input').value);
            if (!val || val < 1) {
                Swal.showValidationMessage('<i class="fa fa-exclamation-triangle"></i> Please enter a quantity of at least 1');
                return false;
            }
            return val;
        }
    }).then((result) => {
        if (!result.isConfirmed) return;

        // Second confirmation
        Swal.fire({
            icon: 'warning',
            title: 'Are you sure?',
            html: `
                <div style="font-family:'Inter',sans-serif;font-size:13px;color:#6d7175">
                    You are about to add <strong style="color:#202223;font-size:15px">${result.value} units</strong>
                    to each of the <strong style="color:#b22222">{{ $kpi['critical'] }} critical</strong> items.<br><br>
                    This action will be logged in stock history and <strong>cannot be undone</strong>.
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Yes, Restock All',
            cancelButtonText: 'Go Back',
            confirmButtonColor: '#007a5e',
            cancelButtonColor: '#e3e5e8',
            reverseButtons: true,
            didOpen: () => {
                const cancelBtn = Swal.getCancelButton();
                if (cancelBtn) cancelBtn.style.color = '#202223';
            }
        }).then((confirm) => {
            if (!confirm.isConfirmed) return;

            // Show loading
            Swal.fire({
                title: 'Restocking…',
                html: '<div style="font-family:Inter,sans-serif;font-size:13px;color:#6d7175">Please wait while stock is being updated.</div>',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => Swal.showLoading(),
            });

            document.getElementById('restockAllQty').value = result.value;
            document.getElementById('restockAllForm').submit();
        });
    });
}
</script>

@if(session('success') && str_contains(session('success'), 'critical'))
<script>
    document.addEventListener('DOMContentLoaded', () => {
        Swal.fire({
            icon: 'success',
            title: 'Restocked!',
            text: '{{ session('success') }}',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            customClass: { popup: 'swal-stock-popup' },
        });
    });
</script>
@endif