<?php
return
'
#custom-phone-grid {
  display: none;
}

#footer-custom-phone-grid {
  display: none;
}

.cover-region-phone,
.cover-region-placeholder-phone {
  display: none;
}

.sitetitle.txt .sitetitle-txt-inner {
  margin-top: 0;
  margin-bottom: 0;
}

.row._100vh,
.row._100vh.empty {
  min-height: 100vh;
}
.row._100vh .row-inner,
.row._100vh .column-wrap,
.row._100vh.empty .row-inner,
.row._100vh.empty .column-wrap {
  min-height: 100vh;
}

nav.laynav li {
  display: inline-block;
}

nav.laynav {
  white-space: nowrap;
}

.lay-mobile-icons-wrap {
  display: none;
  white-space: nowrap;
}

.mobile-title {
  display: none;
}

.navbar {
  position: fixed;
  z-index: 10;
  width: 100%;
  transform: translateZ(0);
}

nav.mobile-nav {
  display: none;
}

.sitetitle.txt .sitetitle-txt-inner span,
nav.laynav span {
  text-decoration-style: underline;
}

.col.align-top {
  align-self: start;
}

.col.align-onethird {
  align-self: start;
}

.col.align-middle {
  align-self: center;
}

.col.align-twothirds {
  align-self: end;
}

.col.align-bottom {
  align-self: end;
}

.cover-region {
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  width: 100%;
  height: 100vh;
  will-change: transform;
}

.lay-sitewide-background-video-mobile {
  display: none;
}

.cover-down-arrow-desktop {
  display: block;
}

.cover-down-arrow-phone {
  display: none;
}

.col.type-vl.absolute-position {
  position: absolute !important;
  margin-left: 0 !important;
  z-index: 1;
}

/* 

100VH rows 

*/
.column-wrap._100vh > .col.absolute-position:not(.lay-sticky) {
  position: absolute !important;
  margin-left: 0 !important;
}

.column-wrap._100vh > .col.absolute-position.align-top:not(.lay-sticky) {
  top: 0;
}

.column-wrap._100vh > .col.absolute-position.align-bottom:not(.lay-sticky) {
  bottom: 0;
}

._100vh:not(.stack-element) > .type-html {
  position: absolute !important;
  margin-left: 0 !important;
  z-index: 1;
}

._100vh:not(.stack-element) > .type-html.align-top {
  top: 0;
}

._100vh:not(.stack-element) > .type-html.align-middle {
  top: 50%;
  transform: translateY(-50%);
}

._100vh:not(.stack-element) > .type-html.align-bottom {
  bottom: 0;
}

/* 

CUSTOM ROW HEIGHT 

*/
.column-wrap.rowcustomheight > .col.absolute-position:not(.lay-sticky) {
  position: absolute !important;
  margin-left: 0 !important;
  z-index: 1;
}

.rowcustomheight:not(.stack-element) > .type-html {
  position: absolute !important;
  margin-left: 0 !important;
  z-index: 1;
}

.rowcustomheight:not(.stack-element) > .type-html.align-top {
  top: 0;
}

.rowcustomheight:not(.stack-element) > .type-html.align-middle {
  top: 50%;
  transform: translateY(-50%);
}

.rowcustomheight:not(.stack-element) > .type-html.align-bottom {
  bottom: 0;
}
';