@extends('layouts.master')

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    /* ============================================================
       DESIGN TOKENS
    ============================================================ */
    .jo-page {
        --ink:        #1F2A44;
        --ink-2:      #2C3A57;
        --ink-soft:   #4A5568;
        --muted:      #7A8599;
        --line:       #E3E7EE;
        --line-soft:  #EEF1F5;
        --surface:    #FFFFFF;
        --canvas:     #F5F7FA;
        --accent:     #2F5DA8;
        --accent-dk:  #244A87;
        --accent-bg:  #EAF0F9;

        --ok:   #1E7F4F;  --ok-bg:   #E6F4EC;
        --warn: #A86A12;  --warn-bg: #FBF1E1;
        --bad:  #B42318;  --bad-bg:  #FDECEA;

        --radius-lg: 10px;
        --radius:    6px;

        font-family: 'IBM Plex Sans', 'Segoe UI', Tahoma, Arial, sans-serif;
        color: var(--ink);
    }

    .jo-page .num { font-variant-numeric: tabular-nums; }

    /* ============================================================
       PAGE HEADER
    ============================================================ */
    .jo-page .page-head {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 16px;
        padding: 20px 24px; margin-bottom: 20px;
        background: var(--ink);
        border-radius: var(--radius-lg);
        border-bottom: 3px solid var(--accent);
        color: #fff;
    }
    .jo-page .page-head .head-main { display: flex; align-items: center; gap: 16px; }
    .jo-page .page-head .head-icon {
        width: 46px; height: 46px; border-radius: 10px; flex-shrink: 0;
        background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.14);
        display: flex; align-items: center; justify-content: center;
        font-size: 20px; color: #fff;
    }
    .jo-page .page-head h1 { font-size: 22px; font-weight: 600; margin: 0 0 3px; letter-spacing: -0.2px; color: #fff; }
    .jo-page .page-head p  { margin: 0; font-size: 13px; color: #B7C0D1; }
    .jo-page .page-head .breadcrumb {
        background: rgba(255,255,255,.08); padding: 6px 12px; margin: 0;
        border-radius: 999px; font-size: 12px;
    }
    .jo-page .page-head .breadcrumb > li + li:before { color: #6F7C96; }
    .jo-page .page-head .breadcrumb a { color: #B7C0D1; }
    .jo-page .page-head .breadcrumb a:hover { color: #fff; text-decoration: none; }
    .jo-page .page-head .breadcrumb > .active { color: #fff; }

    /* ============================================================
       PANELS
    ============================================================ */
    .jo-page .panel-box {
        background: var(--surface); border: 1px solid var(--line);
        border-radius: var(--radius-lg); margin-bottom: 20px;
    }
    .jo-page .panel-box-head {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 12px; padding: 14px 20px; border-bottom: 1px solid var(--line);
    }
    .jo-page .panel-box-head h3 { margin: 0; font-size: 15px; font-weight: 600; }
    .jo-page .panel-box-body { padding: 20px; }

    .jo-page .alert { border-radius: var(--radius); border: 1px solid transparent; border-left-width: 4px; font-size: 13px; padding: 12px 16px; }
    .jo-page .alert-success { background: var(--ok-bg);  color: var(--ok);  border-color: var(--ok); }
    .jo-page .alert-danger  { background: var(--bad-bg); color: var(--bad); border-color: var(--bad); }

    /* ============================================================
       FORM CONTROLS
    ============================================================ */
    .jo-page label { display: block; font-size: 12px; font-weight: 500; color: var(--ink-soft); margin-bottom: 6px; }
    .jo-page .form-control {
        height: 38px; border-radius: var(--radius); border: 1px solid var(--line);
        background: var(--surface); font-size: 13px; color: var(--ink);
        padding: 6px 12px; box-shadow: none;
        transition: border-color .15s ease, box-shadow .15s ease;
    }
    .jo-page .form-control:focus { border-color: var(--accent); box-shadow: 0 0 0 3px var(--accent-bg); outline: none; }
    .jo-page .form-control:disabled { background: var(--canvas); color: var(--muted); }
    .jo-page .help-block { font-size: 12px; }

    /* bootstrap-select: remove the wrapper box so only one input shows */
    .jo-page .bootstrap-select.form-control {
        border: 0 !important; padding: 0 !important; height: auto !important;
        background: transparent !important; box-shadow: none !important; width: 100% !important;
    }
    .jo-page .bootstrap-select > .dropdown-toggle {
        width: 100%; height: 38px; padding: 6px 32px 6px 12px;
        border-radius: var(--radius) !important; border: 1px solid var(--line) !important;
        background: var(--surface) !important; box-shadow: none !important;
        color: var(--ink) !important; font-size: 13px; font-weight: 400; text-align: left;
    }
    .jo-page .bootstrap-select > .dropdown-toggle:focus,
    .jo-page .bootstrap-select.open > .dropdown-toggle {
        border-color: var(--accent) !important; box-shadow: 0 0 0 3px var(--accent-bg) !important; outline: none !important;
    }
    .jo-page .bootstrap-select .filter-option { padding: 0 !important; line-height: 24px; }
    .jo-page .bootstrap-select .dropdown-menu {
        border-radius: var(--radius); border: 1px solid var(--line);
        box-shadow: 0 8px 24px rgba(31, 42, 68, 0.12); font-size: 13px;
    }
    .jo-page .bootstrap-select .dropdown-menu > li.selected > a { background: var(--accent-bg); color: var(--accent-dk); }
    .jo-page .bootstrap-select ~ .select2-container { display: none !important; }

    .jo-page .filter-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)) auto; gap: 16px; align-items: end; }
    .jo-page .filter-grid .form-group { margin: 0; }
    /* status text sits inside the label row, so nothing below the fields moves */
    .jo-page .label-meta { font-weight: 400; color: var(--muted); margin-left: 6px; }
    .jo-page .label-meta.err { color: var(--bad); font-weight: 500; }
    .jo-page .label-meta.ok  { color: var(--ok); }
    .jo-page .form-control.is-invalid { border-color: var(--bad); box-shadow: 0 0 0 3px var(--bad-bg); }
    @media (max-width: 991px) {
        .jo-page .filter-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .jo-page .filter-grid .filter-action { grid-column: 1 / -1; }
    }
    @media (max-width: 575px) { .jo-page .filter-grid { grid-template-columns: 1fr; } }

    /* ============================================================
       BUTTONS
    ============================================================ */
    .jo-page .btn {
        border-radius: var(--radius); font-size: 13px; font-weight: 500;
        padding: 8px 16px; border: 1px solid transparent; box-shadow: none;
        transition: background-color .15s ease, border-color .15s ease, color .15s ease;
    }
    .jo-page .btn:focus-visible { outline: 2px solid var(--accent); outline-offset: 2px; }
    .jo-page .btn[disabled] { opacity: .55; cursor: not-allowed; }
    .jo-page .btn-primary-jo { background: var(--accent); border-color: var(--accent); color: #fff; }
    .jo-page .btn-primary-jo:hover { background: var(--accent-dk); border-color: var(--accent-dk); color: #fff; }
    .jo-page .btn-ok { background: var(--ok); border-color: var(--ok); color: #fff; }
    .jo-page .btn-ok:hover { background: #17673F; border-color: #17673F; color: #fff; }
    .jo-page .btn-ghost { background: var(--surface); border-color: var(--line); color: var(--ink-soft); }
    .jo-page .btn-danger-jo { background: var(--bad); border-color: var(--bad); color: #fff; }
    .jo-page .btn-danger-jo:hover, .jo-page .btn-danger-jo:focus { background: #912018; border-color: #912018; color: #fff; }
    .jo-page .btn-ghost:hover { background: var(--canvas); color: var(--ink); }
    .jo-page .btn-search {
        height: 38px; width: 132px;               /* fixed: label swap can't resize the filter row */
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
    }

    /* ============================================================
       LOADING
       Overlay sits on top of the existing rows instead of replacing
       them, so the page height doesn't collapse and re-grow.
       Spinner is pure CSS outside the scroll box, so its rotation
       can never toggle scrollbars.
    ============================================================ */
    .jo-page .table-area { position: relative; }
    .jo-page .table-area.is-loading .table-scroll { min-height: 220px; overflow: hidden; }
    .jo-page .table-loading {
        position: absolute; inset: 0; z-index: 6;
        display: flex; align-items: flex-start; justify-content: center;
        padding-top: 90px;
        background: rgba(255, 255, 255, .7);
        contain: layout paint;
    }
    .jo-page .table-loading[hidden] { display: none; }
    .jo-page .loader-box {
        display: inline-flex; align-items: center; gap: 12px;
        padding: 12px 18px; border-radius: var(--radius);
        background: #fff; border: 1px solid var(--line);
        box-shadow: 0 6px 18px rgba(31, 42, 68, .10);
        font-size: 13px; font-weight: 500; color: var(--ink);
    }
    .jo-page .spinner {
        display: inline-block; flex-shrink: 0;
        width: 20px; height: 20px; border-radius: 50%;
        border: 2.5px solid var(--accent-bg); border-top-color: var(--accent);
        animation: jo-spin .75s linear infinite;
    }
    .jo-page .btn .spinner { width: 14px; height: 14px; border-width: 2px; border-color: rgba(255,255,255,.35); border-top-color: #fff; }
    @keyframes jo-spin { to { transform: rotate(360deg); } }
    @media (prefers-reduced-motion: reduce) { .jo-page .spinner { animation-duration: 2s; } }
    .jo-page .btn-row { padding: 4px 10px; font-size: 12px; line-height: 1.5; }
    .jo-page .link-btn { background: none; border: 0; padding: 0; color: var(--accent); font-size: 12.5px; font-weight: 500; cursor: pointer; }
    .jo-page .link-btn:hover { text-decoration: underline; }

    /* ============================================================
       TABLE TOOLBAR
    ============================================================ */
    .jo-page .table-toolbar { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; width: 100%; }
    .jo-page .search-box { position: relative; width: 280px; max-width: 100%; }
    .jo-page .search-box .fa { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--muted); font-size: 13px; pointer-events: none; }
    .jo-page .search-box input {
        width: 100%; height: 36px; border-radius: var(--radius); border: 1px solid var(--line);
        padding: 0 12px 0 34px; font-size: 13px; color: var(--ink);
    }
    .jo-page .search-box input:focus { border-color: var(--accent); box-shadow: 0 0 0 3px var(--accent-bg); outline: none; }
    .jo-page .result-meta { font-size: 13px; color: var(--muted); }
    .jo-page .result-meta strong { color: var(--ink); font-weight: 600; }

    /* ============================================================
       MAIN TABLE
    ============================================================ */
    .jo-page .table-scroll { overflow: auto; max-height: 70vh; border-top: 1px solid var(--line); }
    .jo-page .table-jo { width: 100%; margin: 0; border-collapse: separate; border-spacing: 0; font-size: 12.5px; }
    .jo-page .table-jo thead th {
        position: sticky; top: 0; z-index: 3;
        background: var(--canvas); color: var(--ink-soft);
        font-size: 12px; font-weight: 600; padding: 10px 12px;
        border-bottom: 1px solid var(--line); white-space: nowrap; text-align: left; vertical-align: bottom;
    }
    .jo-page .table-jo thead tr.group-row th { padding-top: 8px; padding-bottom: 4px; border-bottom: none; color: var(--muted); }
    .jo-page .table-jo thead tr.group-row th.plan-group { color: var(--ink); text-align: center; border-bottom: 2px solid var(--ink); }
    .jo-page .table-jo thead tr.label-row th { top: 29px; }
    .jo-page .table-jo .text-right  { text-align: right; }
    .jo-page .table-jo .text-center { text-align: center; }
    .jo-page .table-jo .plan-col { background: #FAFBFD; }
    .jo-page .table-jo thead th.plan-col { background: #EFF2F7; }
    .jo-page .table-jo .plan-first { border-left: 1px solid var(--line); }
    .jo-page .table-jo .plan-last  { border-right: 1px solid var(--line); }

    .jo-page .table-jo tbody td {
        padding: 10px 12px; border-bottom: 1px solid var(--line-soft);
        vertical-align: middle; white-space: nowrap;
    }
    /* explicit backgrounds so layout-level row striping doesn't leak in */
    .jo-page .table-jo tbody tr.jo-row td { background: #fff; }
    .jo-page .table-jo tbody tr.jo-row td.plan-col { background: #FAFBFD; }
    .jo-page .table-jo tbody tr.jo-row:hover td { background: #F7F9FC; }
    .jo-page .table-jo tbody tr.jo-row.is-active td { background: var(--accent-bg); }

    /* stacked cells: main value on top, supporting detail below */
    .jo-page .table-jo .stack { display: flex; flex-direction: column; gap: 3px; }
    .jo-page .table-jo .stack .main { font-weight: 600; color: var(--ink); }
    .jo-page .table-jo .stack .sub  { font-size: 11.5px; color: var(--muted); display: inline-flex; align-items: center; gap: 5px; }
    .jo-page .table-jo .stack .sub .fa { font-size: 11px; width: 12px; text-align: center; color: #A3ACBB; }
    .jo-page .table-jo td.party { white-space: normal; min-width: 210px; max-width: 280px; }
    .jo-page .table-jo td.party .main { line-height: 1.35; }

    /* Floor column */
    .jo-page .floor-tag {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 3px 9px; border-radius: 4px;
        background: var(--canvas); border: 1px solid var(--line);
        font-size: 12px; white-space: nowrap;
    }
    .jo-page .floor-tag b { font-weight: 700; color: var(--ink); font-variant-numeric: tabular-nums; }
    .jo-page .floor-tag span { color: var(--ink-soft); font-weight: 500; }

    .jo-page .state {
        display: inline-block; padding: 1px 8px; border-radius: 4px;
        font-size: 12px; font-weight: 600; border: 1px solid var(--line); color: var(--ink-soft);
    }
    .jo-page .state.ok     { color: var(--ok);  border-color: #BFE0CD; background: var(--ok-bg); }
    .jo-page .state.cancel { color: var(--bad); border-color: #F3C3BE; background: var(--bad-bg); }
    .jo-page .table-jo td.jo-no { font-weight: 600; }
    .jo-page .table-jo td.cell-muted { color: var(--ink-soft); }
    .jo-page .table-jo td.capacity-cell  { font-weight: 600; }
    .jo-page .table-jo td.allocated-cell { font-weight: 600; color: var(--ok); }
    .jo-page .table-jo td.pending-cell   { font-weight: 600; color: var(--bad); }
    .jo-page .table-jo td.pending-cell.is-zero { color: var(--muted); font-weight: 500; }
    .jo-page .col-view { width: 44px; padding-right: 0 !important; }

    /* View-lines icon button (first column) */
    .jo-page .view-btn {
        width: 30px; height: 30px; border-radius: 50%;
        border: 1px solid var(--accent); background: var(--accent); color: #fff;
        display: inline-flex; align-items: center; justify-content: center;
        cursor: pointer; padding: 0; font-size: 13px;
        transition: background-color .15s ease, box-shadow .15s ease;
    }
    .jo-page .view-btn:hover { background: var(--accent-dk); box-shadow: 0 0 0 4px var(--accent-bg); }
    .jo-page .view-btn:focus-visible { outline: 2px solid var(--accent); outline-offset: 2px; }

    /* Pills */
    .jo-page .pill {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 2px 10px; border-radius: 999px; font-size: 12px; font-weight: 500; line-height: 1.6;
        background: var(--canvas); color: var(--ink-soft); border: 1px solid var(--line); white-space: nowrap;
    }
    .jo-page .pill::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
    .jo-page .pill.full,    .jo-page .pill.status-full    { background: var(--ok-bg);   color: var(--ok);   border-color: transparent; }
    .jo-page .pill.partial, .jo-page .pill.status-partial { background: var(--warn-bg); color: var(--warn); border-color: transparent; }
    .jo-page .pill.pending, .jo-page .pill.status-pending { background: var(--bad-bg);  color: var(--bad);  border-color: transparent; }
    .jo-page .pill.received { background: var(--ink); color: #fff; border-color: transparent; }

    .jo-page .row-actions { display: inline-flex; gap: 6px; }
    .jo-page .row-actions a { text-decoration: none; }

    /* Report buttons: own colours, kept clear of the status greens/reds/ambers */
    .jo-page .btn-report {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 11px; font-size: 12px; font-weight: 600; line-height: 1.5;
        border-radius: var(--radius); border: 1px solid;
    }
    .jo-page .btn-report .fa { font-size: 12px; }

    .jo-page .btn-report-jo { color: var(--accent);  background: var(--accent-bg); border-color: #C7D6EE; }
    .jo-page .btn-report-jo:hover,
    .jo-page .btn-report-jo:focus { color: #fff; background: var(--accent); border-color: var(--accent); }

    .jo-page .btn-report-sc { color: #5B3E96; background: #F1ECF8; border-color: #D9CCEE; }
    .jo-page .btn-report-sc:hover,
    .jo-page .btn-report-sc:focus { color: #fff; background: #5B3E96; border-color: #5B3E96; }

    .jo-page .empty-state td {
        padding: 56px 20px !important; text-align: center; white-space: normal !important;
        color: var(--muted); background: var(--surface) !important;
    }
    .jo-page .empty-state .fa { font-size: 28px; color: #C3CAD6; display: block; margin-bottom: 10px; }
    .jo-page .empty-state strong { display: block; color: var(--ink); font-weight: 600; margin-bottom: 4px; font-size: 14px; }

    /* ============================================================
       LINES MODAL
    ============================================================ */
    .jo-page .jo-modal .modal-dialog { width: 96vw; max-width: 1640px; margin: 16px auto; padding: 0; }
    @media (max-width: 767px) { .jo-page .jo-modal .modal-dialog { width: auto; margin: 10px; } }
    .jo-page .jo-modal .modal-content {
        border-radius: var(--radius-lg); border: none; overflow: hidden;
        box-shadow: 0 24px 56px rgba(31, 42, 68, 0.22);
    }

    /* Steel-blue header so the modal stands apart from the navy page header,
       the dark backdrop and the navy item-table head */
    .jo-page .jo-modal .modal-header {
        background: var(--accent); color: #fff; padding: 16px 24px;
        border-bottom: 3px solid var(--accent-dk);
    }
    .jo-page .jo-modal .modal-header .close { color: #fff; opacity: .85; font-size: 26px; text-shadow: none; margin-top: 0; }
    .jo-page .jo-modal .modal-header .close:hover { opacity: 1; }
    .jo-page .jo-modal .modal-title { font-size: 17px; font-weight: 600; display: flex; align-items: center; gap: 10px; flex-wrap: wrap; color: #fff; }
    .jo-page .jo-modal .demo-tag {
        font-size: 11px; font-weight: 600; padding: 1px 8px; border-radius: 999px;
        background: #FBF1E1; color: var(--warn);
    }
    /* header facts as chips: easier to scan than one long line */
    .jo-page .jo-modal .modal-sub { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 10px; font-size: 12.5px; color: #DCE6F6; }
    .jo-page .jo-modal .modal-sub > span {
        padding: 3px 10px; border-radius: 999px;
        background: rgba(255, 255, 255, .14); border: 1px solid rgba(255, 255, 255, .18);
    }
    .jo-page .jo-modal .modal-sub b { color: #fff; font-weight: 600; margin-left: 2px; }

    .jo-page .jo-modal .modal-body { padding: 0; }

    /* Coverage strip: the one visual signal of the modal */
    .jo-page .coverage-strip {
        display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)) 1.6fr;
        gap: 0; border-bottom: 1px solid var(--line);
    }
    .jo-page .coverage-strip > div { padding: 14px 20px; border-right: 1px solid var(--line-soft); }
    .jo-page .coverage-strip > div:last-child { border-right: 0; }
    .jo-page .coverage-strip .lbl { display: block; font-size: 12px; color: var(--muted); margin-bottom: 2px; }
    .jo-page .coverage-strip .val { font-size: 18px; font-weight: 600; color: var(--ink); }
    .jo-page .coverage-strip .val small { font-size: 12px; font-weight: 500; color: var(--muted); margin-left: 3px; }
    .jo-page .coverage-strip .val.ok  { color: var(--ok); }
    .jo-page .coverage-strip .val.bad { color: var(--bad); }

    .jo-page .coverage-meter .meter-head { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 8px; }
    .jo-page .coverage-meter .pct { font-size: 18px; font-weight: 700; }
    .jo-page .coverage-bar { height: 8px; border-radius: 999px; background: var(--bad-bg); overflow: hidden; display: flex; }
    .jo-page .coverage-bar .seg-received { background: var(--ink); height: 100%; transition: width .25s ease; }
    .jo-page .coverage-bar .seg-planned  { background: var(--ok);  height: 100%; transition: width .25s ease; }
    .jo-page .coverage-legend { display: flex; gap: 14px; margin-top: 8px; font-size: 11.5px; color: var(--muted); }
    .jo-page .coverage-legend i { display: inline-block; width: 8px; height: 8px; border-radius: 2px; margin-right: 5px; vertical-align: 0; }

    @media (max-width: 991px) {
        .jo-page .coverage-strip { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .jo-page .coverage-strip .coverage-meter { grid-column: 1 / -1; }
    }

    /* Controls row */
    .jo-page .lines-controls {
        display: flex; flex-wrap: wrap; align-items: flex-end; gap: 12px;
        padding: 14px 20px; background: var(--canvas); border-bottom: 1px solid var(--line);
    }
    .jo-page .lines-controls .form-group { margin: 0; }
    .jo-page .lines-controls .task-group { width: 240px; }
    .jo-page .lines-controls .month-group { width: 250px; }
    .jo-page .month-pick { display: flex; gap: 6px; }
    .jo-page .month-pick select:first-child { flex: 1.5; }
    .jo-page .month-pick select:last-child  { flex: 1; }
    .jo-page .month-group.is-late .form-control { border-color: #E6C48A; background: #FFFBF2; }
    .jo-page .month-flag {
        display: none; margin-left: 6px; font-weight: 500; color: var(--warn);
    }
    .jo-page .month-group.is-late .month-flag { display: inline; }
    .jo-page .cap-month { display: block; margin-top: 3px; font-size: 11px; color: var(--muted); text-align: right; }
    .jo-page .lines-controls .remark-group { flex: 1; min-width: 220px; }
    .jo-page .lines-controls .fill-group {
        display: flex; align-items: center; gap: 4px;
        height: 38px; padding: 0 4px;
    }
    .jo-page .fill-group .link-btn {
        display: inline-flex; align-items: center; gap: 6px;
        height: 32px; padding: 0 10px; border-radius: var(--radius);
    }
    .jo-page .fill-group .link-btn:hover { background: var(--accent-bg); text-decoration: none; }
    .jo-page .fill-group .link-btn.danger { color: var(--bad); }
    .jo-page .fill-group .link-btn.danger:hover { background: var(--bad-bg); }
    .jo-page .fill-group .link-btn:disabled { color: #A3ACBB; background: none; cursor: not-allowed; }
    .jo-page .fill-group .sep { width: 1px; height: 18px; background: var(--line); }

    .jo-page .lines-notice {
        display: flex; align-items: center; gap: 10px;
        padding: 12px 20px; font-size: 13px;
        background: var(--warn-bg); color: var(--warn); border-bottom: 1px solid var(--line);
    }

    /* Items table */
    .jo-page .items-wrap { max-height: calc(100vh - 400px); min-height: 160px; overflow-y: auto; overflow-x: auto; }
    .jo-page .table-items { width: 100%; border-collapse: separate; border-spacing: 0; font-size: 12.5px; }
    .jo-page .table-items thead th {
        position: sticky; top: 0; z-index: 1;
        background: var(--ink-2); color: #DDE3EE;
        font-size: 12px; font-weight: 600; padding: 9px 12px; white-space: nowrap; text-align: left;
    }
    .jo-page .table-items tbody td { padding: 8px 12px; border-bottom: 1px solid var(--line-soft); vertical-align: middle; white-space: nowrap; }
    .jo-page .table-items tbody tr:nth-child(even) td { background: #FBFCFD; }
    .jo-page .table-items tbody tr.is-selected td { background: #F1F6FD; }
    .jo-page .table-items tbody tr.is-received td { color: var(--muted); background: #FAFAFB; }
    .jo-page .table-items td.item-name { white-space: normal; min-width: 220px; font-weight: 500; color: var(--ink); }
    .jo-page .table-items tr.is-received td.item-name { color: var(--muted); }
    .jo-page .table-items .text-right { text-align: right; }
    .jo-page .table-items .text-center { text-align: center; }
    .jo-page .table-items .chk-col { width: 36px; }
    .jo-page .table-items input[type="checkbox"] { width: 15px; height: 15px; margin: 0; cursor: pointer; accent-color: var(--accent); }
    .jo-page .table-items input[type="checkbox"]:disabled { cursor: not-allowed; }
    .jo-page .table-items .line-pend  { color: var(--bad); font-weight: 600; }
    .jo-page .table-items .line-pend.is-zero { color: var(--muted); font-weight: 500; }
    .jo-page .table-items .order-ctn { font-weight: 600; color: var(--ink); }

    .jo-page .cap-field { position: relative; width: 120px; margin-left: auto; }
    .jo-page .cap-field input {
        width: 100%; height: 32px; border: 1px solid #C9D3E3; border-radius: var(--radius);
        background: #FFFDF5; padding: 0 40px 0 10px;
        font-size: 13px; font-weight: 600; text-align: right; font-variant-numeric: tabular-nums; color: var(--ink);
    }
    .jo-page .cap-field input:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px var(--accent-bg); background: #fff; }
    .jo-page .cap-field input:disabled { background: var(--canvas); border-color: var(--line); color: var(--muted); }
    .jo-page .cap-field .unit { position: absolute; right: 9px; top: 50%; transform: translateY(-50%); font-size: 11px; color: var(--muted); pointer-events: none; }
    .jo-page .cap-field.has-error input { border-color: var(--bad); box-shadow: 0 0 0 3px var(--bad-bg); }

    /* Report group: dropdown until set, then a tag from saved item data */
    .jo-page .rg-field { display: inline-flex; align-items: center; gap: 6px; }
    .jo-page .rg-input {
        height: 32px; width: 180px;
        border: 1px solid #C9D3E3; border-radius: var(--radius);
        background: #fff; padding: 0 10px; font-size: 12.5px; color: var(--ink);
    }
    .jo-page .rg-input::placeholder { color: #A3ACBB; }
    .jo-page .rg-input:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px var(--accent-bg); }
    .jo-page .rg-field.has-error .rg-input { border-color: var(--bad); box-shadow: 0 0 0 3px var(--bad-bg); }
    .jo-page .rg-tag {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 3px 9px; border-radius: 4px;
        background: var(--accent-bg); color: var(--accent-dk);
        font-size: 12px; font-weight: 500; white-space: nowrap;
    }
    .jo-page .rg-tag .fa { font-size: 11px; opacity: .8; }
    .jo-page tr.is-received .rg-tag { background: var(--canvas); color: var(--ink-soft); }
    .jo-page .rg-edit {
        width: 24px; height: 24px; border-radius: 4px; border: 1px solid transparent;
        background: none; color: var(--muted); padding: 0; cursor: pointer; font-size: 12px;
    }
    .jo-page .rg-edit:hover { border-color: var(--line); color: var(--accent); background: #fff; }

    /* Transfer */
    .jo-page .line-actions { display: inline-flex; gap: 6px; }
    .jo-page .btn-transfer { background: #fff; border-color: #D9CCEE; color: #5B3E96; }
    .jo-page .btn-transfer:hover { background: #5B3E96; border-color: #5B3E96; color: #fff; }
    .jo-page .pill.transferred { background: #F1ECF8; color: #5B3E96; border-color: transparent; }
    .jo-page tr.is-transferred td { color: var(--muted); background: #FAFAFB; }
    .jo-page .xfer-note {
        display: flex; align-items: center; gap: 5px; margin-top: 3px;
        font-size: 11.5px; font-weight: 500; color: #5B3E96;
    }

    .jo-page .jo-modal .modal-content { position: relative; }
    .jo-page .xfer-backdrop {
        position: absolute; inset: 0; z-index: 20;
        background: rgba(31, 42, 68, .35);
    }
    .jo-page .xfer-panel {
        position: absolute; top: 0; right: 0; bottom: 0; z-index: 21;
        width: 420px; max-width: 100%;
        background: #fff; display: flex; flex-direction: column;
        box-shadow: -12px 0 32px rgba(31, 42, 68, .18);
    }
    .jo-page .xfer-backdrop[hidden], .jo-page .xfer-panel[hidden] { display: none; }
    .jo-page .xfer-head {
        display: flex; align-items: flex-start; justify-content: space-between; gap: 12px;
        padding: 16px 20px; background: #5B3E96; color: #fff;
    }
    .jo-page .xfer-head h5 { margin: 0; font-size: 15px; font-weight: 600; }
    .jo-page .xfer-head p  { margin: 3px 0 0; font-size: 12px; color: #E4DAF3; }
    .jo-page .xfer-head .close { color: #fff; opacity: .8; text-shadow: none; font-size: 24px; }
    .jo-page .xfer-body { padding: 18px 20px; overflow-y: auto; flex: 1; }
    .jo-page .xfer-body .form-group { margin-bottom: 14px; }
    .jo-page .xfer-item {
        padding: 12px 14px; border-radius: var(--radius);
        background: var(--canvas); border: 1px solid var(--line); margin-bottom: 16px;
    }
    .jo-page .xfer-item .name { font-weight: 600; color: var(--ink); font-size: 13px; }
    .jo-page .xfer-item .meta { display: flex; gap: 16px; margin-top: 4px; font-size: 12px; color: var(--muted); }
    .jo-page .xfer-item .meta b { color: var(--ink); font-weight: 600; }
    .jo-page .xfer-route { display: grid; grid-template-columns: 1fr 24px 1fr; gap: 8px; align-items: end; }
    .jo-page .xfer-route .arrow { text-align: center; color: #5B3E96; padding-bottom: 10px; }
    .jo-page .xfer-body textarea.form-control { height: auto; resize: vertical; }
    .jo-page .xfer-hint { display: block; margin-top: 5px; font-size: 11.5px; color: var(--muted); }
    .jo-page .xfer-hint.err { color: var(--bad); }
    .jo-page .xfer-foot {
        display: flex; justify-content: flex-end; gap: 8px;
        padding: 12px 20px; border-top: 1px solid var(--line); background: var(--canvas);
    }
    .jo-page .xfer-panel.is-bulk { width: 600px; }
    .jo-page .bulk-head {
        display: flex; align-items: center; justify-content: space-between; gap: 10px;
        padding: 8px 12px; background: var(--canvas);
        border: 1px solid var(--line); border-bottom: 0;
        border-radius: var(--radius) var(--radius) 0 0;
        font-size: 12.5px;
    }
    .jo-page .bulk-head label { margin: 0; display: inline-flex; align-items: center; gap: 8px; font-weight: 600; color: var(--ink); cursor: pointer; }
    .jo-page .bulk-head .total { color: var(--muted); }
    .jo-page .bulk-head .total b { color: #5B3E96; font-weight: 700; }
    .jo-page .bulk-list {
        border: 1px solid var(--line); border-radius: 0 0 var(--radius) var(--radius);
        max-height: 320px; overflow-y: auto; margin-bottom: 14px;
    }
    .jo-page .bulk-row {
        display: grid; grid-template-columns: 22px 1fr 130px; gap: 10px; align-items: center;
        padding: 9px 12px; border-bottom: 1px solid var(--line-soft);
    }
    .jo-page .bulk-row:last-child { border-bottom: 0; }
    .jo-page .bulk-row.is-on { background: #F7F3FC; }
    .jo-page .bulk-row input[type="checkbox"], .jo-page .bulk-head input[type="checkbox"] {
        width: 15px; height: 15px; margin: 0; accent-color: #5B3E96; cursor: pointer;
    }
    .jo-page .bulk-row .bx-name { font-size: 12.5px; font-weight: 500; color: var(--ink); line-height: 1.35; }
    .jo-page .bulk-row .bx-name small { display: block; margin-top: 2px; font-size: 11.5px; color: var(--muted); font-weight: 400; }
    .jo-page .bulk-row .cap-field { width: 130px; }
    .jo-page .bulk-row:not(.is-on) .cap-field input { background: var(--canvas); color: var(--muted); }

    .jo-page .btn-xfer { background: #5B3E96; border-color: #5B3E96; color: #fff; }
    .jo-page .btn-xfer:hover { background: #4A3180; border-color: #4A3180; color: #fff; }

    .jo-page .lines-loading { padding: 48px 20px; text-align: center; color: var(--muted); font-size: 13px; }

    .jo-page .jo-modal .modal-footer {
        display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 10px;
        padding: 12px 20px; border-top: 1px solid var(--line); background: var(--canvas);
    }
    .jo-page .jo-modal .modal-footer:before, .jo-page .jo-modal .modal-footer:after { display: none; }
    .jo-page .footer-meta { font-size: 12.5px; color: var(--muted); text-align: left; }
    .jo-page .footer-meta strong { color: var(--ink); font-weight: 600; }
    .jo-page .footer-actions { display: flex; gap: 8px; margin-left: auto; }

    @media (prefers-reduced-motion: reduce) {
        .jo-page .coverage-bar .seg-received, .jo-page .coverage-bar .seg-planned { transition: none; }
    }

    /* ============================================================
       DATEPICKER (popup is appended to <body>)
    ============================================================ */
    .datepicker.dropdown-menu {
        z-index: 3000 !important; padding: 8px; border: 1px solid #E3E7EE; border-radius: 8px;
        box-shadow: 0 12px 32px rgba(31, 42, 68, 0.16);
        font-family: 'IBM Plex Sans', 'Segoe UI', Tahoma, Arial, sans-serif; font-size: 13px;
    }
    .datepicker table tr td, .datepicker table tr th { width: 34px; height: 32px; border-radius: 4px; text-decoration: none; }
    .datepicker .datepicker-switch { cursor: pointer; font-weight: 600; color: #1F2A44; }
    .datepicker .datepicker-switch:hover, .datepicker .prev:hover, .datepicker .next:hover,
    .datepicker table tr td span:hover, .datepicker table tr td.day:hover { background: #EAF0F9 !important; cursor: pointer; }
    .datepicker .dow { font-weight: 500; color: #7A8599; font-size: 12px; }
    .datepicker table tr td span { height: 40px; line-height: 40px; border-radius: 4px; }
    .datepicker table tr td.active, .datepicker table tr td.active:hover,
    .datepicker table tr td span.active, .datepicker table tr td span.active:hover {
        background: #2F5DA8 !important; background-image: none !important; color: #fff !important; text-shadow: none;
    }
    .datepicker table tr td.today { background: #FBF1E1; color: #A86A12; }
</style>

<div class="jo-page">

    {{-- ============================================================
         PAGE HEADER
    ============================================================ --}}
    <section class="page-head">
        <div class="head-main">
            <div class="head-icon" aria-hidden="true"><i class="fa fa-inbox"></i></div>
            <div>
                <h1>JO Receive</h1>
                <p>Open a job order to set monthly capacity for each item line and receive it.</p>
            </div>
        </div>
        <ol class="breadcrumb">
            <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">JO Receive</li>
        </ol>
    </section>

    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>Success.</strong> {{ Session::get('success') }}
        </div>
    @endif

    @if(Session::has('danger'))
        <div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>Failed.</strong> {{ Session::get('danger') }}
        </div>
    @endif

    <form role="form" method="POST" action="{{ url('/notify_party/upload') }}" enctype="multipart/form-data" onsubmit="return false;">
        {{ csrf_field() }}

        {{-- ============================================================
             FILTER PANEL
        ============================================================ --}}
        <div class="panel-box">
            <div class="panel-box-head"><h3>Filter job orders</h3></div>
            <div class="panel-box-body">
                <div class="filter-grid">

                    <div class="form-group {{ $errors->has('from_date') ? 'has-error' : '' }}">
                        <label for="from_date">From date</label>
                        <input name="from_date" type="text" id="from_date" class="form-control datepicker"
                               value="{{ date('d-m-Y', strtotime($previous_date)) }}" placeholder="dd-mm-yyyy" autocomplete="off">
                    </div>

                    <div class="form-group {{ $errors->has('to_date') ? 'has-error' : '' }}">
                        <label for="to_date">To date <span class="label-meta" id="date_meta"></span></label>
                        <input name="to_date" type="text" id="to_date" class="form-control datepicker"
                               value="{{ date('d-m-Y', strtotime($current_date)) }}" placeholder="dd-mm-yyyy" autocomplete="off">
                    </div>

                    <div class="form-group {{ $errors->has('pfloor_id') ? 'has-error' : '' }}">
                        <label for="pfloor_id">Production floor</label>
                        <select name="pfloor_id" id="pfloor_id" data-live-search="true" class="form-control select2 selectpicker" required>
                            <option value="">Select floor</option>
                            @foreach($p_floors as $p_floor)
                                <option value="{{ $p_floor->id }}">{{ $p_floor->p_code }} - {{ $p_floor->p_name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('pfloor_id'))
                            <span class="help-block"><strong>{{ $errors->first('pfloor_id') }}</strong></span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('job_order_id') ? 'has-error' : '' }}">
                        <label for="job_order_id">Invoice number <span class="label-meta" id="inv_meta"></span></label>
                        <select name="job_order_id" id="job_order_id" data-live-search="true" class="form-control select2 selectpicker" required>
                            <option value="">Select a floor first</option>
                        </select>
                        @if ($errors->has('job_order_id'))
                            <span class="help-block"><strong>{{ $errors->first('job_order_id') }}</strong></span>
                        @endif
                    </div>

                    <div class="filter-action">
                        <button type="button" class="btn btn-primary-jo btn-search" id="check_button_id">
                            <i class="fa fa-search"></i> Show JOs
                        </button>
                    </div>

                </div>
            </div>
        </div>

        {{-- ============================================================
             RESULTS PANEL
        ============================================================ --}}
        <div class="panel-box">
            <div class="panel-box-head">
                <div class="table-toolbar">
                    <div>
                        <h3>Job orders</h3>
                        <div class="result-meta" id="result_meta">No invoice selected</div>
                    </div>
                    <div class="search-box">
                        <i class="fa fa-search"></i>
                        <input id="myInput" type="text" placeholder="Filter by JO, party, country…" aria-label="Filter job orders">
                    </div>
                </div>
            </div>

            <div class="table-area" id="tableArea">
            <div class="table-loading" id="tableLoading" hidden>
                <div class="loader-box" role="status" aria-live="polite">
                    <span class="spinner" aria-hidden="true"></span> Loading job orders…
                </div>
            </div>
            <div class="table-scroll" id="tableScroll">
                <table class="table-jo" id="tblMain">
                    <thead>
                        <tr class="group-row">
                            <th colspan="7"></th>
                            <th colspan="3" class="plan-group plan-col plan-first plan-last">Capacity plan (CTN)</th>
                            <th colspan="3"></th>
                        </tr>
                        <tr class="label-row">
                            <th class="col-view"></th>
                            <th>Party</th>
                            <th>Job order</th>
                            <th>Floor</th>
                            <th>Delivery</th>
                            <th>Created</th>
                            <th class="text-right">Order qty</th>
                            <th class="text-right plan-col plan-first">Capacity</th>
                            <th class="text-right plan-col">Allocated</th>
                            <th class="text-right plan-col plan-last">Pending</th>
                            <th>Allocation</th>
                            <th>Status</th>
                            <th class="text-center">Reports</th>
                        </tr>
                    </thead>
                    <tbody id="job_details">
                        <tr class="empty-state">
                            <td colspan="13">
                                <i class="fa fa-filter"></i>
                                <strong>Choose a floor and invoice number</strong>
                                Job orders for that invoice will appear here.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            </div>
        </div>

    </form>

    <datalist id="rg_suggestions"></datalist>

    {{-- ============================================================
         ITEM LINES MODAL
    ============================================================ --}}
    <div id="linesModal" class="modal fade jo-modal" role="dialog" aria-labelledby="linesModalTitle" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                    <h4 class="modal-title" id="linesModalTitle">
                        <span>Item lines for JO <span id="lm_jo_no">-</span></span>
                        <span class="demo-tag" id="lm_demo_tag" style="display:none;">Demo data</span>
                    </h4>
                    <div class="modal-sub">
                        <span>Party <b id="lm_party">-</b></span>
                        <span>Delivery <b id="lm_delivery">-</b></span>
                        <span>Capacity month <b id="lm_month">-</b></span>
                        <span>Floor <b id="lm_floor">-</b></span>
                    </div>
                </div>

                <div class="modal-body">

                    {{-- Coverage summary --}}
                    <div class="coverage-strip">
                        <div>
                            <span class="lbl">Order qty</span>
                            <span class="val num" id="lm_sum_order">0<small>CTN</small></span>
                        </div>
                        <div>
                            <span class="lbl">Capacity entered</span>
                            <span class="val num" id="lm_sum_cap">0<small>CTN</small></span>
                        </div>
                        <div>
                            <span class="lbl">Pending</span>
                            <span class="val num bad" id="lm_sum_pend">0<small>CTN</small></span>
                        </div>
                        <div class="coverage-meter">
                            <div class="meter-head">
                                <span class="lbl">Order covered</span>
                                <span class="pct num" id="lm_pct">0%</span>
                            </div>
                            <div class="coverage-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" id="lm_bar">
                                <div class="seg-received" id="lm_bar_received" style="width:0%"></div>
                                <div class="seg-planned"  id="lm_bar_planned"  style="width:0%"></div>
                            </div>
                            <div class="coverage-legend">
                                <span><i style="background:var(--ink)"></i>Received</span>
                                <span><i style="background:var(--ok)"></i>This entry</span>
                                <span><i style="background:var(--bad-bg)"></i>Not covered</span>
                            </div>
                        </div>
                    </div>

                    <div class="lines-notice" id="lm_po_notice" style="display:none;">
                        <i class="fa fa-exclamation-triangle"></i>
                        No PO is assigned to this JO yet. Assign a PO first, then come back to receive its lines.
                    </div>

                    {{-- Task + remarks --}}
                    <div class="lines-controls">
                        <div class="form-group task-group">
                            <label for="lm_task">Task</label>
                            <select id="lm_task" class="form-control"><option value="">Select task</option></select>
                        </div>
                        <div class="form-group month-group" id="lm_month_group">
                            <label for="lm_cap_month">Capacity for <span class="month-flag" title="This month is after the JO's delivery month">(after delivery)</span></label>
                            <div class="month-pick">
                                <select id="lm_cap_month" class="form-control" aria-label="Capacity month">
                                    <option value="1">January</option><option value="2">February</option>
                                    <option value="3">March</option><option value="4">April</option>
                                    <option value="5">May</option><option value="6">June</option>
                                    <option value="7">July</option><option value="8">August</option>
                                    <option value="9">September</option><option value="10">October</option>
                                    <option value="11">November</option><option value="12">December</option>
                                </select>
                                <select id="lm_cap_year" class="form-control" aria-label="Capacity year"></select>
                            </div>
                        </div>
                        <div class="form-group remark-group">
                            <label for="lm_remark">Remarks <span style="color:var(--muted);font-weight:400;">(optional)</span></label>
                            <input type="text" id="lm_remark" class="form-control" placeholder="Note for this receive">
                        </div>
                        <div class="fill-group" id="lm_fill_group">
                            <button type="button" class="link-btn" id="lm_fill_order" title="Copy each open line's order CTN into its capacity">
                                <i class="fa fa-magic"></i> Set capacity to order qty
                            </button>
                            <span class="sep" aria-hidden="true"></span>
                            <button type="button" class="link-btn danger" id="lm_clear_capacity" title="Empty capacity and unselect all open lines" disabled>
                                <i class="fa fa-undo"></i> Clear capacity
                            </button>
                        </div>
                    </div>

                    {{-- Lines --}}
                    <div class="items-wrap">
                        <table class="table-items">
                            <thead>
                                <tr>
                                    <th class="chk-col"><input type="checkbox" id="lm_chk_all" aria-label="Select all open lines"></th>
                                    <th>SL</th>
                                    <th>Item name</th>
                                    <th>Item code</th>
                                    <th class="text-right">PCS qty</th>
                                    <th class="text-right">Order CTN</th>
                                    <th class="text-right">Capacity (CTN)</th>
                                    <th class="text-right">Pending</th>
                                    <th>Status</th>
                                    <th>Report group</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="lm_lines">
                                <tr><td colspan="11" class="lines-loading">Loading item lines…</td></tr>
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="modal-footer">
                    <div class="footer-meta">
                        <strong id="lm_received_count">0</strong> of <strong id="lm_total_count">0</strong> lines received.
                        Entering a capacity selects the line. Each line needs a report group; once set for an item it is reused.
                    </div>
                    <div class="footer-actions">
                        <button type="button" class="btn btn-danger-jo" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="button" class="btn btn-transfer" id="lm_transfer_bulk" disabled>
                            <i class="fa fa-exchange"></i> <span id="lm_transfer_label">Transfer all</span>
                        </button>
                        <button type="button" class="btn btn-ok" id="lm_receive_selected" disabled>
                            <i class="fa fa-check"></i> Receive selected (<span id="lm_sel_count">0</span>)
                        </button>
                    </div>
                </div>

                {{-- TRANSFER PANEL: slides over the right side of the modal --}}
                <div class="xfer-backdrop" id="xfer_backdrop" hidden></div>
                <aside class="xfer-panel" id="xfer_panel" role="dialog" aria-labelledby="xfer_title" hidden>
                    <div class="xfer-head">
                        <div>
                            <h5 id="xfer_title"><i class="fa fa-exchange"></i> Transfer line to another floor</h5>
                            <p>Move all or part of this line's order to a different production floor.</p>
                        </div>
                        <button type="button" class="close" id="xfer_close" aria-label="Close transfer">&times;</button>
                    </div>

                    <div class="xfer-body">
                        <div class="xfer-item" id="xfer_single_item">
                            <div class="name" id="xfer_item_name">-</div>
                            <div class="meta">
                                <span>Code <b id="xfer_item_code">-</b></span>
                                <span>Open qty <b id="xfer_item_open">0</b> CTN</span>
                            </div>
                        </div>

                        <div class="xfer-route form-group">
                            <div>
                                <label>From floor</label>
                                <input type="text" class="form-control" id="xfer_from" readonly>
                            </div>
                            <div class="arrow" aria-hidden="true"><i class="fa fa-long-arrow-right"></i></div>
                            <div>
                                <label for="xfer_to">To floor</label>
                                <select class="form-control" id="xfer_to">
                                    <option value="">Select floor</option>
                                    @foreach($p_floors as $p_floor)
                                        <option value="{{ $p_floor->id }}" data-code="{{ $p_floor->p_code }}">{{ $p_floor->p_code }} / {{ $p_floor->p_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Bulk: every open line with its own qty --}}
                        <div id="xfer_bulk" hidden>
                            <label>Lines to transfer</label>
                            <div class="bulk-head">
                                <label><input type="checkbox" id="xfer_bulk_all"> Select all</label>
                                <span class="total" id="xfer_bulk_total"><b>0</b> lines, <b>0</b> CTN</span>
                            </div>
                            <div class="bulk-list" id="xfer_bulk_list"></div>
                        </div>

                        <div class="form-group" id="xfer_single_qty">
                            <label for="xfer_qty">Transfer qty</label>
                            <div class="cap-field" style="width:100%;">
                                <input type="number" id="xfer_qty" min="0" step="0.01" placeholder="0">
                                <span class="unit">CTN</span>
                            </div>
                            <span class="xfer-hint" id="xfer_qty_hint">Whatever is left stays on this floor.</span>
                        </div>

                        <div class="form-group">
                            <label for="xfer_reason">Reason <span style="color:var(--muted);font-weight:400;">(optional)</span></label>
                            <textarea class="form-control" id="xfer_reason" rows="3" placeholder="e.g. Floor capacity full for this month"></textarea>
                        </div>
                    </div>

                    <div class="xfer-foot">
                        <button type="button" class="btn btn-ghost" id="xfer_cancel">Cancel</button>
                        <button type="button" class="btn btn-xfer" id="xfer_submit"><i class="fa fa-exchange"></i> Transfer</button>
                    </div>
                </aside>

            </div>
        </div>
    </div>

</div>

<script>document.title = 'JO Receive';</script>

<script>
    /* ================================================================
       DEMO MODE
       true  → item lines and tasks come from generated demo data and
               "Receive" is simulated in the browser (nothing is saved).
       false → uses the real endpoints below.
    ================================================================ */
    var DEMO_MODE = true;

    /* ================================================================
       BACKEND CONTRACT (used when DEMO_MODE = false)
       GET  itemDetails?jo_id=&sc_id=&jo_number=
            → { results: [ { jo_detail_id, item_id, item_name, item_code,
                             pcs_qty, ctn_qty, capacity, allocated_qty,
                             pending_qty, rcv_status,
                             report_group } ],          // text saved for the item, null if none yet
              report_groups: [ 'Spices', ... ] }        // optional: past values, used as typing suggestions
       POST saveItems
            jo_id, jo_no, sc_id, po_master_id, task_id, remark,
            delivery_date,
            capacity_month ('YYYY-MM', chosen in the modal), capacity_month_label ('July 2026'),
            items[n][jo_detail_id], items[n][item_id],
            items[n][order_qty], items[n][capacity], items[n][report_group]
            (save report_group text against the item so it is reused next time)
            → { status: 'success' } | { status: 'error', message }

       POST transferItem   (one line or many, same request)
            jo_id, jo_no, sc_id, from_floor, to_floor_id, remark,
            items[n][jo_detail_id], items[n][item_id], items[n][transfer_qty]
            → { status: 'success' } | { status: 'error', message }
            item details should then return, per line:
              ctn_qty (qty left on this floor),
              transfers: [ { to_floor: '35057 / HAL', qty } ],
              rcv_status 'Transferred' when nothing is left
    ================================================================ */
    var URLS = {
        floorJobOrders: "/json/get/production_floor/job_order",
        scJoDetails:    "{{ url('/json/get/sc_wise/jo/details') }}",
        taskList:       "{{ url('/json/get/sc/jo/task_list') }}",
        itemDetails:    "{{ url('/json/get/jo/item_details') }}",
        saveItems:      "{{ url('/json/save/jo_item_receive_with_capacity') }}",
        transferItem:   "{{ url('/json/save/jo_item_transfer') }}",
        joReport:       "{{ url('/factory/jo/report') }}",
        scReport:       "{{ url('/factory/sc/report') }}"
    };

    var COLS = 13;
    var MONTHS = ["January","February","March","April","May","June",
                  "July","August","September","October","November","December"];

    /* State for the open modal */
    var LM = { $joRow: null, items: [], task: {}, groups: [] };

    $(".preload").hide();

    /* ---------------- helpers ---------------- */
    function esc(v) {
        if (v === null || v === undefined) return '';
        return String(v).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }
    function num(v) { return parseFloat(v) || 0; }
    function fmt(v) {
        var n = num(v);
        return n % 1 === 0 ? n.toLocaleString()
                           : n.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }
    function monthFromDate(dmy) {
        var d = new Date(String(dmy).split('-').reverse().join('-'));
        return isNaN(d) ? '' : MONTHS[d.getMonth()] + ' ' + d.getFullYear();
    }
    function emptyRow(icon, title, text) {
        return '<tr class="empty-state"><td colspan="' + COLS + '"><i class="fa ' + icon + '"></i><strong>' + title + '</strong>' + text + '</td></tr>';
    }
    function statusFor(order, allocated) {
        if (order > 0 && allocated >= order) return { text: 'Full', cls: 'full' };
        if (allocated > 0) return { text: 'Partial', cls: 'partial' };
        return { text: 'Pending', cls: 'pending' };
    }
    /* Keep the table at its current height while loading so nothing jumps */
    function setTableLoading(on) {
        var $area = $('#tableArea'), $scroll = $('#tableScroll');
        if (on) {
            $scroll.css('height', $scroll.outerHeight() + 'px');
            $area.addClass('is-loading');
            $('#tableLoading').prop('hidden', false);
        } else {
            $('#tableLoading').prop('hidden', true);
            $area.removeClass('is-loading');
            $scroll.css('height', '');
        }
    }

    function redirectURL(url) { window.open(url, '_blank'); return false; }

    /* ================================================================
       DEMO DATA
       Lines are generated once per JO (seeded by JO no.) and kept for
       the session, so reopening a JO shows the same lines and any
       demo "receives" you made. CTN qty adds up to the JO order qty.
    ================================================================ */
    var DEMO_STORE = {};
    var DEMO_ITEMS = [
        ['PRAN Mejbani Beef Masala 68g x 24 packs/CTN', '62410', 24],
        ['PRAN Cinnamon Powder (Netco jar) 100g x 24 jar', '58114', 24],
        ['PRAN Whole Cumin Seed 100g', '59831', 30],
        ['PRAN Beef Stock (Spice) 20g x 24 pcs x 24 box', '59849', 576],
        ['PRAN Chicken Stock (Spice) 20g x 24 pcs x 24 box', '59850', 576],
        ['PRAN Ginger Paste 750g x 12 jar EXP', '56725', 12],
        ['PRAN Garlic-Ginger Mix Paste 750g x 12 jar EXP', '56724', 12],
        ['PRAN Coconut Cream Biscuit 90g', '58538', 48],
        ['PRAN Whole Black Pepper (pouch) 20pcs x 4 tray', '57312', 80],
        ['PRAN Achar Gosht Curry (100g x 24 pack) EXP', '49516', 24]
    ];
    /* item_id → report group text. Two items start "already set" so both states show. */
    var DEMO_ITEM_RG = { '59831': 'Spices & Seeds', '57312': 'Spices & Seeds' };

    var DEMO_TASKS = [
        { id: 'd1', task_name: 'JO received by production' },
        { id: 'd2', task_name: 'Capacity planned' },
        { id: 'd3', task_name: 'Sent to floor for production' }
    ];

    function seeded(str) {
        var h = 2166136261;
        for (var i = 0; i < str.length; i++) { h ^= str.charCodeAt(i); h = Math.imul(h, 16777619); }
        return function () {
            h += 0x6D2B79F5;
            var t = h;
            t = Math.imul(t ^ (t >>> 15), t | 1);
            t ^= t + Math.imul(t ^ (t >>> 7), t | 61);
            return ((t ^ (t >>> 14)) >>> 0) / 4294967296;
        };
    }

    function buildDemoLines(joNo, orderQty) {
        var rnd   = seeded(String(joNo));
        var count = 3 + Math.floor(rnd() * 5);           // 3–7 lines
        var pool  = DEMO_ITEMS.slice().sort(function () { return rnd() - 0.5; }).slice(0, count);
        var total = Math.max(Math.round(num(orderQty)), count);

        var weights = pool.map(function () { return 0.5 + rnd(); });
        var wsum = weights.reduce(function (a, b) { return a + b; }, 0);
        var used = 0;

        return pool.map(function (it, i) {
            var ctn = (i === pool.length - 1) ? total - used : Math.max(1, Math.floor(total * weights[i] / wsum));
            used += ctn;
            var received = i === 0 && rnd() > 0.5;          // sometimes the first line is already received
            var cap = received ? ctn : 0;
            return {
                jo_detail_id:  'demo-' + joNo + '-' + (i + 1),
                item_id:       it[1],
                item_name:     it[0],
                item_code:     it[1],
                pcs_qty:       ctn * it[2],
                pcs_per_ctn:   it[2],
                transfers:     [],
                ctn_qty:       ctn,
                capacity:      cap,
                allocated_qty: received ? ctn : 0,
                pending_qty:   received ? 0 : ctn,
                rcv_status:    received ? 'Received' : 'Pending'
            };
        });
    }

    /* Returns a promise resolving to { items, task } */
    function fetchLines($joRow) {
        var joId = $joRow.attr('data-jo-id');
        var scId = $joRow.attr('data-sc-id');
        var joNo = $joRow.attr('data-jo-no');

        if (DEMO_MODE) {
            var d = $.Deferred();
            if (!DEMO_STORE[joNo]) DEMO_STORE[joNo] = buildDemoLines(joNo, $joRow.attr('data-qty'));
            setTimeout(function () {
                var items = JSON.parse(JSON.stringify(DEMO_STORE[joNo]));
                $.each(items, function (i, it) {                // item-level report group, shared across JOs
                    it.report_group = DEMO_ITEM_RG[it.item_id] || null;
                });
                var used = [];
                $.each(DEMO_ITEM_RG, function (k, v) { if (v && used.indexOf(v) < 0) used.push(v); });
                d.resolve({
                    items:  items,
                    groups: used,
                    task:   { po_master_id: 'demo', jo_no: joNo, userTaskLists: DEMO_TASKS }
                });
            }, 300);
            return d.promise();
        }

        var reqItems = $.get(URLS.itemDetails, { jo_id: joId, sc_id: scId, jo_number: joNo });
        var reqTasks = $.get(URLS.taskList,    { sc_id: scId, jo_number: joNo });
        return $.when(reqItems, reqTasks).then(function (itemsRes, taskRes) {
            return {
                items:  (itemsRes[0] && itemsRes[0].results) ? itemsRes[0].results : [],
                groups: (itemsRes[0] && itemsRes[0].report_groups) ? itemsRes[0].report_groups : [],
                task:   taskRes[0] || {}
            };
        });
    }

    function rgInputHtml(value, itemName) {
        return '<span class="rg-field"><input type="text" class="rg-input" maxlength="100" list="rg_suggestions"' +
               ' placeholder="Type report group" value="' + esc(value || '') + '"' +
               ' aria-label="Report group for ' + esc(itemName) + '"></span>';
    }

    /* Saved group → tag (editable on open lines). No group → text input. */
    function rgCellHtml(it, locked) {
        if (it.report_group) {
            return '<span class="rg-field"><span class="rg-tag" title="Saved for this item"><i class="fa fa-tag"></i>' + esc(it.report_group) + '</span>' +
                   (locked ? '' : '<button type="button" class="rg-edit" title="Change report group" aria-label="Change report group"><i class="fa fa-pencil"></i></button>') +
                   '</span>';
        }
        if (locked) return '<span style="color:var(--muted);">-</span>';
        return rgInputHtml('', it.item_name);
    }

    /* Report group for a line: typed text if the input is shown, else the saved one */
    function lineGroup($tr) {
        var $in = $tr.find('.rg-input');
        if ($in.length) return $.trim($in.val());
        return LM.items[$tr.attr('data-index')].report_group || '';
    }

    /* Typing suggestions from groups already used, so names stay consistent */
    function fillSuggestions() {
        var $dl = $('#rg_suggestions').empty();
        $.each(LM.groups || [], function (i, g) { $dl.append($('<option>').attr('value', g)); });
    }

    /* ================================================================
       MAIN TABLE
    ================================================================ */
    function buildJoRow(value) {
        var pending = value.pending_qty || 0;
        var st = value.allocation_status || 'Pending';
        var stCls = st == 'Full' ? 'status-full' : (st == 'Partial' ? 'status-partial' : 'status-pending');

        var r = '<tr class="jo-row"' +
                ' data-jo-id="' + esc(value.jo_id) + '"' +
                ' data-sc-id="' + esc(value.sc_id) + '"' +
                ' data-jo-no="' + esc(value.job_order_number) + '"' +
                ' data-party="' + esc(value.party) + '"' +
                ' data-country="' + esc(value.country) + '"' +
                ' data-delivery="' + esc(value.delivery_date) + '"' +
                ' data-floor="' + esc(value.prod_floor) + '"' +
                ' data-qty="' + esc(value.orqt_qty) + '"' +
                ' data-alloc="' + esc(value.allocated_qty || 0) + '"' +
                ' data-pend="' + esc(pending) + '">';
        r += '<td class="col-view"><button type="button" class="view-btn" title="View item lines" ' +
             'aria-label="View item lines for JO ' + esc(value.job_order_number) + '"><i class="fa fa-eye"></i></button></td>';
        /* Party, country below */
        r += '<td class="party"><div class="stack">' +
             '<span class="main">' + esc(value.party) + '</span>' +
             (value.country ? '<span class="sub"><i class="fa fa-globe"></i>' + esc(value.country) + '</span>' : '') +
             '</div></td>';

        /* JO no. */
        r += '<td><span class="num" style="font-weight:600;">' + esc(value.job_order_number) + '</span></td>';

        /* P_Floor: code bold, name beside it */
        var fl = String(value.prod_floor || '').split('/');
        r += '<td>' + (value.prod_floor
                ? '<span class="floor-tag"><i class="fa fa-industry" style="color:#A3ACBB;"></i><b>' + esc($.trim(fl[0])) + '</b>' +
                  (fl[1] ? '<span>' + esc($.trim(fl.slice(1).join('/'))) + '</span>' : '') + '</span>'
                : '<span style="color:var(--muted);">-</span>') + '</td>';

        /* Delivery date, mfg date below */
        r += '<td><div class="stack">' +
             '<span class="main num">' + esc(value.delivery_date) + '</span>' +
             (value.mfg_date ? '<span class="sub num"><i class="fa fa-calendar-o"></i>Mfg ' + esc(value.mfg_date) + '</span>' : '') +
             '</div></td>';

        /* Created by, date below */
        r += '<td><div class="stack">' +
             '<span class="main" style="font-weight:500;">' + esc(value.created_by || '-') + '</span>' +
             (value.created_date ? '<span class="sub num"><i class="fa fa-clock-o"></i>' + esc(value.created_date) + '</span>' : '') +
             '</div></td>';

        r += '<td class="text-right num" style="font-weight:600;">' + fmt(value.orqt_qty) + '</td>';
        r += '<td class="text-right num capacity-cell plan-col plan-first">' + fmt(value.capacity || 0) + '</td>';
        r += '<td class="text-right num allocated-cell plan-col">' + fmt(value.allocated_qty || 0) + '</td>';
        r += '<td class="text-right num pending-cell plan-col plan-last' + (num(pending) === 0 ? ' is-zero' : '') + '">' + fmt(pending) + '</td>';
        r += '<td class="alloc-status"><span class="pill ' + stCls + '">' + esc(st) + '</span></td>';
        /* JO status; receive / production status below only when they have a value */
        var js    = $.trim(value.jo_status || '');
        var jsCls = /^ok$/i.test(js) ? 'ok' : (/cancel/i.test(js) ? 'cancel' : '');
        r += '<td><div class="stack">' +
             '<span><span class="state ' + jsCls + '">' + esc(js || '-') + '</span></span>' +
             (value.jo_rcv_status ? '<span class="sub">Receive: ' + esc(value.jo_rcv_status) + '</span>' : '') +
             (value.prod_status   ? '<span class="sub">Production: ' + esc(value.prod_status) + '</span>' : '') +
             '</div></td>';
        r += '<td class="text-center"><div class="row-actions">';
        r += '<a href="' + URLS.joReport + '/' + esc(value.jo_id) + '" onclick="return redirectURL(this.href)" class="btn btn-report btn-report-jo" title="Open JO report"><i class="fa fa-file-text-o"></i> JO</a>';
        r += '<a href="' + URLS.scReport + '/' + esc(value.sc_id) + '" onclick="return redirectURL(this.href)" class="btn btn-report btn-report-sc" title="Open SC report"><i class="fa fa-file-o"></i> SC</a>';
        r += '</div></td></tr>';
        return r;
    }

    function updateResultMeta() {
        var $all = $('#job_details tr.jo-row');
        if (!$all.length) return;
        var $rows = $all.filter(':visible');
        var qty = 0, alloc = 0, pend = 0;
        $rows.each(function () {
            qty   += num($(this).attr('data-qty'));
            alloc += num($(this).attr('data-alloc'));
            pend  += num($(this).attr('data-pend'));
        });
        $('#result_meta').html(
            '<strong>' + $rows.length + '</strong> job orders, ' +
            '<strong>' + fmt(qty) + '</strong> CTN ordered, ' +
            '<strong style="color:var(--ok)">' + fmt(alloc) + '</strong> allocated, ' +
            '<strong style="color:var(--bad)">' + fmt(pend) + '</strong> pending'
        );
    }

    /* JO row totals from its lines (received lines only) */
    function refreshJoTotals($joRow, items) {
        if (!items || !items.length) return;
        var cap = 0, alloc = 0, pend = 0, order = 0;
        $.each(items, function (i, it) {
            cap   += num(it.capacity);
            alloc += num(it.allocated_qty);
            pend  += num(it.pending_qty);
            order += num(it.ctn_qty);
        });
        $joRow.find('.capacity-cell').text(fmt(cap));
        $joRow.find('.allocated-cell').text(fmt(alloc));
        $joRow.find('.pending-cell').text(fmt(pend)).toggleClass('is-zero', pend === 0);
        $joRow.attr({ 'data-alloc': alloc, 'data-pend': pend });
        var st = statusFor(order, alloc);
        $joRow.find('.alloc-status').html('<span class="pill status-' + st.cls + '">' + st.text + '</span>');
        updateResultMeta();
    }

    /* ================================================================
       MODAL
    ================================================================ */
    function openLinesModal($joRow) {
        $('#job_details tr.jo-row').removeClass('is-active');
        $joRow.addClass('is-active');
        LM.$joRow = $joRow;

        $('#lm_jo_no').text($joRow.attr('data-jo-no'));
        $('#lm_party').text($joRow.attr('data-party') + ' (' + $joRow.attr('data-country') + ')');
        $('#lm_delivery').text($joRow.attr('data-delivery'));
        setupCapacityMonth();
        $('#lm_floor').text($joRow.attr('data-floor') || '-');
        closeTransfer();
        $('#lm_demo_tag').toggle(DEMO_MODE);
        $('#lm_remark').val('');
        $('#lm_po_notice').hide();
        $('#lm_lines').html('<tr><td colspan="11" class="lines-loading"><span class="loader-box"><span class="spinner" aria-hidden="true"></span> Loading item lines…</span></td></tr>');
        $('#lm_receive_selected').prop('disabled', true);
        $('#lm_sel_count').text(0);
        resetSummary();

        $('#linesModal').modal('show');

        fetchLines($joRow).done(function (res) {
            if (LM.$joRow !== $joRow) return;     // user opened another JO meanwhile
            LM.items  = res.items;
            LM.groups = res.groups || [];
            LM.task   = res.task;
            renderTasks();
            renderLines();
        }).fail(function () {
            $('#lm_lines').html('<tr><td colspan="11" class="lines-loading" style="color:var(--bad);">' +
                '<i class="fa fa-exclamation-triangle"></i> Item lines could not be loaded. ' +
                '<button type="button" class="link-btn" id="lm_retry">Try again</button></td></tr>');
        });
    }

    function renderTasks() {
        var $sel = $('#lm_task').html('<option value="">Select task</option>');
        $.each(LM.task.userTaskLists || [], function (i, t) {
            $sel.append($('<option></option>').attr('value', t.id).text(t.task_name));
        });
    }

    function poMissing() { return LM.task && LM.task.error == 'po_error'; }

    function renderLines() {
        var locked = poMissing();
        fillSuggestions();
        $('#lm_po_notice').toggle(locked);
        $('#lm_task, #lm_remark, #lm_chk_all, #lm_cap_month, #lm_cap_year').prop('disabled', locked);

        if (!LM.items.length) {
            $('#lm_lines').html('<tr><td colspan="11" class="lines-loading">This JO has no item lines.</td></tr>');
            recalcSummary();
            return;
        }

        var h = '';
        $.each(LM.items, function (i, it) {
            var received = it.rcv_status == 'Received';
            var moved    = it.rcv_status == 'Transferred';
            var dis      = received || moved || locked;
            var order    = num(it.ctn_qty);
            var cap      = num(it.capacity);
            var alloc    = received ? num(it.allocated_qty) : Math.min(cap, order);
            var pend     = received ? num(it.pending_qty)   : Math.max(order - cap, 0);
            var st       = received ? { text: 'Received', cls: 'received' }
                         : moved    ? { text: 'Transferred', cls: 'transferred' }
                         : statusFor(order, alloc);

            var notes = '';
            $.each(it.transfers || [], function (k, t) {
                notes += '<span class="xfer-note"><i class="fa fa-exchange"></i>' + fmt(t.qty) + ' CTN transferred to ' + esc(t.to_floor) + '</span>';
            });

            h += '<tr class="item-row' + (received ? ' is-received' : '') + (moved ? ' is-transferred' : '') + '" data-index="' + i + '" data-order="' + order + '">';
            h += '<td class="chk-col"><input type="checkbox" class="line-check" aria-label="Select ' + esc(it.item_name) + '"' + (dis ? ' disabled' : '') + '></td>';
            h += '<td class="num">' + (i + 1) + '</td>';
            h += '<td class="item-name">' + esc(it.item_name) + notes + '</td>';
            h += '<td class="num">' + esc(it.item_code) + '</td>';
            h += '<td class="text-right num">' + fmt(it.pcs_qty) + '</td>';
            h += '<td class="text-right num order-ctn">' + fmt(order) + '</td>';
            h += '<td class="text-right"><div class="cap-field"><input type="number" class="line-cap" min="0" step="0.01" placeholder="0"' +
                 ' value="' + (cap > 0 ? cap : '') + '" aria-label="Capacity for ' + esc(it.item_name) + '"' + (dis ? ' disabled' : '') + '>' +
                 '<span class="unit">CTN</span></div>' +
                 (received && it.capacity_month_label ? '<span class="cap-month">for ' + esc(it.capacity_month_label) + '</span>' : '') +
                 '</td>';
            h += '<td class="text-right num line-pend' + (pend === 0 ? ' is-zero' : '') + '">' + fmt(pend) + '</td>';
            h += '<td><span class="pill line-status ' + st.cls + '">' + st.text + '</span></td>';
            h += '<td class="rg-cell">' + rgCellHtml(it, dis) + '</td>';
            h += '<td class="text-center">' + (dis ? '<span style="color:var(--muted);">-</span>'
                    : '<span class="line-actions">' +
                      '<button type="button" class="btn btn-row btn-primary-jo line-receive">Receive</button>' +
                      '<button type="button" class="btn btn-row btn-transfer line-transfer" title="Transfer to another floor">' +
                      '<i class="fa fa-exchange"></i> Transfer</button></span>') + '</td>';
            h += '</tr>';
        });
        $('#lm_lines').html(h);

        var received = LM.items.filter(function (it) { return it.rcv_status == 'Received'; }).length;
        $('#lm_received_count').text(received);
        $('#lm_total_count').text(LM.items.length);
        var openLines = LM.items.filter(function (it) { return it.rcv_status != 'Received' && it.rcv_status != 'Transferred'; }).length;
        $('#lm_fill_group').toggle(!locked && openLines > 0);

        syncSelection();
        recalcSummary();
    }

    function recalcLine($tr) {
        var order = num($tr.attr('data-order'));
        var cap   = num($tr.find('.line-cap').val());
        var alloc = Math.min(cap, order);
        var pend  = Math.max(order - cap, 0);
        var st    = statusFor(order, alloc);
        $tr.find('.line-pend').text(fmt(pend)).toggleClass('is-zero', pend === 0);
        $tr.find('.line-status').removeClass('full partial pending').addClass(st.cls).text(st.text);
        $tr.find('.cap-field').removeClass('has-error');
    }

    function resetSummary() {
        $('#lm_sum_order, #lm_sum_cap, #lm_sum_pend').html('0<small>CTN</small>');
        $('#lm_pct').text('0%');
        $('#lm_bar_received, #lm_bar_planned').css('width', '0%');
        $('#lm_received_count, #lm_total_count').text(0);
    }

    /* Summary uses saved values for received lines and typed values for open lines */
    function recalcSummary() {
        var order = 0, cap = 0, allocRcv = 0, allocNew = 0;
        $('#lm_lines tr.item-row').each(function () {
            var it = LM.items[$(this).attr('data-index')];
            var o  = num(it.ctn_qty);
            order += o;
            if (it.rcv_status == 'Received') {
                cap      += num(it.capacity);
                allocRcv += num(it.allocated_qty);
            } else {
                var c = num($(this).find('.line-cap').val());
                cap      += c;
                allocNew += Math.min(c, o);
            }
        });
        var alloc = allocRcv + allocNew;
        var pend  = Math.max(order - alloc, 0);
        var pRcv  = order > 0 ? (allocRcv / order) * 100 : 0;
        var pNew  = order > 0 ? (allocNew / order) * 100 : 0;
        var pct   = Math.round(pRcv + pNew);

        $('#lm_sum_order').html(fmt(order) + '<small>CTN</small>');
        $('#lm_sum_cap').html(fmt(cap) + '<small>CTN</small>');
        $('#lm_sum_pend').html(fmt(pend) + '<small>CTN</small>');
        $('#lm_pct').text(pct + '%');
        $('#lm_bar').attr('aria-valuenow', pct);
        $('#lm_bar_received').css('width', pRcv + '%');
        $('#lm_bar_planned').css('width', pNew + '%');
    }

    function syncSelection() {
        var openCount = LM.items.filter(isOpenLine).length;
        var selCount  = $('#lm_lines .line-check:checked').length;
        $('#lm_transfer_bulk').prop('disabled', openCount === 0 || poMissing());
        $('#lm_transfer_label').text(selCount ? 'Transfer selected (' + selCount + ')' : 'Transfer all');

        var hasCap = $('#lm_lines .line-cap:not(:disabled)').filter(function () { return num(this.value) > 0; }).length > 0;
        $('#lm_clear_capacity').prop('disabled', !hasCap);

        var $open    = $('#lm_lines .line-check:not(:disabled)');
        var $checked = $open.filter(':checked');
        $('#lm_sel_count').text($checked.length);
        $('#lm_receive_selected').prop('disabled', $checked.length === 0);
        $('#lm_chk_all').prop('checked', $open.length > 0 && $checked.length === $open.length)
                        .prop('disabled', $open.length === 0 || poMissing());
        $('#lm_lines tr.item-row').each(function () {
            $(this).toggleClass('is-selected', $(this).find('.line-check').is(':checked'));
        });
    }

    /* ---------------- capacity month ---------------- */
    function deliveryParts() {
        var d = new Date(String(LM.$joRow ? LM.$joRow.attr('data-delivery') : '').split('-').reverse().join('-'));
        return isNaN(d) ? null : { m: d.getMonth() + 1, y: d.getFullYear() };
    }

    /* Default = delivery month. Years: last year to 2 years ahead, plus the delivery year. */
    function setupCapacityMonth() {
        var del  = deliveryParts();
        var now  = new Date().getFullYear();
        var dy   = del ? del.y : now;
        var from = Math.min(now - 1, dy), to = Math.max(now + 2, dy);
        var $y   = $('#lm_cap_year').empty();
        for (var y = from; y <= to; y++) $y.append($('<option>').val(y).text(y));
        $('#lm_cap_month').val(del ? del.m : new Date().getMonth() + 1);
        $y.val(dy);
        onCapacityMonthChange();
    }

    function capMonthValue() {
        var m = +$('#lm_cap_month').val();
        return $('#lm_cap_year').val() + '-' + (m < 10 ? '0' : '') + m;
    }
    function capMonthLabel() {
        return MONTHS[+$('#lm_cap_month').val() - 1] + ' ' + $('#lm_cap_year').val();
    }

    function onCapacityMonthChange() {
        $('#lm_month').text(capMonthLabel());
        var del = deliveryParts();
        var late = del && (+$('#lm_cap_year').val() * 12 + +$('#lm_cap_month').val()) > (del.y * 12 + del.m);
        $('#lm_month_group').toggleClass('is-late', !!late);
    }

    /* ---------------- transfer ---------------- */
    /* XF.mode: 'single' (one line, from its row) or 'bulk' (many lines, from footer) */
    var XF = { mode: null, index: null };

    function isOpenLine(it) { return it.rcv_status != 'Received' && it.rcv_status != 'Transferred' && num(it.ctn_qty) > 0; }

    function prepareTransferPanel(mode) {
        var from = LM.$joRow.attr('data-floor') || '';
        var code = $.trim(from.split('/')[0]);
        XF.mode = mode;

        $('#xfer_from').val(from || '-');
        $('#xfer_to').val('').css('border-color', '').find('option').each(function () {
            var same = code && String($(this).data('code')) === code;   // can't transfer to its own floor
            $(this).prop('disabled', same).toggle(!same);
        });
        $('#xfer_reason').val('');

        var bulk = mode === 'bulk';
        $('#xfer_panel').toggleClass('is-bulk', bulk);
        $('#xfer_single_item, #xfer_single_qty').prop('hidden', bulk);
        $('#xfer_bulk').prop('hidden', !bulk);
        $('#xfer_title').html('<i class="fa fa-exchange"></i> ' + (bulk ? 'Transfer lines to another floor' : 'Transfer line to another floor'));
    }

    function showTransferPanel() {
        $('#xfer_backdrop, #xfer_panel').prop('hidden', false);
        $('#xfer_to').focus();
    }

    function openTransfer(index) {
        var it   = LM.items[index];
        var open = num(it.ctn_qty);
        XF.index = index;
        prepareTransferPanel('single');

        $('#xfer_item_name').text(it.item_name);
        $('#xfer_item_code').text(it.item_code);
        $('#xfer_item_open').text(fmt(open));
        $('#xfer_qty').attr('max', open).val(open).closest('.cap-field').removeClass('has-error');
        $('#xfer_qty_hint').removeClass('err').text('Up to ' + fmt(open) + ' CTN. Whatever is left stays on this floor.');
        $('#xfer_submit').html('<i class="fa fa-exchange"></i> Transfer');
        showTransferPanel();
    }

    /* Bulk: pre-ticks the lines selected in the modal, or every open line if none are */
    function openBulkTransfer() {
        prepareTransferPanel('bulk');
        var selected = $('#lm_lines .line-check:checked').closest('.item-row')
                         .map(function () { return +$(this).attr('data-index'); }).get();

        var h = '';
        $.each(LM.items, function (i, it) {
            if (!isOpenLine(it)) return;
            var on   = !selected.length || selected.indexOf(i) > -1;
            var open = num(it.ctn_qty);
            h += '<div class="bulk-row' + (on ? ' is-on' : '') + '" data-index="' + i + '" data-open="' + open + '">' +
                 '<input type="checkbox" class="bx-check" aria-label="Transfer ' + esc(it.item_name) + '"' + (on ? ' checked' : '') + '>' +
                 '<div class="bx-name">' + esc(it.item_name) + '<small>Code ' + esc(it.item_code) + ', open ' + fmt(open) + ' CTN</small></div>' +
                 '<div class="cap-field"><input type="number" class="bx-qty" min="0" step="0.01" max="' + open + '" value="' + open + '"' +
                 ' aria-label="Transfer qty for ' + esc(it.item_name) + '"><span class="unit">CTN</span></div>' +
                 '</div>';
        });
        $('#xfer_bulk_list').html(h);
        syncBulk();
        showTransferPanel();
    }

    function syncBulk() {
        var $rows = $('#xfer_bulk_list .bulk-row');
        var lines = 0, total = 0;
        $rows.each(function () {
            var on = $(this).find('.bx-check').is(':checked');
            $(this).toggleClass('is-on', on);
            if (on) { lines++; total += num($(this).find('.bx-qty').val()); }
        });
        $('#xfer_bulk_total').html('<b>' + lines + '</b> line' + (lines === 1 ? '' : 's') + ', <b>' + fmt(total) + '</b> CTN');
        $('#xfer_bulk_all').prop('checked', $rows.length > 0 && lines === $rows.length);
        $('#xfer_submit').html('<i class="fa fa-exchange"></i> ' +
            (XF.mode === 'bulk' ? 'Transfer ' + lines + ' line' + (lines === 1 ? '' : 's') : 'Transfer'));
    }

    function closeTransfer() {
        XF.mode = null; XF.index = null;
        $('#xfer_backdrop, #xfer_panel').prop('hidden', true);
    }

    /* Collects { index, qty } for the current mode; marks invalid fields */
    function collectTransfer() {
        var entries = [], ok = true;

        if (XF.mode === 'single') {
            var open = num(LM.items[XF.index].ctn_qty);
            var qty  = num($('#xfer_qty').val());
            if (qty <= 0 || qty > open) {
                $('#xfer_qty').closest('.cap-field').addClass('has-error');
                $('#xfer_qty_hint').addClass('err').text('Enter a quantity between 1 and ' + fmt(open) + ' CTN.');
                ok = false;
            } else entries.push({ index: XF.index, qty: qty });
        } else {
            $('#xfer_bulk_list .bulk-row').each(function () {
                if (!$(this).find('.bx-check').is(':checked')) return;
                var open = num($(this).attr('data-open'));
                var qty  = num($(this).find('.bx-qty').val());
                if (qty <= 0 || qty > open) { $(this).find('.cap-field').addClass('has-error'); ok = false; }
                else entries.push({ index: +$(this).attr('data-index'), qty: qty });
            });
            if (ok && !entries.length) {
                Swal.fire({ icon: 'warning', title: 'No lines selected', text: 'Tick at least one line to transfer.' });
                ok = false;
            } else if (!ok) {
                Swal.fire({ icon: 'warning', title: 'Check quantities', text: 'Each ticked line needs a qty between 1 and its open qty.' });
            }
        }
        return ok ? entries : null;
    }

    function submitTransfer() {
        if (!XF.mode) return;
        var $to = $('#xfer_to');
        var floorOk = !!$to.val();
        if (!floorOk) $to.css('border-color', 'var(--bad)');

        var entries = collectTransfer();
        if (!floorOk || !entries) return;

        var toLabel = $to.find('option:selected').text();
        var total   = entries.reduce(function (a, e) { return a + e.qty; }, 0);
        var $joRow  = LM.$joRow;
        var $btn    = $('#xfer_submit').prop('disabled', true);

        function done() {
            $btn.prop('disabled', false);
            closeTransfer();
            Swal.fire({ icon: 'success',
                        title: entries.length > 1 ? entries.length + ' lines transferred' : 'Line transferred',
                        text: fmt(total) + ' CTN moved to ' + toLabel + '.', timer: 1700, showConfirmButton: false });
            fetchLines($joRow).done(function (res) {
                LM.items = res.items; LM.groups = res.groups || []; LM.task = res.task;
                renderLines();
            });
        }
        function fail(msg) {
            $btn.prop('disabled', false);
            Swal.fire({ icon: 'error', title: 'Transfer failed', text: msg });
        }

        if (DEMO_MODE) {
            setTimeout(function () {
                var store = DEMO_STORE[$joRow.attr('data-jo-no')];
                $.each(entries, function (k, e) {
                    var st = store[e.index];
                    st.ctn_qty     = Math.round((num(st.ctn_qty) - e.qty) * 100) / 100;
                    st.pcs_qty     = st.ctn_qty * (st.pcs_per_ctn || 1);
                    st.pending_qty = st.ctn_qty;
                    st.capacity    = 0;
                    st.transfers   = (st.transfers || []).concat([{ to_floor: toLabel, qty: e.qty }]);
                    if (st.ctn_qty <= 0) st.rcv_status = 'Transferred';
                });
                done();
            }, 450);
            return;
        }

        $.ajax({
            method: 'POST',
            url: URLS.transferItem,
            data: {
                jo_id:       $joRow.attr('data-jo-id'),
                sc_id:       $joRow.attr('data-sc-id'),
                jo_no:       LM.task.jo_no || $joRow.attr('data-jo-no'),
                from_floor:  $joRow.attr('data-floor'),
                to_floor_id: $to.val(),
                remark:      $('#xfer_reason').val(),
                items:       entries.map(function (e) {
                    var it = LM.items[e.index];
                    return { jo_detail_id: it.jo_detail_id, item_id: it.item_id, transfer_qty: e.qty };
                }),
                _token:      $('input[name=_token]').val()
            },
            success: function (res) {
                if (res.status == 'success') done();
                else fail(res.message || 'The server rejected the transfer.');
            },
            error: function (e) { console.log(e); fail('The server returned an error. Try again, or contact support if it continues.'); }
        });
    }

    /* ---------------- receive ---------------- */
    function receiveLines($rows) {
        var payload = [], noCap = 0, noGroup = 0;

        $rows.each(function () {
            var $tr = $(this);
            var cap = num($tr.find('.line-cap').val());
            var gid = lineGroup($tr);
            var bad = false;
            if (cap <= 0) { noCap++;   $tr.find('.cap-field').addClass('has-error'); bad = true; }
            if (!gid)     { noGroup++; $tr.find('.rg-field').addClass('has-error');  bad = true; }
            if (bad) return;
            var it = LM.items[$tr.attr('data-index')];
            payload.push({ index: +$tr.attr('data-index'), jo_detail_id: it.jo_detail_id, item_id: it.item_id,
                           order_qty: num(it.ctn_qty), capacity: cap, report_group: gid });
        });

        if (noCap || noGroup) {
            var msgs = [];
            if (noCap)   msgs.push(noCap + ' line' + (noCap > 1 ? 's need' : ' needs') + ' a capacity greater than 0');
            if (noGroup) msgs.push(noGroup + ' line' + (noGroup > 1 ? 's need' : ' needs') + ' a report group');
            Swal.fire({ icon: 'warning', title: 'Some lines are incomplete', text: msgs.join(', and ') + '.' });
            $('#lm_lines .has-error').first().find('input, select').first().focus();
            return;
        }
        if (!payload.length) return;

        var $joRow = LM.$joRow;
        var $btns  = $('#lm_receive_selected, #lm_lines .line-receive').prop('disabled', true);
        var label  = payload.length + ' line' + (payload.length > 1 ? 's' : '') + ' received';

        function onSuccess() {
            Swal.fire({ icon: 'success', title: label, text: 'Capacity and allocation have been saved.',
                        timer: 1500, showConfirmButton: false });
            fetchLines($joRow).done(function (res) {
                LM.items = res.items; LM.groups = res.groups || []; LM.task = res.task;
                renderLines();
                refreshJoTotals($joRow, LM.items);
            });
        }
        function onFail(msg) {
            Swal.fire({ icon: 'error', title: 'Lines not received', text: msg });
            $btns.prop('disabled', false);
            syncSelection();
        }

        if (DEMO_MODE) {
            setTimeout(function () {
                var store = DEMO_STORE[$joRow.attr('data-jo-no')];
                $.each(payload, function (i, p) {
                    var it = store[p.index];
                    it.capacity      = p.capacity;
                    it.allocated_qty = Math.min(p.capacity, p.order_qty);
                    it.pending_qty   = Math.max(p.order_qty - p.capacity, 0);
                    it.rcv_status    = 'Received';
                    it.capacity_month       = capMonthValue();
                    it.capacity_month_label = capMonthLabel();
                    DEMO_ITEM_RG[p.item_id] = p.report_group;      // remembered for this item in every JO
                });
                onSuccess();
            }, 400);
            return;
        }

        $.ajax({
            method: 'POST',
            url: URLS.saveItems,
            data: {
                jo_id:          $joRow.attr('data-jo-id'),
                sc_id:          $joRow.attr('data-sc-id'),
                jo_no:          LM.task.jo_no || $joRow.attr('data-jo-no'),
                po_master_id:   LM.task.po_master_id,
                task_id:        $('#lm_task').val(),
                remark:         $('#lm_remark').val(),
                delivery_date:  $joRow.attr('data-delivery'),
                capacity_month:       capMonthValue(),
                capacity_month_label: capMonthLabel(),
                items:          payload.map(function (p) {
                    return { jo_detail_id: p.jo_detail_id, item_id: p.item_id, order_qty: p.order_qty,
                             capacity: p.capacity, report_group: p.report_group };
                }),
                _token:         $('input[name=_token]').val()
            },
            success: function (res) {
                if (res.status == 'success') onSuccess();
                else onFail(res.message || 'The server rejected the request.');
            },
            error: function (e) {
                console.log(e);
                onFail('The server returned an error. Try again, or contact support if it continues.');
            }
        });
    }

    /* ================================================================
       EVENTS
    ================================================================ */
    $(document).ready(function () {

        /* Datepicker: header click → months → years; opens below input */
        if ($.fn.datepicker) {
            $('#from_date, #to_date').each(function () {
                try { $(this).datepicker('destroy'); } catch (e) {}
            }).datepicker({
                format: 'dd-mm-yyyy', autoclose: true, todayHighlight: true,
                orientation: 'bottom left', startView: 0, minViewMode: 0, maxViewMode: 2,
                container: 'body'
            });
        }

        /* From date / To date / Production floor → invoice list (auto) */
        var invXhr = null, invTimer = null;

        function parseDMY(v) {
            var p = String(v || '').split('-');
            if (p.length !== 3) return null;
            var d = new Date(+p[2], +p[1] - 1, +p[0]);
            return isNaN(d) ? null : d;
        }

        function setInvoiceOptions(placeholder, list) {
            var $el = $('#job_order_id').html('');
            $el.append($('<option></option>').attr('value', '').text(placeholder));
            $.each(list || [], function (key, value) {
                $el.append($('<option></option>').attr('value', value['sc_id']).text(value.invoice_no));
            });
            $el.prop('disabled', !(list && list.length));
            $el.selectpicker('refresh');
        }

        function loadInvoices() {
            var pfloor_id = $('#pfloor_id').val();
            var fromD = parseDMY($('#from_date').val());
            var toD   = parseDMY($('#to_date').val());

            /* date range check */
            var badRange = fromD && toD && fromD > toD;
            $('#from_date, #to_date').toggleClass('is-invalid', !!badRange);
            $('#date_meta').toggleClass('err', !!badRange).text(badRange ? 'must be on or after From date' : '');

            if (invXhr) { invXhr.abort(); invXhr = null; }   // drop any older request

            if (!pfloor_id) {
                setInvoiceOptions('Select a floor first', null);
                $('#inv_meta').removeClass('ok err').text('');
                return;
            }
            if (badRange) {
                setInvoiceOptions('Fix the date range first', null);
                $('#inv_meta').removeClass('ok').addClass('err').text('');
                return;
            }

            setInvoiceOptions('Loading invoices…', null);
            $('#inv_meta').removeClass('ok err').text('loading…');

            invXhr = $.ajax({
                method: 'GET',
                url: URLS.floorJobOrders,
                data: { pfloor_id: pfloor_id, from_date: $('#from_date').val(), to_date: $('#to_date').val(),
                        _token: $('input[name=_token]').val() },
                success: function (response) {
                    var list = response.results || [];
                    if (!list.length) {
                        setInvoiceOptions('No invoice in this range', null);
                        $('#inv_meta').removeClass('ok').addClass('err').text('none found');
                    } else {
                        setInvoiceOptions('Select invoice', list);
                        $('#inv_meta').removeClass('err').addClass('ok').text(list.length + ' found');
                    }
                },
                error: function (xhr, status) {
                    if (status === 'abort') return;
                    console.log(xhr);
                    setInvoiceOptions('Could not load invoices', null);
                    $('#inv_meta').removeClass('ok').addClass('err').text('load failed');
                },
                complete: function () { invXhr = null; }
            });
        }

        /* datepicker fires both change and changeDate; debounce so it loads once */
        $('#from_date, #to_date').on('change changeDate', function () {
            clearTimeout(invTimer);
            invTimer = setTimeout(loadInvoices, 150);
        });
        $('#pfloor_id').on('change', loadInvoices);

        /* Filter box */
        $("#myInput").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#job_details tr.jo-row").each(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
            updateResultMeta();
        });

        /* Show JOs */
        $("#check_button_id").click(function () {
            var sc_id = $('#job_order_id').val();
            if (!sc_id) {
                Swal.fire({ icon: 'warning', title: 'Select an invoice', text: 'Choose an invoice number before showing job orders.' });
                return;
            }
            var $btn = $(this);
            $btn.prop('disabled', true).html('<span class="spinner" aria-hidden="true"></span> Loading');
            setTableLoading(true);

            $.get(URLS.scJoDetails, { sc_id: sc_id }, function (data) {
                if (data.results && data.results.length > 0) {
                    var rows = '';
                    $.each(data.results, function (key, value) { rows += buildJoRow(value); });
                    $("#job_details").html(rows);
                    $("#myInput").val('');
                    updateResultMeta();
                } else {
                    $("#job_details").html(emptyRow('fa-check-circle', 'Nothing left to receive', 'Production is done for every JO in this SC.'));
                    $('#result_meta').text('0 job orders');
                }
            }).fail(function () {
                $("#job_details").html(emptyRow('fa-exclamation-triangle', 'Job orders could not be loaded', 'Check your connection and select Show JOs again.'));
            }).always(function () {
                setTableLoading(false);
                $btn.prop('disabled', false).html('<i class="fa fa-search"></i> Show JOs');
            });
        });

        /* Open lines modal */
        $('#job_details').on('click', '.view-btn', function () {
            openLinesModal($(this).closest('tr.jo-row'));
        });

        $('#linesModal').on('click', '#lm_retry', function () {
            if (LM.$joRow) openLinesModal(LM.$joRow);
        });

        $('#linesModal').on('hidden.bs.modal', function () {
            $('#job_details tr.jo-row').removeClass('is-active');
        });

        /* Capacity typed → recalc + auto-select */
        $('#lm_lines').on('input', '.line-cap', function () {
            var $tr = $(this).closest('.item-row');
            recalcLine($tr);
            $tr.find('.line-check').prop('checked', num($(this).val()) > 0);
            syncSelection();
            recalcSummary();
        });

        $('#lm_lines').on('change', '.line-check', syncSelection);

        /* Change a saved report group → swap tag for a dropdown */
        $('#lm_lines').on('click', '.rg-edit', function () {
            var $tr = $(this).closest('.item-row');
            var it  = LM.items[$tr.attr('data-index')];
            $tr.find('.rg-cell').html(rgInputHtml(it.report_group, it.item_name));
            $tr.find('.rg-input').focus().select();
        });

        $('#lm_lines').on('input', '.rg-input', function () {
            $(this).closest('.rg-field').removeClass('has-error');
        });

        $('#lm_chk_all').on('change', function () {
            $('#lm_lines .line-check:not(:disabled)').prop('checked', this.checked);
            syncSelection();
        });

        $('#lm_fill_order').on('click', function () {
            $('#lm_lines tr.item-row').each(function () {
                var $input = $(this).find('.line-cap');
                if ($input.is(':disabled')) return;
                $input.val($(this).attr('data-order'));
                recalcLine($(this));
                $(this).find('.line-check').prop('checked', true);
            });
            syncSelection();
            recalcSummary();
        });

        /* Reset: empty capacity on every open line and unselect it.
           Typed report groups are kept, since they belong to the item. */
        $('#lm_clear_capacity').on('click', function () {
            $('#lm_lines tr.item-row').each(function () {
                var $input = $(this).find('.line-cap');
                if ($input.is(':disabled')) return;
                $input.val('');
                recalcLine($(this));
                $(this).find('.line-check').prop('checked', false);
                $(this).find('.rg-field').removeClass('has-error');
            });
            syncSelection();
            recalcSummary();
        });

        /* Receive one line / selected lines */
        $('#lm_lines').on('click', '.line-transfer', function () {
            openTransfer(+$(this).closest('.item-row').attr('data-index'));
        });
        $('#xfer_close, #xfer_cancel, #xfer_backdrop').on('click', closeTransfer);
        $('#xfer_submit').on('click', submitTransfer);
        $('#lm_cap_month, #lm_cap_year').on('change', onCapacityMonthChange);
        $('#lm_transfer_bulk').on('click', openBulkTransfer);
        $('#xfer_bulk_all').on('change', function () {
            $('#xfer_bulk_list .bx-check').prop('checked', this.checked);
            syncBulk();
        });
        $('#xfer_bulk_list').on('change', '.bx-check', syncBulk);
        $('#xfer_bulk_list').on('input', '.bx-qty', function () {
            $(this).closest('.cap-field').removeClass('has-error');
            /* typing a qty ticks the line */
            $(this).closest('.bulk-row').find('.bx-check').prop('checked', num(this.value) > 0);
            syncBulk();
        });
        $('#xfer_to').on('change', function () { $(this).css('border-color', ''); });
        $('#xfer_qty').on('input', function () {
            $(this).closest('.cap-field').removeClass('has-error');
            $('#xfer_qty_hint').removeClass('err');
        });
        /* Esc closes the transfer panel first, not the whole modal */
        $('#linesModal').on('keydown', function (e) {
            if (e.key === 'Escape' && !$('#xfer_panel').prop('hidden')) {
                e.stopImmediatePropagation(); e.preventDefault(); closeTransfer();
            }
        });
        $('#linesModal').on('hidden.bs.modal', closeTransfer);

        $('#lm_lines').on('click', '.line-receive', function () {
            receiveLines($(this).closest('.item-row'));
        });

        $('#lm_receive_selected').on('click', function () {
            receiveLines($('#lm_lines .line-check:checked').closest('.item-row'));
        });
    });
</script>

<script>
    $(document).ready(function () {
        setTimeout(function () { $('.sr-only').click(); }, 0.0001);
    });
</script>
@endsection
