<section class="ori-tools">
    <div class="toast">
        <button class="btn btn-clear float-right"></button>
        <p></p>
    </div>
    <div class="modal modal-sm">
        <a class="modal-overlay"></a>
        <div class="modal-container">
            <div class="modal-header">
                <div class="modal-title h5"></div>
            </div>
            <div class="modal-body">
                <div class="content"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary confirm">确认</button>
                <button class="btn btn-link cancel">取消</button>
            </div>
        </div>
    </div>
    <div id="toc-button" class="tools-item" title="显示文章目录(点击显示或隐藏)">
        <i class="fa fa-indent fa-2x" aria-hidden="true"></i>
        <div class="toc"></div>
    </div>
    <div id="qrcode" class="tools-item" title="阅读转移"><div id="qrcode-img"></div><i class="fa fa-laptop fa-2x" aria-hidden="true"></i></div>
    <div id="if-to-start">
        <span>已跳转到上次阅读的位置，从头阅读？</span>
        <a class="btn" href="javascript:notToStart();">否</a>
        <a class="btn" href="javascript:toStart();">是</a>
    </div>
    <div id="live-chat">
        <ul class="live-chat-list">
        </ul>
        <div class="live-chat-input">
            <i class="icon icon-arrow-left"></i>
            <input type="text" class="form-input" placeholder="输入昵称与大佬们交流">
            <button class="btn">开始搞事</button>
        </div>
    </div>
</section>