<?php

//# Test importer
function droswavosw_pnl_test_importer_settings_page() {?>
    <div class="wrap">
        <h1>Import Panel form</h1>
    </div>
    <?php settings_fields( 'droswavosw_pnl_test_importer_settings_page' ); ?>
    <?php do_settings_sections( 'droswavosw_pnl_test_importer_settings_page' ); ?>
    <button>Test importer</button>
    <?php
}