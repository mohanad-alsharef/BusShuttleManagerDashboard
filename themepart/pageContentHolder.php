<!-- Page Content Holder -->
<div id="content">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">

            <button type="button" id="sidebarCollapse" class="navbar-btn">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <h3><?php if(isset($_SESSION["Title"])){echo $_SESSION["Title"];} ?></h3>
        </div>
    </nav>