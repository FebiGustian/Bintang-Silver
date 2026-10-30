<style>
    :root {
        --bg: #f5f6f8;
        --panel: #ffffff;
        --panel-border: #e5e7eb;
        --text: #111827;
        --muted: #6b7280;
        --silver: #9ca3af;
        --input-bg: #ffffff;
        --input-border: #d1d5db;
        --accent: #374151;
    }
    body { background: var(--bg); color: var(--text); }
    .sidebar { background: #ffffff; color: var(--text); border-right: 1px solid var(--panel-border); }
    .brand { color: var(--text); font-size: 18px; }
    .brand span { color: var(--silver); }
    .menu-label { color: var(--silver); }
    .menu a { color: #4b5563; }
    .menu a:hover { background: #f1f3f6; color: var(--text); }
    .menu a.active { background: #e5e7eb; color: var(--text); font-weight: bold; }
    h1 { color: var(--text); }
    .subtitle, .top small, .empty { color: var(--muted); }
    .panel { background: var(--panel); border-color: var(--panel-border); box-shadow: 0 2px 10px #0000000d; }
    th { color: var(--muted); border-bottom-color: var(--panel-border); }
    td { border-bottom-color: #eef0f3; }
    .sku { color: var(--muted); }
    .button, .actions .button { background: var(--accent); color: #ffffff; }
    .button:hover, .actions .button:hover { background: #1f2937; }
    .button-secondary, .actions .button-secondary { background: #e5e7eb; color: var(--text); }
    .actions a { color: #2563eb; }
    .actions button { color: #dc2626; }
    input[type=search], .form-group input[type=text], .form-group input[type=number],
    .form-group select, .form-group textarea {
        background: var(--input-bg); border-color: var(--input-border); color: var(--text);
    }
    input[type=search]:focus, .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
        outline: none; border-color: var(--muted);
    }
    .form-group label { color: var(--muted); }
    .swatch { border-color: var(--input-border); }
    .status { color: #15803d; background: #dcfce7; }
    .low { color: #b45309; background: #fef3c7; }
    .alert { background: #dcfce7; color: #166534; }
    .alert-error { background: #fee2e2; color: #991b1b; }
    .error-text { color: #dc2626; }
    .pagination svg { width: 18px; height: 18px; }
</style>
