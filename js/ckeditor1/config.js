/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	config.plugins = 'equation/eqneditor';
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.font_names = 'KrutiDev10/Kruti;' + config.font_names;
	config.font_names = 'Devlys_010/Devlys;' + config.font_names;
};
