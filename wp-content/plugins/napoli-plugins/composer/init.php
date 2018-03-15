<?php
global $vc_manager;
$vc_manager->setIsAsTheme();
$vc_manager->disableUpdater();
$vc_manager->setEditorDefaultPostTypes( array( 'page', 'post', 'portfolio' ) );
$vc_manager->automapper()->setDisabled();