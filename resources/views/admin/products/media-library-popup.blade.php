{{--
    ══════════════════════════════════════════════════════
    MEDIA LIBRARY POPUP — Reusable Component
    Include this partial on any page that needs image pick:
        @include('admin.partials.media-library-popup')

    To open popup from any button:
        onclick="openMediaPopup(function(file){ ... })"

    Example usage on product/category/blog create page:
        <button type="button" onclick="openMediaPopup(function(file){
            document.getElementById('imagePreview').src = file.url;
            document.getElementById('image_id').value   = file.id;
        })">Choose from Library</button>
    ══════════════════════════════════════════════════════
--}}

<style>
    /* ══ Popup Overlay ══ */
    .mlp-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .5);
        z-index: 1060;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    .mlp-overlay.open {
        display: flex;
    }

    /* ══ Modal shell ══ */
    .mlp-modal {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, .22);
        width: 100%;
        max-width: 1000px;
        max-height: 90vh;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    /* ══ Header ══ */
    .mlp-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 22px;
        border-bottom: 1px solid #e3e5e8;
        background: #fafafa;
        flex-shrink: 0;
    }

    .mlp-header h4 {
        font-size: 15px;
        font-weight: 650;
        color: #202223;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .mlp-header h4 i { color: #303d89; }

    .mlp-close {
        width: 32px; height: 32px;
        border-radius: 8px;
        border: 1px solid #e3e5e8;
        background: #fff;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; font-size: 14px; color: #6d7175;
        transition: all .12s;
    }

    .mlp-close:hover { background: #fce8e8; color: #b22222; border-color: #f5c0c0; }

    /* ══ Tabs (Upload / Library) ══ */
    .mlp-tabs {
        display: flex;
        border-bottom: 1px solid #e3e5e8;
        background: #fafafa;
        flex-shrink: 0;
    }

    .mlp-tab {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 12px 22px;
        font-size: 13px;
        font-weight: 500;
        color: #6d7175;
        border: none;
        background: none;
        cursor: pointer;
        border-bottom: 2px solid transparent;
        font-family: inherit;
        transition: color .12s, border-color .12s;
        white-space: nowrap;
    }

    .mlp-tab i { font-size: 13px; color: #8c9196; }

    .mlp-tab:hover { color: #202223; }

    .mlp-tab.active {
        color: #303d89;
        border-bottom-color: #303d89;
        font-weight: 650;
    }

    .mlp-tab.active i { color: #303d89; }

    /* ══ Tab panels ══ */
    .mlp-panel { display: none; flex: 1; overflow: hidden; flex-direction: column; }
    .mlp-panel.active { display: flex; }

    /* ══ Upload panel ══ */
    .mlp-upload-body {
        padding: 28px;
        flex: 1;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .mlp-dropzone {
        border: 2px dashed #e3e5e8;
        border-radius: 12px;
        padding: 40px 24px;
        text-align: center;
        cursor: pointer;
        transition: border-color .15s, background .15s;
        position: relative;
        background: #fff;
    }

    .mlp-dropzone:hover,
    .mlp-dropzone.dragover {
        border-color: #303d89;
        background: #f0f1fc;
    }

    .mlp-dropzone input[type=file] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }

    .mlp-dropzone-icon {
        font-size: 36px;
        color: #8c9196;
        display: block;
        margin-bottom: 12px;
    }

    .mlp-dropzone p {
        font-size: 14px;
        font-weight: 600;
        color: #202223;
        margin: 0 0 5px;
    }

    .mlp-dropzone small {
        font-size: 12.5px;
        color: #8c9196;
    }

    .mlp-dropzone-or {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #8c9196;
        font-size: 12px;
        margin: 4px 0;
    }

    .mlp-dropzone-or::before,
    .mlp-dropzone-or::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #e3e5e8;
    }

    /* Upload queue */
    .mlp-upload-queue { display: flex; flex-direction: column; gap: 8px; }

    .mlp-upload-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 14px;
        border: 1px solid #e3e5e8;
        border-radius: 8px;
        background: #fafafa;
        font-size: 13px;
    }

    .mlp-upload-thumb {
        width: 40px; height: 40px;
        border-radius: 6px;
        object-fit: cover;
        border: 1px solid #e3e5e8;
        flex-shrink: 0;
    }

    .mlp-upload-name { font-weight: 500; color: #202223; }
    .mlp-upload-size { font-size: 12px; color: #8c9196; margin-top: 1px; }

    .mlp-progress-bar-bg {
        flex: 1;
        height: 5px;
        background: #e3e5e8;
        border-radius: 99px;
        overflow: hidden;
    }

    .mlp-progress-bar-fill {
        height: 100%;
        background: #303d89;
        border-radius: 99px;
        transition: width .3s;
    }

    .mlp-upload-status {
        font-size: 11.5px;
        font-weight: 600;
        white-space: nowrap;
    }

    .mlp-upload-status.done  { color: #007a5e; }
    .mlp-upload-status.error { color: #b22222; }
    .mlp-upload-status.uploading { color: #303d89; }

    /* ══ Library panel ══ */
    .mlp-lib-toolbar {
        padding: 12px 16px;
        border-bottom: 1px solid #e3e5e8;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: center;
        background: #fff;
        flex-shrink: 0;
    }

    .mlp-search-wrap {
        position: relative;
        flex: 1;
        min-width: 180px;
    }

    .mlp-search-wrap i {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #8c9196;
        font-size: 12px;
        pointer-events: none;
    }

    .mlp-search {
        width: 100%;
        height: 34px;
        border: 1px solid #e3e5e8;
        border-radius: 8px;
        padding: 0 10px 0 30px;
        font-size: 13px;
        color: #202223;
        background: #fff;
        outline: none;
        font-family: inherit;
        transition: border-color .15s, box-shadow .15s;
    }

    .mlp-search:focus {
        border-color: #303d89;
        box-shadow: 0 0 0 3px rgba(48,61,137,.1);
    }

    .mlp-filter {
        height: 34px;
        border: 1px solid #e3e5e8;
        border-radius: 8px;
        padding: 0 10px;
        font-size: 13px;
        color: #202223;
        background: #fff;
        outline: none;
        font-family: inherit;
        cursor: pointer;
        transition: border-color .15s;
    }

    .mlp-filter:focus { border-color: #303d89; }

    /* Library grid */
    .mlp-lib-body {
        flex: 1;
        overflow-y: auto;
        padding: 16px;
    }

    .mlp-lib-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
        gap: 10px;
    }

    .mlp-lib-item {
        border: 2px solid #e3e5e8;
        border-radius: 10px;
        overflow: hidden;
        cursor: pointer;
        transition: border-color .15s, box-shadow .15s;
        position: relative;
        background: #fff;
    }

    .mlp-lib-item:hover {
        border-color: #303d89;
        box-shadow: 0 0 0 2px rgba(48,61,137,.1);
    }

    .mlp-lib-item.selected {
        border-color: #303d89;
        box-shadow: 0 0 0 3px rgba(48,61,137,.2);
    }

    .mlp-lib-item-check {
        position: absolute;
        top: 6px; right: 6px;
        width: 20px; height: 20px;
        border-radius: 50%;
        background: #303d89;
        color: #fff;
        display: none;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        z-index: 2;
        box-shadow: 0 1px 4px rgba(48,61,137,.4);
    }

    .mlp-lib-item.selected .mlp-lib-item-check { display: flex; }

    .mlp-lib-img-wrap {
        width: 100%;
        aspect-ratio: 1;
        background: #f1f2f4;
        overflow: hidden;
    }

    .mlp-lib-img-wrap img {
        width: 100%; height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .2s;
    }

    .mlp-lib-item:hover .mlp-lib-img-wrap img { transform: scale(1.05); }

    .mlp-lib-item-info {
        padding: 6px 8px;
        border-top: 1px solid #e3e5e8;
    }

    .mlp-lib-item-name {
        font-size: 11.5px;
        font-weight: 500;
        color: #202223;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .mlp-lib-item-size {
        font-size: 10.5px;
        color: #8c9196;
        margin-top: 1px;
    }

    /* Lazy load spinner */
    .mlp-load-more {
        text-align: center;
        padding: 20px;
        color: #8c9196;
        font-size: 13px;
    }

    /* ══ Footer ══ */
    .mlp-footer {
        padding: 14px 22px;
        border-top: 1px solid #e3e5e8;
        background: #fafafa;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-shrink: 0;
        flex-wrap: wrap;
    }

    .mlp-selected-info {
        font-size: 13px;
        color: #6d7175;
    }

    .mlp-selected-info strong { color: #303d89; }

    .mlp-footer-actions { display: flex; gap: 8px; }

    .mlp-btn-primary {
        display: inline-flex; align-items: center; gap: 6px;
        background: #303d89; color: #fff;
        border: none; border-radius: 8px;
        padding: 9px 20px; font-size: 13px; font-weight: 600;
        cursor: pointer; font-family: inherit;
        transition: background .15s;
        box-shadow: 0 1px 3px rgba(48,61,137,.25);
    }

    .mlp-btn-primary:hover { background: #252f70; }
    .mlp-btn-primary:disabled { opacity: .5; cursor: not-allowed; }

    .mlp-btn-secondary {
        display: inline-flex; align-items: center; gap: 6px;
        background: #fff; color: #202223;
        border: 1px solid #e3e5e8; border-radius: 8px;
        padding: 9px 18px; font-size: 13px; font-weight: 500;
        cursor: pointer; font-family: inherit;
        transition: background .15s;
    }

    .mlp-btn-secondary:hover { background: #f1f2f4; }

    /* ══ Empty state ══ */
    .mlp-empty {
        text-align: center;
        padding: 48px 20px;
        color: #8c9196;
    }

    .mlp-empty i {
        font-size: 36px;
        color: #e3e5e8;
        display: block;
        margin-bottom: 12px;
    }

    .mlp-empty p { font-size: 13.5px; color: #6d7175; margin: 4px 0 0; }

    @media(max-width: 640px) {
        .mlp-modal { max-height: 95vh; border-radius: 12px; }
        .mlp-lib-grid { grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); }
    }
</style>

<!-- ══════════════════════════════════
     MEDIA POPUP MARKUP
══════════════════════════════════ -->
<div class="mlp-overlay" id="mlpOverlay" onclick="mlpCloseOnBg(event)">
    <div class="mlp-modal">

        <!-- Header -->
        <div class="mlp-header">
            <h4><i class="fa fa-photo-film"></i> Media Library</h4>
            <button class="mlp-close" onclick="closeMediaPopup()"><i class="fa fa-xmark"></i></button>
        </div>

        <!-- Tabs -->
        <div class="mlp-tabs">
            <button class="mlp-tab active" id="mlpTabUpload" onclick="mlpSwitchTab('upload')">
                <i class="fa fa-upload"></i> Upload New
            </button>
            <button class="mlp-tab" id="mlpTabLibrary" onclick="mlpSwitchTab('library')">
                <i class="fa fa-images"></i> Choose from Library
                <span id="mlpTotalCount" style="background:#f0f1fc;color:#303d89;padding:1px 7px;border-radius:10px;font-size:11px;font-weight:700;margin-left:2px">842</span>
            </button>
        </div>

        <!-- ── UPLOAD PANEL ── -->
        <div class="mlp-panel active" id="mlpPanelUpload">
            <div class="mlp-upload-body">

                <div class="mlp-dropzone" id="mlpDropzone">
                    <input type="file" multiple accept="image/*,application/pdf" id="mlpFileInput" onchange="mlpHandleFiles(this.files)">
                    <i class="fa fa-cloud-arrow-up mlp-dropzone-icon"></i>
                    <p>Drag & drop files here</p>
                    <div class="mlp-dropzone-or">or</div>
                    <small>Supports JPG, PNG, WebP, SVG, PDF &nbsp;·&nbsp; Max 10 MB per file</small>
                </div>

                <!-- Upload queue — populated by JS -->
                <div class="mlp-upload-queue" id="mlpUploadQueue"></div>

            </div>
        </div>

        <!-- ── LIBRARY PANEL ── -->
        <div class="mlp-panel" id="mlpPanelLibrary">

            <!-- Toolbar -->
            <div class="mlp-lib-toolbar">
                <div class="mlp-search-wrap">
                    <i class="fa fa-search"></i>
                    <input type="text" class="mlp-search" id="mlpSearch" placeholder="Search filename or alt text…" oninput="mlpFilterItems()">
                </div>
                <select class="mlp-filter" id="mlpFilterType" onchange="mlpFilterItems()">
                    <option value="">All Types</option>
                    <option value="image">Images</option>
                    <option value="pdf">PDFs</option>
                </select>
                <select class="mlp-filter" id="mlpFilterUsage" onchange="mlpFilterItems()">
                    <option value="">All Files</option>
                    <option value="used">In Use</option>
                    <option value="unused">Unused</option>
                </select>
                <select class="mlp-filter" id="mlpFilterSort">
                    <option value="newest">Newest First</option>
                    <option value="oldest">Oldest First</option>
                    <option value="name">Name A–Z</option>
                    <option value="size">Largest First</option>
                </select>
            </div>

            <!-- Grid -->
            <div class="mlp-lib-body" id="mlpLibBody" onscroll="mlpOnScroll()">
                <div class="mlp-lib-grid" id="mlpLibGrid">

                    <!-- Items rendered by JS from mlpItems array below -->

                </div>
                <div class="mlp-load-more" id="mlpLoadMore" style="display:none">
                    <i class="fa fa-spinner fa-spin"></i> Loading more…
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mlp-footer">
            <div class="mlp-selected-info" id="mlpSelInfo">No file selected</div>
            <div class="mlp-footer-actions">
                <button class="mlp-btn-secondary" onclick="closeMediaPopup()">Cancel</button>
                <button class="mlp-btn-primary" id="mlpInsertBtn" disabled onclick="mlpInsertSelected()">
                    <i class="fa fa-circle-check"></i> Insert Selected
                </button>
            </div>
        </div>

    </div>
</div>

<script>
// ══════════════════════════════════════════════════════
//  MEDIA LIBRARY POPUP — Core JS
// ══════════════════════════════════════════════════════

// Callback set by the opener
let mlpCallback = null;

// Currently selected item
let mlpSelected = null;

// ── Open / Close ──
function openMediaPopup(callback) {
    mlpCallback = callback || null;
    mlpSelected = null;
    mlpUpdateFooter();
    document.getElementById('mlpOverlay').classList.add('open');
    document.body.style.overflow = 'hidden';
    // Default to library tab when opening (most common action)
    mlpSwitchTab('library');
    mlpRenderGrid();
}

function closeMediaPopup() {
    document.getElementById('mlpOverlay').classList.remove('open');
    document.body.style.overflow = '';
}

function mlpCloseOnBg(e) {
    if (e.target === document.getElementById('mlpOverlay')) closeMediaPopup();
}

// ── Tab switch ──
function mlpSwitchTab(tab) {
    document.getElementById('mlpPanelUpload').classList.toggle('active', tab === 'upload');
    document.getElementById('mlpPanelLibrary').classList.toggle('active', tab === 'library');
    document.getElementById('mlpTabUpload').classList.toggle('active', tab === 'upload');
    document.getElementById('mlpTabLibrary').classList.toggle('active', tab === 'library');
}

// ── Sample data (replace with AJAX from backend) ──
const mlpItems = [
    { id:1,  name:'product-red-shoes.jpg',      url:'/storage/media/product-red-shoes.jpg',      thumb:'https://placehold.co/130x130/f0f1fc/303d89?text=IMG',   size:'148 KB',  type:'image', usage:'used',   alt:'Red sports shoes product image' },
    { id:2,  name:'banner-summer.jpg',           url:'/storage/media/banner-summer.jpg',           thumb:'https://placehold.co/130x130/fff5cc/916a00?text=IMG',   size:'2.1 MB',  type:'image', usage:'unused', alt:'' },
    { id:3,  name:'category-electronics.png',    url:'/storage/media/category-electronics.png',   thumb:'https://placehold.co/130x130/e3f1ec/007a5e?text=IMG',   size:'320 KB',  type:'image', usage:'used',   alt:'Electronics category cover' },
    { id:4,  name:'blog-hero-fashion.jpg',       url:'/storage/media/blog-hero-fashion.jpg',       thumb:'https://placehold.co/130x130/e8f2ff/0069d9?text=IMG',   size:'890 KB',  type:'image', usage:'used',   alt:'Fashion blog hero image' },
    { id:5,  name:'old-logo-2022.png',           url:'/storage/media/old-logo-2022.png',           thumb:'https://placehold.co/130x130/fce8e8/b22222?text=IMG',   size:'44 KB',   type:'image', usage:'unused', alt:'' },
    { id:6,  name:'product-blue-jeans.jpg',      url:'/storage/media/product-blue-jeans.jpg',      thumb:'https://placehold.co/130x130/f0f1fc/303d89?text=IMG',   size:'210 KB',  type:'image', usage:'used',   alt:'Blue denim jeans product' },
    { id:7,  name:'size-guide.pdf',              url:'/storage/media/size-guide.pdf',              thumb:null,                                                     size:'1.2 MB',  type:'pdf',   usage:'used',   alt:'Size guide PDF' },
    { id:8,  name:'test-upload-draft.jpg',       url:'/storage/media/test-upload-draft.jpg',       thumb:'https://placehold.co/130x130/f1f2f4/8c9196?text=IMG',   size:'56 KB',   type:'image', usage:'unused', alt:'' },
    { id:9,  name:'product-white-tshirt.jpg',    url:'/storage/media/product-white-tshirt.jpg',    thumb:'https://placehold.co/130x130/f0f1fc/303d89?text=IMG',   size:'195 KB',  type:'image', usage:'used',   alt:'White cotton t-shirt product' },
    { id:10, name:'homepage-banner.jpg',         url:'/storage/media/homepage-banner.jpg',         thumb:'https://placehold.co/130x130/e3f1ec/007a5e?text=IMG',   size:'1.8 MB',  type:'image', usage:'used',   alt:'Homepage hero banner' },
    { id:11, name:'category-footwear.jpg',       url:'/storage/media/category-footwear.jpg',       thumb:'https://placehold.co/130x130/e8f2ff/0069d9?text=IMG',   size:'280 KB',  type:'image', usage:'used',   alt:'Footwear category image' },
    { id:12, name:'blog-thumbnail-style.jpg',    url:'/storage/media/blog-thumbnail-style.jpg',    thumb:'https://placehold.co/130x130/fff5cc/916a00?text=IMG',   size:'410 KB',  type:'image', usage:'unused', alt:'' },
];

// ── Render grid ──
function mlpRenderGrid() {
    const q     = (document.getElementById('mlpSearch')?.value || '').toLowerCase();
    const type  = document.getElementById('mlpFilterType')?.value  || '';
    const usage = document.getElementById('mlpFilterUsage')?.value || '';

    const filtered = mlpItems.filter(item => {
        const nameMatch  = item.name.toLowerCase().includes(q) || item.alt.toLowerCase().includes(q);
        const typeMatch  = !type  || item.type  === type;
        const usageMatch = !usage || item.usage === usage;
        return nameMatch && typeMatch && usageMatch;
    });

    const grid = document.getElementById('mlpLibGrid');

    if (filtered.length === 0) {
        grid.innerHTML = `<div class="mlp-empty" style="grid-column:1/-1">
            <i class="fa fa-images"></i>
            <strong>No files found</strong>
            <p>Try a different search term or upload new files.</p>
        </div>`;
        return;
    }

    grid.innerHTML = filtered.map(item => `
        <div class="mlp-lib-item ${mlpSelected?.id === item.id ? 'selected' : ''}"
             data-id="${item.id}"
             data-type="${item.type}"
             data-usage="${item.usage}"
             data-name="${item.name}"
             onclick="mlpSelectItem(${item.id})">
            <div class="mlp-lib-item-check"><i class="fa fa-check"></i></div>
            <div class="mlp-lib-img-wrap">
                ${item.thumb
                    ? `<img src="${item.thumb}" loading="lazy" alt="${item.alt || item.name}">`
                    : `<div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:#fff5f5">
                            <i class="fa fa-file-pdf" style="font-size:40px;color:#b22222"></i>
                       </div>`
                }
            </div>
            <div class="mlp-lib-item-info">
                <div class="mlp-lib-item-name">${item.name}</div>
                <div class="mlp-lib-item-size">${item.size}</div>
            </div>
        </div>
    `).join('');
}

// ── Filter ──
function mlpFilterItems() { mlpRenderGrid(); }

// ── Select item ──
function mlpSelectItem(id) {
    mlpSelected = mlpItems.find(i => i.id === id) || null;
    document.querySelectorAll('.mlp-lib-item').forEach(el => {
        el.classList.toggle('selected', parseInt(el.dataset.id) === id);
    });
    mlpUpdateFooter();
}

function mlpUpdateFooter() {
    const info = document.getElementById('mlpSelInfo');
    const btn  = document.getElementById('mlpInsertBtn');
    if (mlpSelected) {
        info.innerHTML = `<strong>${mlpSelected.name}</strong> &nbsp;·&nbsp; ${mlpSelected.size}`;
        btn.disabled = false;
    } else {
        info.textContent = 'No file selected';
        btn.disabled = true;
    }
}

// ── Insert ──
function mlpInsertSelected() {
    if (!mlpSelected) return;
    if (typeof mlpCallback === 'function') {
        mlpCallback(mlpSelected);
    }
    closeMediaPopup();
}

// ── Lazy scroll (load more placeholder) ──
function mlpOnScroll() {
    const body = document.getElementById('mlpLibBody');
    if (body.scrollTop + body.clientHeight >= body.scrollHeight - 40) {
        // In production: fire AJAX to fetch next page and append items
    }
}

// ── Upload handler ──
function mlpHandleFiles(files) {
    const queue = document.getElementById('mlpUploadQueue');
    Array.from(files).forEach((file, i) => {
        const id = 'upl_' + Date.now() + '_' + i;
        const isImg = file.type.startsWith('image/');
        const reader = new FileReader();

        const el = document.createElement('div');
        el.className = 'mlp-upload-item';
        el.id = id;
        el.innerHTML = `
            ${isImg
                ? `<img src="" class="mlp-upload-thumb" id="thumb_${id}" alt="">`
                : `<div style="width:40px;height:40px;border-radius:6px;background:#fff5f5;display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="fa fa-file-pdf" style="color:#b22222;font-size:20px"></i></div>`
            }
            <div style="flex:1;min-width:0">
                <div class="mlp-upload-name">${file.name}</div>
                <div class="mlp-upload-size">${mlpFormatSize(file.size)}</div>
            </div>
            <div class="mlp-progress-bar-bg" style="width:120px">
                <div class="mlp-progress-bar-fill" id="prog_${id}" style="width:0%"></div>
            </div>
            <div class="mlp-upload-status uploading" id="status_${id}">0%</div>
        `;
        queue.prepend(el);

        if (isImg) {
            reader.onload = e => {
                const img = document.getElementById('thumb_' + id);
                if (img) img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }

        // Simulate upload progress
        let progress = 0;
        const interval = setInterval(() => {
            progress += Math.random() * 20;
            if (progress >= 100) {
                progress = 100;
                clearInterval(interval);
                document.getElementById('prog_' + id).style.width = '100%';
                document.getElementById('prog_' + id).style.background = '#007a5e';
                const st = document.getElementById('status_' + id);
                st.textContent = '✓ Done';
                st.className = 'mlp-upload-status done';
                // In production: after real upload success, add item to mlpItems and re-render
            } else {
                document.getElementById('prog_' + id).style.width = Math.min(progress, 100) + '%';
                document.getElementById('status_' + id).textContent = Math.round(progress) + '%';
            }
        }, 180);
    });
}

function mlpFormatSize(bytes) {
    if (bytes < 1024)       return bytes + ' B';
    if (bytes < 1048576)    return (bytes / 1024).toFixed(0) + ' KB';
    return (bytes / 1048576).toFixed(1) + ' MB';
}

// ── Drag & drop on upload panel ──
const mlpDz = document.getElementById('mlpDropzone');
if (mlpDz) {
    mlpDz.addEventListener('dragover',  e => { e.preventDefault(); mlpDz.classList.add('dragover'); });
    mlpDz.addEventListener('dragleave', ()  => mlpDz.classList.remove('dragover'));
    mlpDz.addEventListener('drop', e => {
        e.preventDefault();
        mlpDz.classList.remove('dragover');
        mlpHandleFiles(e.dataTransfer.files);
    });
}
</script>


{{--
════════════════════════════════════════════════════════
  USAGE EXAMPLE — paste this on product/category/blog
  create or edit pages wherever image upload is needed
════════════════════════════════════════════════════════

<!-- Hidden field to store selected media ID -->
<input type="hidden" name="image_id" id="image_id" value="">

<!-- Image preview box -->
<div id="imagePreviewBox" style="display:none;margin-bottom:12px">
    <img id="imagePreview" src="" alt="Selected image"
         style="width:100%;max-width:240px;border-radius:8px;border:1px solid #e3e5e8;object-fit:cover">
    <button type="button" onclick="clearSelectedMedia()"
            style="display:block;margin-top:6px;font-size:12px;color:#b22222;background:none;border:none;cursor:pointer">
        <i class="fa fa-xmark"></i> Remove
    </button>
</div>

<!-- Upload trigger buttons -->
<div style="display:flex;gap:8px;flex-wrap:wrap">
    <button type="button" class="btn-primary-dash" onclick="openMediaPopup(function(file){
        document.getElementById('imagePreview').src       = file.thumb || file.url;
        document.getElementById('image_id').value         = file.id;
        document.getElementById('imagePreviewBox').style.display = 'block';
    })">
        <i class="fa fa-photo-film"></i> Choose from Library
    </button>

    <label class="btn-secondary-dash" style="cursor:pointer">
        <i class="fa fa-upload"></i> Upload New
        <input type="file" accept="image/*" style="display:none" onchange="handleDirectUpload(this)">
    </label>
</div>

<script>
function clearSelectedMedia() {
    document.getElementById('image_id').value = '';
    document.getElementById('imagePreview').src = '';
    document.getElementById('imagePreviewBox').style.display = 'none';
}

function handleDirectUpload(input) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('imagePreview').src = e.target.result;
        document.getElementById('imagePreviewBox').style.display = 'block';
    };
    reader.readAsDataURL(file);
    // In production: also AJAX upload to server and set image_id
}
</script>