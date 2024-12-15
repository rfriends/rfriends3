/*
 * jQuery Image Gallery Demo JS 3.0.1
 * https://github.com/blueimp/jQuery-Image-Gallery
 *
 * Copyright 2013, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */
/*jslint unparam: true, regexp: true */
/*global $ */
$(function() {
    'use strict';
    // Initialize the slideshow button:
    $('#slideshow-button').button({
        icons: {
            primary: 'ui-icon-image'
        }
    }).on('click', function() {
        $('#blueimp-gallery-dialog .blueimp-gallery').data(
            'startSlideshow', true);
        $('#links').children().first().click();
    });
});